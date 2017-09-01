<?php

namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Cuentas;
use App\Query;
use App\Reporte;
use LaravelAnalytics;
use Carbon\Carbon;

class consultReportealt extends Controller
{
    //Funcion principal del Reporte
    //Ejecuta todos los queries de un reporte, entre otras operaciones
    public function executeReporte($reporte_id, Request $request){

        //Obtener id de la cuenta
        $actual_report = Reporte::where('id', $reporte_id)->get()->first();
        $idsite = Cuentas::where('id', $actual_report->cuenta_id)->get()->first();

        //Variables a mandar
        $nameQueries = []; //Arreglo con los nombres de las columnas
        $datesQueries = []; //Arreglo con las fechas a ejecutar reporte
        $totalQueries = []; //Arreglo con el resumen
        $contentQueries = []; //Arreglo con el contenido del desglose
        $monthQueries = [];

        //Obtengo todos los queries relacionados a un reporte
        $queries = Query::where('reporte_id', $reporte_id)
            ->with('segmentos')
            ->with('dimension')
            ->with('metrica')
            ->with('columnsIgnore')
            ->get();

        //Recupero que tipo de reporte se eejcutara
        //1: por día
        //2: por semana
        //3: por mes

        $tipo= $request->tipo;
        //$tipo= 1;

        //Recupero el rango de fechas en los que se ejecutara el reporte
        $expression = '/\((.*)*\)/';
        $initialDate = preg_replace($expression, '', $request->startDate);
        $finalDate = preg_replace($expression, '', $request->endDate);


        $startDate=Carbon::parse($initialDate);
        $endDate=Carbon::parse($finalDate);
        //$startDate=Carbon::parse($request->startDate);
        //$endDate=Carbon::parse($request->endDate);
        //$startDate = Carbon::now()->addDays(-10);
        //$endDate = Carbon::now()->addDays(-2);

        if($tipo==1){
            //Tipo 1: reporte por día
            //Mostrar los resultados de cada dia
            //Mostrar acumulados por semana

            //Armo el arreglo de fechas
            //Tipo 1: Día a día
            while ($startDate->lte($endDate)) {

                $dates[] = $startDate->copy();
                array_push($datesQueries, $startDate->format('d/m/Y'));
                $startDate->addDay();

            }

            //Recorro cada query y obtengo sus datos para ser ejecutados
            foreach ($queries as $query){
                //Obtengo los datos para ejecutar el query
                $metricas = $this->getMetrics($query['metrica']);
                $dimensiones = $this->getDimensions($query['dimension']);
                $segmentos = $this->getSegments($query['segmentos']);
                $columnasIgnore = $this->getColumnasI($query['columnsIgnore']);
                $filtro = $query['filtro'];
                $maxResults = $query['max_results'];
                $sort = $query['sort'];

                //Obtengo el nombre de la columna
                array_push($nameQueries, $query['nombre']);

                //Por cada fecha ejecutar el query
                $finalQuery = [];
                $length = count($dates);
                for($i = 0; $i < $length; ++$i) {

                    array_push($finalQuery, $this->analyticQuery(current($dates),current($dates), $metricas,
                        $dimensiones, $segmentos, $columnasIgnore, $filtro, $maxResults, $sort, $idsite->siteId));

                    next($dates);

                }

                //Añado arrays vacios en caso de que el numero de rows no sea el mismo
                for($m = 0; $m < count($finalQuery); $m++){
                    if(count($finalQuery[$m]) < $maxResults){
                        while(count($finalQuery[$m]) < $maxResults){
                            array_push($finalQuery[$m], ["-", 0]);
                        }

                    }
                }

                array_push($contentQueries, $finalQuery);

                //Obtener resumen en un periodo
                array_push($totalQueries, $this->analyticQuery($dates[0], last($dates), $metricas, $dimensiones, $segmentos,
                    $columnasIgnore, $filtro, $maxResults, $sort, $idsite->siteId));

                reset($dates);
            }
            //dd($contentQueries);
            return([$contentQueries, $nameQueries, $datesQueries, $totalQueries]);
        }else if($tipo==2){
            //Tipo 2: reporte por semana
            //Mostrar los resultados de cada semana
            //Mostrar acumulados por mes

            //Armo el arreglo de fechas
            //Tipo 2: Semana a semana
            //El rango de fechas toma la semana de los dias seleccionados
            //El arreglo contiene los primeros dias de la semana, para obtener el ultimo dia restar un día a la siguiente posición
            $startDate->startOfWeek();
            $endDate->endOfWeek()->addDay();

            while ($startDate->lte($endDate)) {

                $dates[] = $startDate->copy();
                array_push($datesQueries, 'Semana ' . $startDate->weekOfMonth . ' ' . $startDate->format('M'));
                array_push($monthQueries, $startDate->format('F'));

                $startDate->addDays(7);
            }
            array_pop($datesQueries);
            reset($datesQueries);

            //Recorro cada query y obtengo sus datos para ser ejecutados
            foreach ($queries as $query){
                //Obtengo los datos para ejecutar el query
                $metricas = $this->getMetrics($query['metrica']);
                $dimensiones = $this->getDimensions($query['dimension']);
                $segmentos = $this->getSegments($query['segmentos']);
                $columnasIgnore = $this->getColumnasI($query['columnsIgnore']);
                $filtro = $query['filtro'];
                $maxResults = $query['max_results'];
                $sort = $query['sort'];

                //Obtengo el nombre del renglon
                array_push($nameQueries, $query['nombre']);

                //Por cada fecha ejecutar el query
                $finalQuery = [];
                $length = count($dates);
                for($i = 0; $i < $length - 1; ++$i) {
                    $next = $dates[$i+1]->addDays(-1);
                    array_push($finalQuery, $this->analyticQuery(current($dates), $next, $metricas,
                        $dimensiones, $segmentos, $columnasIgnore, $filtro, $maxResults, $sort, $idsite->siteId));
                    $dates[$i+1]->addDays(1);
                    next($dates);
                }

                //Añado arrays vacios en caso de que el numero de rows no sea el mismo
                for($m = 0; $m < count($finalQuery); $m++){
                    if(count($finalQuery[$m]) < $maxResults){
                        while(count($finalQuery[$m]) < $maxResults){
                            array_push($finalQuery[$m], ["-", 0]);
                        }

                    }
                }

                array_push($contentQueries, $finalQuery);

                array_push($totalQueries, $this->analyticQuery($dates[0], last($dates), $metricas, $dimensiones, $segmentos,
                    $columnasIgnore, $filtro, $maxResults, $sort, $idsite->siteId));

                reset($dates);
            }

            return[$contentQueries, $nameQueries, $datesQueries, $totalQueries];
        }else if($tipo==3){
            //Tipo 3: reporte por mes
            //mostrar los resultados por mes
            //Mostrar acumulados por año????*********

            //Armo el arreglo de fechas
            //Tipo 3: Mes a mes
            //El rango de fechas toma el mes de los dias seleccionados
            //El arreglo contiene los primeros dias del mes, para obtener el ultimo dia restar un día a la siguiente posición
            $startDate->startOfMonth();
            $endDate->endOfMonth()->addDay();

            while ($startDate->lte($endDate)) {

                $dates[] = $startDate->copy();
                array_push($datesQueries, $startDate->format('M'));

                $startDate->addMonth();
            }
            array_pop($datesQueries);

            //Recorro cada query y obtengo sus datos para ser ejecutados
            foreach ($queries as $query){
                //Obtengo los datos para ejecutar el query
                $metricas = $this->getMetrics($query['metrica']);
                $dimensiones = $this->getDimensions($query['dimension']);
                $segmentos = $this->getSegments($query['segmentos']);
                $columnasIgnore = $this->getColumnasI($query['columnsIgnore']);
                $filtro = $query['filtro'];
                $maxResults = $query['max_results'];
                $sort = $query['sort'];

                //Obtengo el nombre del renglon
                array_push($nameQueries, $query['nombre']);

                //Por cada fecha ejecutar el query
                $finalQuery = [];
                $length = count($dates);
                for($i = 0; $i < $length - 1; ++$i) {
                    $next = $dates[$i+1]->addDays(-1);
                    array_push($finalQuery, $this->analyticQuery(current($dates), $next, $metricas,
                        $dimensiones, $segmentos, $columnasIgnore, $filtro, $maxResults, $sort, $idsite->siteId));
                    $dates[$i+1]->addDays(1);
                    next($dates);
                }

                //Añado arrays vacios en caso de que el numero de rows no sea el mismo
                for($m = 0; $m < count($finalQuery); $m++){
                    if(count($finalQuery[$m]) < $maxResults){
                        while(count($finalQuery[$m]) < $maxResults){
                            array_push($finalQuery[$m], ["-", 0]);
                        }

                    }
                }

                array_push($contentQueries, $finalQuery);

                array_push($totalQueries, $this->analyticQuery($dates[0], last($dates), $metricas, $dimensiones, $segmentos,
                    $columnasIgnore, $filtro, $maxResults, $sort, $idsite->siteId));

                reset($dates);
            }
            return[$contentQueries, $nameQueries, $datesQueries, $totalQueries];
        }
    }

