<?php

namespace App\Http\Controllers\Metrica;

use App\Cuentas;
use App\Metrica;
use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Ivory\HttpAdapter\Event\RequestErroredEvent;
use Illuminate\Support\Facades\Auth;

class MetricaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**  **/
    public function  __construct()
    {
        //Se valida que no este logueado
        if(!Auth::check()){
            $this->middleware('auth');
        }
    }

    //Obtengo todas las metricas con el tipo
    public function getMetricas(){
        $metricas = Metrica::with('tipo')->get();
        //dd($metricas);
        return $metricas;
    }

    //Obtengo todas las metricas globales y las unicas de cada cuenta
    public function getSelectMetricas($cuenta_id){
        $idSite = Cuentas::where('siteId', $cuenta_id)->get()->first();

        $metricas = Metrica::with('tipo')
            ->select('id as value', 'clave as label', 'nombre as name', 'tipo_id', 'cuenta_id')
            ->where('cuenta_id', $idSite->id)
            ->orWhere('cuenta_id', null)->get();
        //dd($metricas);
        return $metricas;
    }

    //Obtengo todas las metricas unicas de una cuenta
    public function getSiteMetricas($cuenta_id){
        $idSite = Cuentas::where('siteId', $cuenta_id)->get()->first();

        $metricas = Metrica::where('cuenta_id', $idSite->id)->get();
        //dd($metricas);
        return $metricas;
    }

    //Obtengo los datos de una metrica en especifico
    public function getMetrica($id){
        $metrica = Metrica::where('id', $id)->get()->first();
        return $metrica;
    }

    //Create Metrica
    public function createMetrica(Request $request){
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'clave' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->messages()->all(), 200));
        }

        $idSite = Cuentas::where('siteId', $request->cuenta_id)->get()->first();

        $result = Metrica::store($request,$idSite->id);

        if ($result) {
            return response()->json(['success' => true]);
        }
        // Regresa los errores
        return response()->json(['success' => false, 'errors' => ['No se pudo guardar el registro']]);
    }

    //Edito Metrica
    public function editMetrica(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'clave' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->messages()->all(), 200));
        }

        $metrica = Metrica::where('id', $id)->first();
        $metrica->nombre = $request->nombre;
        $metrica->clave = $request->clave;
        $metrica->save();

        return response()->json(['success' => true]);
    }

    //Elimino Metrica
    public function deleteMetrica(Request $request, $id){
        Metrica::destroy($request->id);
        return response()->json(['success' => true]);
    }


}
