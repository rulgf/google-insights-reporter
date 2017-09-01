<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Alerta;
use App\Notification;
use App\User;
use Carbon\Carbon;
use LaravelAnalytics;

class Alertas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alerta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecutar las alertas en una hora para generar notificaciones';

    /**
     * Create a new command instance.
     *
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
        //rango fecha (Revisara el dia anterior)
        $startDate = Carbon::yesterday("America/Mexico_City");
        $endDate = Carbon::yesterday("America/Mexico_City");

        $alertas = Alerta::with('metricas')->with('cuenta')->get();

        if(isset($alertas)){
            foreach ($alertas as $alerta){

                $metrica = $alerta->metricas->clave;

                $cuenta = $alerta->cuenta->siteId;
                //Ejecuto el Query con la metrica de la alerta
                try{
                    //Guardo la ejecución del query en una variable
                    $analyticsData = LaravelAnalytics::setSiteId($cuenta)->performQuery(
                        $startDate,
                        $endDate,
                        $metrica
                    );
                }catch (\Exception $e){

                }

                $resultado=$analyticsData->rows[0][0];

                $condicion = $alerta->condicion;

                $parametro = $alerta->parametro;

                if($condicion == 1){
                    //menor que
                    if($resultado < $parametro){
                        //genero la notificacion si cumple la condicion de la alerta para todos los usuarios del sistema
                        $users = User::get();

                        foreach ($users as $user){
                            $user->newNotification()
                                ->withSubject($alerta->cuenta->nombre)
                                ->withBody('La metrica ' . $alerta->metricas->nombre . ' es menor a' . $parametro)
                                ->withType(1)
                                ->deliver();
                        }
                    }
                }else if($condicion == 2){
                    //mayor que
                    if($resultado > $parametro){
                        //genero la notificacion si cumple la condicion de la alerta
                        $users = User::get();

                        foreach ($users as $user){
                            $user->newNotification()
                                ->withSubject($alerta->cuenta->nombre)
                                ->withBody('La metrica ' . $alerta->metricas->nombre . ' es mayor a ' . $parametro)
                                ->withType(1)
                                ->deliver();
                        }
                    }
                }else if($condicion == 3){
                    //igual que
                    if($resultado == $parametro){
                        //genero la notificacion si cumple la condicion de la alerta
                        $users = User::get();

                        foreach ($users as $user){
                            $user->newNotification()
                                ->withSubject($alerta->cuenta->nombre)
                                ->withBody('La metrica ' . $alerta->metricas->nombre . ' es igual a ' . $parametro)
                                ->withType(1)
                                ->deliver();
                        }
                    }
                }
            }

        }
        $this->info('Se ha ejecutado el comando exitosamente');
    }
}
