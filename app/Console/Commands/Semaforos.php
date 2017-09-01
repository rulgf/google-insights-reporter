<?php

namespace App\Console\Commands;

use App\Cuentas;
use Illuminate\Console\Command;
use Carbon\Carbon;
use LaravelAnalytics;
use App\Semaforo;

class Semaforos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'semaforos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta las queries para el semaforo';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
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
                            $this->info('El semaforo ' . $semaforo->id .' no se pudo ejecutar');
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
                    $this->info('Cuenta: '. $cuenta->nombre .' en Verde '. $count_semaforo );
                }else if($count_semaforo < count($semaforos)*0.7){
                    //Amarillo
                    $cuenta->semaforo_state = 1;
                    $cuenta->save();
                    $this->info('Cuenta: '. $cuenta->nombre .' en Amarillo '. $count_semaforo);
                }else if($count_semaforo < count($semaforos)){
                    //Rojo
                    $cuenta->semaforo_state = 2;
                    $cuenta->save();
                    $this->info('Cuenta: '. $cuenta->nombre .' en Rojo '. $count_semaforo);
                }
            }
        }
    }
}
