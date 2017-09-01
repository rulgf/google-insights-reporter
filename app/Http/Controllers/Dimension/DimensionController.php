<?php

namespace App\Http\Controllers\Dimension;

use App\Dimension;
use Illuminate\Http\Request;
use App\Cuentas;

use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DimensionController extends Controller
{
    //Obtengo todas las dimensiones con el tipo
    public function getDimensiones(){
        $dimensiones = Dimension::with('tipo')->get();
        //dd($metricas);
        return $dimensiones;
    }

    //Obtengo todas las dimensiones y las unicas de una cuenta
    public function getSelectDimensiones($cuenta_id){
        $idSite = Cuentas::where('siteId', $cuenta_id)->get()->first();
        
        $dimensiones = Dimension::with('tipo')
            ->select('id as value', 'clave as label', 'nombre as name', 'tipo_id', 'cuenta_id')
            ->where('cuenta_id', $idSite->id)
            ->orWhere('cuenta_id', null)->get();
        //dd($metricas);

        return $dimensiones;
    }

    //Obtengo todas las dimensiones unicas de una cuenta
    public function getSiteDimensiones($cuenta_id){
        $idSite = Cuentas::where('siteId', $cuenta_id)->get()->first();
        
        $dimensiones = Dimension::where('cuenta_id', $idSite->id)->get();

        return $dimensiones;
    }

    //Obtengo los datos de una dimension en especifico
    public function getDimension($id){
        $dimension = Dimension::where('id', $id)->get()->first();
        return $dimension;
    }

    //Create Dimension
    public function createDimension(Request $request){
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'clave' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->messages()->all(), 200));
        }

        $idSite = Cuentas::where('siteId', $request->cuenta_id)->get()->first();

        $result = Dimension::store($request, $idSite->id);

        if ($result) {
            return response()->json(['success' => true]);
        }
        // Regresa los errores
        return response()->json(['success' => false, 'errors' => ['No se pudo guardar el registro']]);
    }

    //Edito Dimenison
    public function editDimension(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'clave' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->messages()->all(), 200));
        }

        $dimension = Dimension::where('id', $id)->first();
        $dimension->nombre = $request->nombre;
        $dimension->clave = $request->clave;
        $dimension->save();

        return response()->json(['success' => true]);
    }

    //Elimino Dimension
    public function deleteDimension(Request $request, $id){
        Dimension::destroy($request->id);
        return response()->json(['success' => true]);
    }
}
