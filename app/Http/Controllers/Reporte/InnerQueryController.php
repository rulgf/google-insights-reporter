<?php

namespace App\Http\Controllers\Reporte;

use App\ColumnasIgnore;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Validator;
use App\Cuentas;
use App\Reporte;
use App\Query;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use LaravelAnalytics;
use Illuminate\Support\Facades\DB;

class InnerQueryController extends Controller
{
    //Obtengo las queries de un reporte en especifico
    public function getQueries($cuenta_id, $reporte_name){
        $idSite=Cuentas::where('siteId', $cuenta_id)->get()->first();

        $reporte_id=Reporte::where('nombre', $reporte_name)->where('cuenta_id', $idSite->id)->get()->first();

        $queries = Query::with('metrica')
            ->with('dimension')
            ->with('segmentos')
            ->with('columnsIgnore')
            ->where('reporte_id', $reporte_id->id)->get();

        return $queries;
    }

    //Obtengo la info de cada query
    public function getQuery($id){
        $queries = Query::with('metrica.tipo')
            ->with('dimension.tipo')
            ->with('segmentos')
            ->with('columnsIgnore')
            ->where('id', $id)->get()->first();

        return $queries;
    }

    //Creo una nueva Query
    public function createQuery(Request $request, $cuenta_id, $reporte_name){
        $validator = Validator::make($request->all(), [
            'metrics' => 'required',
            'nombre' => 'required'
        ]);

        //Recupero el sitio y al reporte que pertenece
        $idSite=Cuentas::where('siteId', $cuenta_id)->get()->first();

        $reporte_id=Reporte::where('nombre', $reporte_name)->where('cuenta_id', $idSite->id)->get()->first();
        
        $cuentasNombre= Query::where('nombre', $request->nombre)->get();

        foreach ($cuentasNombre as $cuenta){
            $validator->sometimes('nombre','unique:query',function($input) use ($cuenta) {
                return $input->reporte_id == $cuenta->reporte_id;
            });
        }

        $validator->sometimes('max_result', 'required', function ($input){
            //dd($input);
            return count($input->dimensions) > 0;
        });

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->messages()->all(), 200));
        }

        //dd($request->max_result);
        //Transacción para guardar registros
        DB::transaction(function() use ($reporte_id, $request) {

            $prueba = Query::store($request, $reporte_id->id);

            $newQuery = Query::where('id', $prueba->id)->get()->first();

            //Relaciono Metricas
            foreach ($request->metrics as $metrica){
                $newQuery->metrica()->attach($metrica['value']);
            }

            if ($request->dimensions){
                //Relaciono Dimensiones
                foreach ($request->dimensions as $dimension){
                    $newQuery->dimension()->attach($dimension['value']);
                }
            }

            if($request->segment){
                //Relaciono Segmentos
                foreach ($request->segment as $segments){
                    $newQuery->segmentos()->attach($segments['value']);
                }
            }

            if($request->columnasignore){
                //Creo el registro de la columna
                foreach ($request->columnasignore as $columnignore){
                    ColumnasIgnore::store($columnignore, $newQuery->id);
                }
            }
        });

            return response()->json(['success' => true]);
    }

    //Edito una Query
    public function editQuery(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'metrics' => 'required',
            'nombre' => 'required'
        ]);

        //Recupero el nombre

        $name=Query::where('id', $id)->get()->first();


        //Reviso si el nombre fue modificado
        if($name->nombre != $request->nombre){
            // El nombre cambio
            $cuentasNombre= Query::where('nombre', $request->nombre)->get();

            foreach ($cuentasNombre as $cuenta){
                $validator->sometimes('nombre','unique:query',function($input) use ($cuenta) {
                    return $input->reporte_id == $cuenta->reporte_id;
                });
            }
        }

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->messages()->all(), 200));
        }

        //Transacción para guardar registros
        DB::transaction(function() use ($id, $request) {

            $editQuery = Query::where('id', $id)->first();

            $editQuery->nombre = $request->nombre;
            $editQuery->max_results = $request->max_result;
            $editQuery->sort = $request->sort[0]['label'];
            $editQuery->filtro = $request->filters;
            //$editQuery->operando_metricas = $request->operando_metricas;
            //$editQuery->operando_total = $request->operando_total;
            $editQuery->save();

            //Relaciono Metricas
            $editQuery->metrica()->detach();
            foreach ($request->metrics as $metrica){
                $editQuery->metrica()->attach($metrica['value']);
            }

            //Relaciono Dimensiones
            $editQuery->dimension()->detach();
            if ($request->dimensions) {
                foreach ($request->dimensions as $dimension) {
                    $editQuery->dimension()->attach($dimension['value']);
                }
            }

            //Relaciono Segmentos
            $editQuery->segmentos()->detach();
            if ($request->segment) {
                foreach ($request->segment as $segments) {
                    $editQuery->segmentos()->attach($segments['value']);
                }
            }

            //Creo el registro de la columna
            $columnasIg = ColumnasIgnore::where('query_id', $id)->get();
            foreach ($columnasIg as $column){
                ColumnasIgnore::destroy($column->id);
            }
            if($request->columnasignore){
                foreach ($request->columnasignore as $columnignore){
                    ColumnasIgnore::store($columnignore, $id);
                }
            }

        });

        return response()->json(['success' => true]);
    }

    //Elimino una Query
    public function deleteQuery(Request $request, $id){
        $deleteQuery = Query::where('id', $id)->first();
        $deleteQuery->metrica()->detach();
        $deleteQuery->dimension()->detach();
        $deleteQuery->segmentos()->detach();

        $columnasIg = ColumnasIgnore::where('query_id', $id)->get();
        foreach ($columnasIg as $column){
            ColumnasIgnore::destroy($column->id);
        }

        Query::destroy($request->id);
        return response()->json(['success' => true]);
    }

    //Ejecución de una query interna

    public function execInnerQuery(Request $request){
        $validator = Validator::make($request->all(), [
            'metrics' => 'required',
            'siteId' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->messages()->all(), 200));
        }

        $startDate=Carbon::yesterday('America/Mexico_City')->addDays(-1);
        $endDate=Carbon::yesterday('America/Mexico_City')->addDays(-1);

        //Guardo en un array los headers del query--------------------------------------
        $headers=[];
        $key = 0;
        //Reviso si hay dimensiones
        if($request->dimensions){
            $dimensions = $request->dimensions;
            foreach ($request->dimensions as $head){
                $headers=array_add($headers, $key, $head);
                $key++;
            }
        }else{
            $dimensions =[];
        }
        //Guardo las metricas
        foreach ($request->metrics as $head){
            $headers=array_add($headers,$key, $head);
            $key++;
        }

        //Reviso que los parametros sort filters y segment  tengan contenido-----------------------
        if ($request->sort){
            $sort=$request->sort[0]['label'];
        }else{
            $sort=null;
        }

        if($request->filters){
            $filters= $request->filters;
        }else{
            $filters=null;
        }

        if($request->segment){
            $segment= $request->segment[0]['label'];
        }else{
            $segment=null;
        }

        if($request->maxResult){
            $max= $request->maxResult;
        }else{
            $max=null;
        }
        //Armo el array 'otros' para el Query--------------------------------------------
        $others=[
            'dimensions' => implode( ',' , $dimensions),
            'sort' => $sort,
            'filters' => $filters,
            'segment' => $segment,
            'max-results' => $max,
        ];

        //Compruebo que el Query se ejecuto correctamente----------------------------------
        try{
            //Guardo la ejecución del query en una variable
            $analyticsData = LaravelAnalytics::setSiteId($request->siteId)->performQuery(
                $startDate,
                $endDate,
                implode(',',$request->metrics),
                $others
            );
        }catch (\Exception $e){
            $error =["La query no se pudo ejecutar: revisa los campos"];
            return response()->json(array('errors' => $error, 200));
        }

        //Cambio de formatos para fecha hora y dinero------------------------------------------------
        $resultRows = $analyticsData->rows; //variable con el resultado de la query

        //Cambiar formato a los campos fecha
        if(in_array('ga:date', $headers)){
            $datePosition = array_search('ga:date', $headers);
            foreach($resultRows as $key => $row){
                $resultRows[$key][$datePosition] = Carbon::createFromFormat('Ymd', $row[$datePosition])
                    ->toFormattedDateString();
            }
        }

        //Cambiar formato al campo dateHour
        if(in_array('ga:dateHour', $headers)){
            $datePosition = array_search('ga:dateHour', $headers);
            foreach($resultRows as $key => $row){
                $resultRows[$key][$datePosition] = Carbon::createFromFormat('YmdH', $row[$datePosition])
                    ->toDateTimeString();
            }
        }

        //Cambiar formato al campo yearMonth
        if(in_array('ga:yearMonth', $headers)){
            $datePosition = array_search('ga:yearMonth', $headers);
            foreach($resultRows as $key => $row){
                $resultRows[$key][$datePosition] = Carbon::createFromFormat('Ym', $row[$datePosition])
                    ->format('Y-m');
            }
        }

        //Cambiar formato al campo Hour
        if(in_array('ga:hour', $headers)){
            $datePosition = array_search('ga:hour', $headers);
            foreach($resultRows as $key => $row){
                $resultRows[$key][$datePosition] = Carbon::createFromFormat('H', $row[$datePosition])
                    ->format('h:00 A');
            }
        }
        
        return $resultRows;
    }
    
    
}
