<?php

namespace App\Http\Controllers\Cuenta;

use App\Cuentas;
use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CuentaController extends Controller
{
    public function getCuenta($id){
        $cuenta= Cuentas::where('id', $id)->first();
        return $cuenta;
    }

    public function getCuentaSiteId($siteId){
        $cuenta= Cuentas::select('id', 'siteId as label', 'nombre as name')->where('siteId', $siteId)->first();
        return $cuenta;
    }

    public function getCuentas(){
        $cuentas = Cuentas::select('id', 'siteId as label', 'nombre as name')->get();
        return $cuentas;
    }

    public function getAllCuentas(){
        $cuentas = Cuentas::select('id', 'nombre', 'siteId', 'nombre_cliente', 'mail_cliente', 'active')->get();
        return $cuentas;
    }
    
    public function getActiveCuentas(){
        $Cuentas = Cuentas::where('active',0)->orwhere('active', 1)->with('semaforo')->get()->all();
        return($Cuentas);
    }

    public function getInactiveCuentas(){
        $Cuentas = Cuentas::where('active',2)->with('semaforo')->get()->all();
        return($Cuentas);
    }

    public function createCuenta(Request $request){
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'siteId' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->messages()->all(), 200));
        }

        $result = Cuentas::store($request);

        if ($result) {
            return response()->json(['success' => true]);
        }
        // Regresa los errores
        return response()->json(['success' => false, 'errors' => ['No se pudo guardar el registro']]);

    }

    public function editCuenta(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'siteId' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->messages()->all(), 200));
        }

        $cuenta = Cuentas::where('id', $id)->first();
        $cuenta->nombre = $request->nombre;
        $cuenta->siteId = 'ga:' . $request->siteId;
        $cuenta->nombre_cliente = $request->nombre_cliente;
        $cuenta->mail_cliente = $request->email_cliente;
        $cuenta->active = $request->active;
        $cuenta->campaign_id = $request->campaign_id;
        $cuenta->save();

        return response()->json(['success' => true]);
    }

    public function deleteCuenta(Request $request, $id){
        Cuentas::destroy($request->id);
        return response()->json(['success' => true]);
    }

}
