<?php

namespace App\Http\Controllers\Excel;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Reporte;
use App\Cuentas;
use Excel;

class excelController extends Controller
{
    public function reporte(Request $request) {

        $reporte_id= $request->id;
        $total = $request->total_report;
        $total_d = $request->content_report;
        $dates = $request->dates;

        $date_range= [$dates[0],$dates[count($dates)-1]];

        $reporte= Reporte::where('id', $reporte_id)->get()->first();
        $cuenta= Cuentas::where('id', $reporte->cuenta_id)->get()->first();

        //dd($total_d);

        $nombreXls = 'Reporte_' . $reporte->nombre . '_' . $cuenta->nombre;

        Excel::create($nombreXls, function($excel) use ($total, $total_d, $dates, $date_range, $reporte, $cuenta) {

            $excel->sheet('sheet', function($sheet) use ($total, $date_range, $reporte, $cuenta) {

                $sheet->loadView('excel.exceltotal')->with('total', $total)
                    ->with('date_range', $date_range)->with('reporte', $reporte)->with('cuenta', $cuenta);

            });

            $excel->sheet('New sheet', function($sheet) use ($total_d, $dates, $date_range, $reporte, $cuenta) {

                $sheet->loadView('excel.exceldesglose')->with('total_d', $total_d)
                    ->with('dates', $dates)->with('date_range', $date_range)
                    ->with('reporte', $reporte)->with('cuenta', $cuenta);

            });

        })->store('xls');

        return [$nombreXls];

    }

    public function prueba(){
        $dates = [1,2,3];
        $total_d=[["name"=>"CPC", "values" => 100.2],
            ["name"=>"Usuarios",
                "values" => [
                    ["nuevos", 100], ["returning", 200]
                ]
            ]
        ];

        Excel::create('Prueba', function($excel) use ($total_d) {

            $excel->sheet('sheet', function($sheet) use ($total_d) {

                $sheet->loadView('excel.test')->with('total', $total_d);

            });

        })->store('xls');

        return(View::make('excel.test')->with('total', $total_d)->with('dates', $dates));
    }
}
