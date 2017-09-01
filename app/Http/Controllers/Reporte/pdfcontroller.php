<?php

namespace App\Http\Controllers\Reporte;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JonnyW\PhantomJs\Client;
use PDF;
use App\Reporte;
use App\Cuentas;

class pdfcontroller extends Controller
{
    public function generatePDF(Request $request){
        $content = $request->tables;
        $graphs = $request->graphs;

        //Base del Html -------------------------------------
        $htmlbase ='
        <!DOCTYPE html>
        <html><head>
        <link href="/public/css/theme-default/bootstrap.min.css" rel="stylesheet">
        <style>
        table{
            border: 1px solid whitesmoke;
            vertical-align: middle;
        }
        th{
            background-color: #29a1db;
            color: #ffffff;
            text-align: center;
            border: 1px solid whitesmoke;
            height: 30px;
            line-height:20px;
        }
        td{
            text-align: center;
            border: 1px solid whitesmoke;
            height: 30px;
            vertical-align: middle;
            line-height:20px;
        }
        .row{
            text-align: center;
            
        }
        </style></head><body>';

        $pdf = new MYPDF();

        $finalhtml =$htmlbase . $content ;

        $expression = '((<tr))';
        $finalhtml = preg_replace($expression, '<tr nobr="true"', $finalhtml);

        $expression = '((<td))';
        $finalhtml = preg_replace($expression, '<td nobr="true"', $finalhtml);

        $expression = '((<th))';
        $finalhtml = preg_replace($expression, '<th nobr="true"', $finalhtml);

        $desglose = substr($finalhtml, strpos($finalhtml, '<div class="row"><h2>Desglose'));

        $reporte_id= $request->id;
        $reporte= Reporte::where('id', $reporte_id)->get()->first();
        $cuenta= Cuentas::where('id', $reporte->cuenta_id)->get()->first();

        $expression = '/\((.*)*\)/';
        $fecha_inicial = preg_replace($expression, '', $request->fecha_inicial);
        $fecha_final = preg_replace($expression, '', $request->fecha_final);

        $fechai = Carbon::parse($fecha_inicial);
        $fechaf = Carbon::parse($fecha_final);

        $portada =
            '<div>
                <div style="text-align:center; font-size: 200%; color: #29a1db;">
                    '. $reporte->nombre . '
                </div>
                <div style="text-align:center; font-size: 150%; color: #29a1db;">
                    '. $fechai->toDateString() . ' / ' . $fechaf->toDateString() .'
                </div>
                <div style="text-align:center; font-size: 200%; color: #29a1db;">
                    '. $cuenta->nombre . '
                </div>
            </div>';

        $pdf->SetTitle('Reporte' . $reporte->nombre . '_' . $cuenta->nombre);
        $pdf->SetPrintHeader(false);
        $pdf->AddPage();
        $pdf->setColor(3, 155, 229);
        $pdf->ImageSVG($file=public_path() . '/img/insights_logo.svg', $x=50, $y=50, $w='100', $h='100', $link='', $align='', $palign='', $border=0, $fitonpage=false);
        $pdf->SetY(135);
        $pdf->writeHTML($portada, true, false, true, false, '');

        $pdf->AddPage();

        $pdf->writeHTML($finalhtml, true, false, true, false, '');
        
        $expression = '/(#highcharts-[0-9]+)/';

        for($i = 0; $i < count($graphs); $i++){
            $graphs[$i]= preg_replace($expression, '', $graphs[$i]); //Elimino ids
            $pdf->AddPage();
            $pdf->ImageSVG('@' . $graphs[$i], $x=10, $y=50, $w='180', $h='180', $align='L', $palign='L', $border=0, $fitonpage=false);
            /*if(isset($graphs[$i+1])){
                $graphs[$i+1]= preg_replace($expression, '', $graphs[$i+1]); //Elimino ids
                $pdf->ImageSVG('@' . $graphs[$i+1], $x='100', $y=$i*200, $w='100', $h='100', $align='R', $palign='R', $border=0, $fitonpage=false);
                $i++;
            }*/

        }

        $pdf->Output(public_path() . '/temp/reporte.pdf', 'F');

        return response()->json(['success' => true]);
    }

    /*
     * Funcion de prueba de mail
     */
    public function tcpdf(){

        /*$pdf = new \TCPDF();
        $pdf->SetTitle('Hello World');
        $pdf->AddPage();
        $pdf->writeHTML($algo, true, false, true, false, '');

        $pdf->Output('hello_world.pdf');*/

        $client = Client::getInstance();
        $client->getEngine()->setPath('../bin/phantomjs');

        $delay = 20;

        $request = $client->getMessageFactory()->createPdfRequest('http://localhost:8888/DOODanalytics/public/mailpdf/6');

        $request->setDelay($delay);
        $file = public_path() . '/temp/document.pdf';

        $request->setOutputFile($file);

        $response = $client->getMessageFactory()->createResponse();

        // Send the request
        $client->send($request, $response);


        //echo($response->getContent());


    }
}

class MYPDF extends \TCPDF {

    // Page footer
    public function Footer() {
        $noPage = $this->pageNo();
        if($noPage != 1){
            // Position at 15 mm from bottom
            $this->SetY(-15);
            // Set font
            $this->SetFont('helvetica', 'I', 8);
            // Page number
            $this->Cell(0, 10, '*Total: Media de la consulta en el periodo del Reporte', 0, false, 'C', 0, '', 0, false, 'T', 'M');
        }
    }
}
