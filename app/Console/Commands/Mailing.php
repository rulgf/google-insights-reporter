<?php

namespace App\Console\Commands;

use App\Cuentas;
use Illuminate\Console\Command;
use JonnyW\PhantomJs\Client;
use App\Reporte;
use Mail;

class Mailing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mailing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta el mailing para los reportes activos';

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
        $reportesActivos = Reporte::where('mail_active', 1)->get();

        foreach ($reportesActivos as $reporte){
            //Recupero el mail del cliente
            $cuenta = Cuentas::where('id', $reporte->cuenta_id)->get()->first();

            //Valido que la cuenta a la que pertence el reporte este activa
            if($cuenta->active == 0){
                //La cuenta esta activa se genera el mail
                $client = Client::getInstance();
                $client->getEngine()->setPath(base_path() . '/bin/phantomjs');

                $delay = 20;

                //$urlbase = 'http://localhost:8888/DOODanalytics/public/mailpdf/';
                $urlbase = 'http://insights.dood.mx/mailpdf/';

                $request = $client->getMessageFactory()->createPdfRequest($urlbase . $reporte->id);

                $request->setDelay($delay);
                $file = public_path() . '/temp/' . $reporte->nombre . '.pdf';

                $request->setOutputFile($file);

                $response = $client->getMessageFactory()->createResponse();

                // Send the request
                $client->send($request, $response);

                // Mail
                Mail::send([], [], function($message) use($file, $cuenta)
                {
                    //remitente
                    $message->from('rgarcia@dood.mx');

                    //asunto
                    $message->subject('Prueba');

                    //receptor
                    $message->to($cuenta->mail_cliente, $cuenta->nombre_cliente);

                    //PDF
                    $message->attach($file);

                });

                $this->info('The mail was sent successfully! to ' . $cuenta->mail_cliente);
            }
        }
    }
}
