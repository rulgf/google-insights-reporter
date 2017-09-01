<?php

namespace App\Http\Controllers\Alerta;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Alerta;
use App\Cuentas;
use Ivory\HttpAdapter\Zend1HttpAdapter;
use Validator;

use Carbon\Carbon;
use App\Notification;
use App\User;
use LaravelAnalytics;

class AlertaController extends Controller
{
    //Obtengo todas las alertas con la metricas
    public function getAlertas(){
        $alertas = Alerta::with('metricas')->with('cuenta')->get();

        return $alertas;
    }

    //Obtengo todas las alertas unicas de una cuenta
    public function getSiteAlertas($cuenta_id){
        $idSite = Cuentas::where('siteId', $cuenta_id)->get()->first();

        $alertas = Alerta::where('cuenta_id', $idSite->id)->with('cuenta')->with('metricas')->get();

        return $alertas;
    }

    //Obtengo los datos de una alerta en especifico
    public function getAlerta($id){
        $alerta = Alerta::where('id', $id)->with('metricas')->get()->first();
        return $alerta;
    }

    //Create Metrica
    public function createAlerta(Request $request){
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'metrica' => 'required',
            'parametro' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->messages()->all(), 200));
        }

        $idSite = Cuentas::where('siteId', $request->cuenta_id)->get()->first();

        $result = Alerta::store($request,$idSite->id);

        if ($result) {
            return response()->json(['success' => true]);
        }
        // Regresa los errores
        return response()->json(['success' => false, 'errors' => ['No se pudo guardar el registro']]);
    }

    //Edito alerta
    public function editAlerta(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'metrica' => 'required',
            'parametro' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->messages()->all(), 200));
        }

        $alerta = Alerta::where('id', $id)->first();
        $alerta->nombre = $request->nombre;
        $alerta->metrica_id = $request->metrica;
        $alerta->condicion = $request->condicion;
        $alerta->parametro = $request->parametro;
        $alerta->save();

        return response()->json(['success' => true]);
    }

    //Elimino Alerta
    public function deleteAlerta(Request $request, $id){
        Alerta::destroy($request->id);
        return response()->json(['success' => true]);
    }
}
