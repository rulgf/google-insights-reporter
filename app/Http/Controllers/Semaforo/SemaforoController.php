<?php

namespace App\Http\Controllers\Semaforo;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Cuentas;
use App\Semaforo;
use Validator;
use Carbon\Carbon;
use LaravelAnalytics;

class SemaforoController extends Controller
{
    //Obtengo todos los semaforos con las metricas
    public function getSemaforos(){
        $alertas = Semaforo::with('metricas')->with('cuenta')->get();

        return $alertas;
    }

    //Obtengo todos los semaforos unicos de una cuenta
    public function getSiteSemaforos($cuenta_id){
        $idSite = Cuentas::where('siteId', $cuenta_id)->get()->first();

        $alertas = Semaforo::where('cuenta_id', $idSite->id)->with('cuenta')->with('metricas')->get();

        return $alertas;
    }

    //Obtengo los datos de un semaforo en especifico
    public function getSemaforo($id){
        $alerta = Semaforo::where('id', $id)->with('metricas')->get()->first();
        return $alerta;
    }

    //Create Semaforo
    public function createSemaforo(Request $request){
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'metrica' => 'required',
            'parametro' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->messages()->all(), 200));
        }

        $idSite = Cuentas::where('siteId', $request->cuenta_id)->get()->first();

        $result = Semaforo::store($request,$idSite->id);

        if ($result) {
            return response()->json(['success' => true]);
        }
        // Regresa los errores
        return response()->json(['success' => false, 'errors' => ['No se pudo guardar el registro']]);
    }

    //Edito Semaforo
    public function editSemaforo(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'metrica' => 'required',
            'parametro' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->messages()->all(), 200));
        }

        $alerta = Semaforo::where('id', $id)->first();
        $alerta->nombre = $request->nombre;
        $alerta->metrica_id = $request->metrica;
        $alerta->condicion = $request->condicion;
        $alerta->parametro = $request->parametro;
        $alerta->save();

        return response()->json(['success' => true]);
    }

    //Elimino Semaforo
    public function deleteSemaforo(Request $request, $id){
        Semaforo::destroy($request->id);
        return response()->json(['success' => true]);
    }

    //Actualizar semaforos
    public function updateSemaforo($id){
        //Rango de fechas (Semana)
        $startDate = new Carbon("last week monday", "America/Mexico_City");
        $endDate = new Carbon("last sunday", "America/Mexico_City");

        //
        $semaforos = Semaforo::with('metricas')->with('cuenta')->get();
        $cuentas = Cuentas::where('id', $id)->get();

        if(isset($cuentas)){
            foreach ($cuentas as $cuenta){
                $count_semaforo =0;
                $semaforos = Semaforo::where('cuenta_id', $cuenta->id)->with('metricas')->get();

                if(isset($semaforos)){
                    foreach ($semaforos as $semaforo){

                        $metrica = $semaforo->metricas->clave;

                        try{
                            //Guardo la ejecución del query en una variable
                            $analyticsData = LaravelAnalytics::setSiteId($cuenta->siteId)->performQuery(
                                $startDate,
                                $endDate,
                                $metrica
                            );
                        }catch (\Exception $e){

                        }

                        $resultado=$analyticsData->rows[0][0];
                        $condicion = $semaforo->condicion;

                        $parametro = $semaforo->parametro;

                        if($condicion == 1){
                            //menor que
                            if($resultado > $parametro){
                                $count_semaforo++;
                                $semaforo->estado = 1;
                                $semaforo->obtained = $resultado=$analyticsData->rows[0][0];
                                $semaforo->save();
                            }else{
                                $semaforo->estado = 0;
                                $semaforo->obtained = $resultado=$analyticsData->rows[0][0];
                                $semaforo->save();
                            }
                        }else if($condicion == 2){
                            //mayor que
                            if($resultado < $parametro){
                                $count_semaforo++;
                                $semaforo->estado = 1;
                                $semaforo->obtained = $resultado=$analyticsData->rows[0][0];
                                $semaforo->save();
                            }else{
                                $semaforo->estado = 0;
                                $semaforo->obtained = $resultado=$analyticsData->rows[0][0];
                                $semaforo->save();
                            }
                        }else if($condicion == 3){
                            //igual que
                            if($resultado != $parametro){
                                $count_semaforo++;
                                $semaforo->estado = 1;
                                $semaforo->obtained = $resultado=$analyticsData->rows[0][0];
                                $semaforo->save();
                            }else{
                                $semaforo->estado = 0;
                                $semaforo->obtained = $resultado=$analyticsData->rows[0][0];
                                $semaforo->save();
                            }
                        }

                    }
                }

                if($count_semaforo < count($semaforos)*0.5){
                    //Verde
                    $cuenta->semaforo_state = 0;
                    $cuenta->save();
                }else if($count_semaforo < count($semaforos)*0.7){
                    //Amarillo
                    $cuenta->semaforo_state = 1;
                    $cuenta->save();
                }else if($count_semaforo < count($semaforos)){
                    //Rojo
                    $cuenta->semaforo_state = 2;
                    $cuenta->save();
                }
            }
        }
        return response()->json(['success' => true]);
    }

    public function updateSemaforos(){
        //Rango de fechas (Semana)
        $startDate = new Carbon("last week monday", "America/Mexico_City");
        $endDate = new Carbon("last sunday", "America/Mexico_City");

        //
        $semaforos = Semaforo::with('metricas')->with('cuenta')->get();
        $cuentas = Cuentas::get();

        if(isset($cuentas)){
            foreach ($cuentas as $cuenta){
                $count_semaforo =0;
                $semaforos = Semaforo::where('cuenta_id', $cuenta->id)->with('metricas')->get();

                if(isset($semaforos)){
                    foreach ($semaforos as $semaforo){

                        $metrica = $semaforo->metricas->clave;

                        try{
                            //Guardo la ejecución del query en una variable
                            $analyticsData = LaravelAnalytics::setSiteId($cuenta->siteId)->performQuery(
                                $startDate,
                                $endDate,
                                $metrica
                            );
                        }catch (\Exception $e){

                        }

                        $resultado=$analyticsData->rows[0][0];
                        $condicion = $semaforo->condicion;

                        $parametro = $semaforo->parametro;

                        if($condicion == 1){
                            //menor que
                            if($resultado > $parametro){
                                $count_semaforo++;
                                $semaforo->estado = 1;
                                $semaforo->obtained = $resultado=$analyticsData->rows[0][0];
                                $semaforo->save();
                            }else{
                                $semaforo->estado = 0;
                                $semaforo->obtained = $resultado=$analyticsData->rows[0][0];
                                $semaforo->save();
                            }
                        }else if($condicion == 2){
                            //mayor que
                            if($resultado < $parametro){
                                $count_semaforo++;
                                $semaforo->estado = 1;
                                $semaforo->obtained = $resultado=$analyticsData->rows[0][0];
                                $semaforo->save();
                            }else{
                                $semaforo->estado = 0;
                                $semaforo->obtained = $resultado=$analyticsData->rows[0][0];
                                $semaforo->save();
                            }
                        }else if($condicion == 3){
                            //igual que
                            if($resultado != $parametro){
                                $count_semaforo++;
                                $semaforo->estado = 1;
                                $semaforo->obtained = $resultado=$analyticsData->rows[0][0];
                                $semaforo->save();
                            }else{
                                $semaforo->estado = 0;
                                $semaforo->obtained = $resultado=$analyticsData->rows[0][0];
                                $semaforo->save();
                            }
                        }

                    }
                }

                if($count_semaforo < count($semaforos)*0.5){
                    //Verde
                    $cuenta->semaforo_state = 0;
                    $cuenta->save();
                }else if($count_semaforo < count($semaforos)*0.7){
                    //Amarillo
                    $cuenta->semaforo_state = 1;
                    $cuenta->save();
                }else if($count_semaforo < count($semaforos)){
                    //Rojo
                    $cuenta->semaforo_state = 2;
                    $cuenta->save();
                }
            }
        }
        return response()->json(['success' => true]);
    }
}