    //Funcion para obtener las claves de cada metrica para la ejecución del query
    private function getMetrics($metricas){
        $finalMets = [];
        foreach ($metricas as $metric){
            array_push($finalMets, $metric['clave']);
        }
        return $finalMets;
    }

    //Funcion para obtener las claves de cada dimension para la ejecución del query
    private function getDimensions($dimensiones){
        $finalDims = [];
        foreach ($dimensiones as $dimension){
            array_push($finalDims, $dimension['clave']);
        }
        return $finalDims;
    }

    //Función para obtener la clave de las columnas que seran eliminadas del query final
    private function getColumnasI($columnsI){
        $finalCol = [];
        foreach ($columnsI as $column){
            array_push($finalCol, $column['label']);
        }
        return $finalCol;
    }

    //Función para obtener las claves de cada segmento para la ejecución del query
    private function getSegments($segmentos){
        $finalSegs = [];
        foreach ($segmentos as $segmento){
            array_push($finalSegs, $segmento['clave']);
        }
        return $finalSegs;
    }

    //Función para adaptar los datos y ejecutar el query
    private function analyticQuery($fechaI, $fechaF, $metricas, $dimensiones, $segmentos,
                                   $columnasIgnore, $filtro, $maxResults, $sort, $siteId){

        $metricasq = implode(',', $metricas);

        //Guardo en un array los headers del query--------------------------------------
        $headers=[];
        $key = 0;
        //Reviso si hay dimensiones
        if($dimensiones){
            $dimensionsq = $dimensiones;
            foreach ($dimensionsq as $head){
                $headers=array_add($headers, $key, $head);
                $key++;
            }
        }else{
            $dimensionsq =[];
        }

        //Guardo las metricas
        foreach ($metricas as $head){
            $headers=array_add($headers,$key, $head);
            $key++;
        }

        //Reviso que los parametros sort filters y segment  tengan contenido-----------------------
        if ($sort){
            $sortq=$sort;
        }else{
            $sortq=null;
        }

        if($filtro){
            $filtersq= $filtro;
        }else{
            $filtersq=null;
        }

        if($segmentos){
            $segmentq= $segmentos[0];
        }else{
            $segmentq=null;
        }

        if($maxResults){
            $maxq= $maxResults;
        }else{
            $maxq=null;
        }

        //Armo el array 'otros' para el Query--------------------------------------------
        $others=[
            'dimensions' => implode( ',' , $dimensionsq),
            'sort' => $sortq,
            'filters' => $filtersq,
            'segment' => $segmentq,
            'max-results' => $maxq,
        ];

        //Compruebo que el Query se ejecuto correctamente----------------------------------
        try{
            //Guardo la ejecución del query en una variable
            $analyticsData = LaravelAnalytics::setSiteId($siteId)->performQuery(
                $fechaI,
                $fechaF,
                $metricasq,
                $others
            );
        }catch (\Exception $e){
            $error =["La query no se pudo ejecutar: revisa los campos"];
            return response()->json(array('errors' => $error, 200));
        }

        $resultRows = $analyticsData->rows; //variable con el resultado de la query

        if($resultRows == null){
            $resultRows = [[0]];
        }
        //Si hay columnas que ignorar las elimino del arreglo final
        if(count($columnasIgnore) > 0){
            foreach ($columnasIgnore as $column){
                //Busco la columna que se quiere eliminar
                if(in_array($column, $headers)){
                    $columnPosition = array_search($column, $headers);
                    foreach($resultRows as $key => $row){
                        unset($resultRows[$key][$columnPosition]);
                    }
                }
            }
        }
        foreach($resultRows as $pos => $row){
            $resultRows[$pos]= array_values($resultRows[$pos]);
        }
        return $resultRows;
    }

}
