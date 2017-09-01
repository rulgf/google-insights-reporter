<?php

namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;

use Validator;
use App\Cuentas;
use App\Reporte;
use App\Query;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    //Obtengo todos los Reportes de una cuenta en especifico
    public function getReportes($cuenta_id){
        $idSite = Cuentas::where('siteId', $cuenta_id)->get()->first();

        $reportes = Reporte::where('cuenta_id', $idSite->id)->get();

        return $reportes;
    }

    //Obtengo los datos de un Reporte
    public function getReporte($id){
        $reporte= Reporte::where('id', $id)->get()->first();

        return $reporte;
    }

    //obtengo el reporte por nombre de una cuenta en especifico
    public function getIdReporte($cuenta_id, $reporte_name){

        $idSite = Cuentas::where('siteId', $cuenta_id)->get()->first();
        
        $id_reporte = Reporte::where('nombre', $reporte_name)->where('cuenta_id', $idSite->id)->get()->first();
        
        return $id_reporte;
    }

    //Obtengo reportes activos
    public function getActiveReports(){
        $Reportes = Reporte::where('mail_active', 1)->with('cuenta')->whereHas('cuenta', function($q)
        {
            $q->where('active','=', 0);

        })->get()->all();
        return($Reportes);
    }

    //creo el Reporte
    public function createReporte(Request $request){

        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->messages()->all(), 200));
        }

        $idSite = Cuentas::where('siteId', $request->cuenta_id)->get()->first();

        $result = Reporte::store($request, $idSite->id);
        
        //Creo los KPI's Obligatorios
            //CTR ------------------------------
        DB::transaction(function() use ($result, $request) {

            $prueba = Query::storekpi('Click Through Rate', $result->id);

            $newQuery = Query::where('id', $prueba->id)->get()->first();

            //Relaciono Metrica
                $newQuery->metrica()->attach('21');
        });

            //CPC-------------------------------
        DB::transaction(function() use ($result, $request) {

            $prueba = Query::storekpi('Costo Por Clic', $result->id);

            $newQuery = Query::where('id', $prueba->id)->get()->first();

            //Relaciono Metrica
            $newQuery->metrica()->attach('20');
        });

            //CPM--------------------------------
        DB::transaction(function() use ($result, $request) {

            $prueba = Query::storekpi('Costo Por Mil Impresiones', $result->id);

            $newQuery = Query::where('id', $prueba->id)->get()->first();

            //Relaciono Metrica
            $newQuery->metrica()->attach('19');
        });

            //% New Users----------------------------
        DB::transaction(function() use ($result, $request) {

            $prueba = Query::storekpi('% Nuevos Usuarios', $result->id);

            $newQuery = Query::where('id', $prueba->id)->get()->first();

            //Relaciono Metrica
            $newQuery->metrica()->attach('3');
        });

            //% conversion----------------------------
        DB::transaction(function() use ($result, $request) {

            $prueba = Query::storekpi('% de Conversión', $result->id);

            $newQuery = Query::where('id', $prueba->id)->get()->first();

            //Relaciono Metrica
            $newQuery->metrica()->attach('98');
        });

            //Bounce rate------------------------------
        DB::transaction(function() use ($result, $request) {

            $prueba = Query::storekpi('% de Rebote', $result->id);

            $newQuery = Query::where('id', $prueba->id)->get()->first();

            //Relaciono Metrica
            $newQuery->metrica()->attach('11');
        });

            //Paginas por Sesion------------------------------
        DB::transaction(function() use ($result, $request) {

            $prueba = Query::storekpi('Páginas por Sesión', $result->id);

            $newQuery = Query::where('id', $prueba->id)->get()->first();

            //Relaciono Metrica
            $newQuery->metrica()->attach('44');
        });

            //Duración promedio de la sesión------------------------------
        DB::transaction(function() use ($result, $request) {

            $prueba = Query::storekpi('Duración promedio de la sesión', $result->id);

            $newQuery = Query::where('id', $prueba->id)->get()->first();

            //Relaciono Metrica
            $newQuery->metrica()->attach('13');
        });


        if ($result) {
            return response()->json(['success' => true]);
        }
        // Regresa los errores
        return response()->json(['success' => false, 'errors' => ['No se pudo guardar el registro']]);
    }

    //edito el reporte
    public function editReporte(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->messages()->all(), 200));
        }

        $reporte = Reporte::where('id', $id)->first();
        $reporte->nombre = $request->nombre;
        $reporte->descripcion = $request->descripcion;
        $reporte->mail_active = $request->mail_active;
        $reporte->save();

        return response()->json(['success' => true]);
    }

    //elimino el reporte
    public function deleteReporte(Request $request, $id){
        Reporte::destroy($request->id);
        return response()->json(['success' => true]);
    }
}
