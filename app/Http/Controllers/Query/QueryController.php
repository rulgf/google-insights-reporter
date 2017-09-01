<?php

namespace App\Http\Controllers\Query;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use LaravelAnalytics;
use Carbon\Carbon;
use Validator;
use Swap;

class QueryController extends Controller
{
    /**
     * runQuery
     *
     * @param  Request $request
     * @return result json
     */
    public function runQuery(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'startDate' => 'required',
            'endDate' => 'required',
            'metrics' => 'required',
            'siteId' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->messages()->all(), 200));
        }

        if($request->changeCurrency == "true"){
            $validate = Validator::make($request->all(), [
                'currencyFrom' => 'required',
                'currencyTo' => 'required'
            ]);

            if ($validate->fails()) {
                return response()->json(array('errors' => $validate->messages()->all(), 200));
            }
        }


        $expression = '/\((.*)*\)/';
        $initialDate = preg_replace($expression, '', $request->startDate);
        $finalDate = preg_replace($expression, '', $request->endDate);


        $startDate=Carbon::parse($initialDate);
        $endDate=Carbon::parse($finalDate);

        //Guardo en un array los headers del query--------------------------------------
        $headers=[];
        $key = 0;
            //Reviso si hay dimensiones
        if($request->dimensions){
            $dimensions = $request->dimensions;
            foreach ($request->dimensions as $head){
                $headers=array_add($headers, $key, $head);
                $key++;
            }
        }else{
            $dimensions =[];
        }

            //Guardo las metricas
        foreach ($request->metrics as $head){
            $headers=array_add($headers,$key, $head);
            $key++;
        }

        //Reviso que los parametros sort filters y segment  tengan contenido-----------------------
        if ($request->sort){
            $sort=implode(',', $request->sort);
        }else{
            $sort=null;
        }

        if($request->filters){
            $filters= $request->filters;
        }else{
            $filters=null;
        }

        if($request->segment){
            $segment= $request->segment;
        }else{
            $segment=null;
        }

        if($request->maxResult){
            $max= $request->maxResult;
        }else{
            $max=null;
        }

        //Armo el array 'otros' para el Query--------------------------------------------
        $others=[
            'dimensions' => implode( ',' , $dimensions),
            'sort' => $sort,
            'filters' => $filters,
            'segment' => $segment,
            'max-results' => $max,
        ];

        //Compruebo que el Query se ejecuto correctamente----------------------------------
        try{
            //Guardo la ejecución del query en una variable
            $analyticsData = LaravelAnalytics::setSiteId($request->siteId)->performQuery(
                $startDate,
                $endDate,
                implode(',',$request->metrics),
                $others
            );
        }catch (\Exception $e){
            $error =["La query no se pudo ejecutar: revisa los campos"];
            return response()->json(array('errors' => $error, 200));
        }

        //Cambio de formatos para fecha hora y dinero------------------------------------------------
        $resultRows = $analyticsData->rows; //variable con el resultado de la query

            //Cambiar formato a los campos fecha
        if(in_array('ga:date', $headers)){
            $datePosition = array_search('ga:date', $headers);
            foreach($resultRows as $key => $row){
                $resultRows[$key][$datePosition] = Carbon::createFromFormat('Ymd', $row[$datePosition])
                    ->toFormattedDateString();
            }
        }

            //Cambiar formato al campo dateHour
        if(in_array('ga:dateHour', $headers)){
            $datePosition = array_search('ga:dateHour', $headers);
            foreach($resultRows as $key => $row){
                $resultRows[$key][$datePosition] = Carbon::createFromFormat('YmdH', $row[$datePosition])
                    ->toDateTimeString();
            }
        }

            //Cambiar formato al campo yearMonth
        if(in_array('ga:yearMonth', $headers)){
            $datePosition = array_search('ga:yearMonth', $headers);
            foreach($resultRows as $key => $row){
                $resultRows[$key][$datePosition] = Carbon::createFromFormat('Ym', $row[$datePosition])
                    ->format('Y-m');
            }
        }

            //Cambiar formato al campo Hour
        if(in_array('ga:hour', $headers)){
            $datePosition = array_search('ga:hour', $headers);
            foreach($resultRows as $key => $row){
                $resultRows[$key][$datePosition] = Carbon::createFromFormat('H', $row[$datePosition])
                    ->format('h:00 A');
            }
        }

            //Cambio de Moneda-------------------------------------------------------
            //Si cambiar tipo de moneda esta activo
        if($request->changeCurrency == "true"){
            //Obtengo el tipo de cambio segun los parametros seleccionados
            $currencyQuote  = $request->currencyFrom . '/' . $request->currencyTo;
            $rate = doubleval(Swap::quote($currencyQuote)->getValue());

            //Cambiar Moneda al campo CPM
            if(in_array('ga:CPM', $headers)){
                $moneyPosition = array_search('ga:CPM', $headers);
                foreach($resultRows as $key => $row){
                    $resultRows[$key][$moneyPosition] = $row[$moneyPosition]*$rate;
                }
            }

            //Cambiar Moneda al campo CPC
            if(in_array('ga:CPC', $headers)){
                $moneyPosition = array_search('ga:CPC', $headers);
                foreach($resultRows as $key => $row){
                    $resultRows[$key][$moneyPosition] = $row[$moneyPosition]*$rate;
                }
            }

            //Cambiar Moneda al campo Cost per Transaction
            if(in_array('ga:costPerTransaction', $headers)){
                $moneyPosition = array_search('ga:costPerTransaction', $headers);
                foreach($resultRows as $key => $row){
                    $resultRows[$key][$moneyPosition] = $row[$moneyPosition]*$rate;
                }
            }

            //Cambiar Moneda al campo Cost per Goal Conversion
            if(in_array('ga:costPerGoalConversion', $headers)){
                $moneyPosition = array_search('ga:costPerGoalConversion', $headers);
                foreach($resultRows as $key => $row){
                    $resultRows[$key][$moneyPosition] = $row[$moneyPosition]*$rate;
                }
            }

            //Cambiar Moneda al campo Cost per Conversion
            if(in_array('ga:costPerConversion', $headers)){
                $moneyPosition = array_search('ga:costPerConversion', $headers);
                foreach($resultRows as $key => $row){
                    $resultRows[$key][$moneyPosition] = $row[$moneyPosition]*$rate;
                }
            }

            //Cambiar Moneda al campo RPC
            if(in_array('ga:RPC', $headers)){
                $moneyPosition = array_search('ga:RPC', $headers);
                foreach($resultRows as $key => $row){
                    $resultRows[$key][$moneyPosition] = $row[$moneyPosition]*$rate;
                }
            }

            //Cambiar Moneda al campo goal Value
            if(in_array('ga:goalValueAll', $headers)){
                $moneyPosition = array_search('ga:goalValueAll', $headers);
                foreach($resultRows as $key => $row){
                    $resultRows[$key][$moneyPosition] = $row[$moneyPosition]*$rate;
                }
            }

            //Cambiar moneda a Per Session goal Value
            if(in_array('ga:goalValuePerSession', $headers)){
                $moneyPosition = array_search('ga:goalValuePerSession', $headers);
                foreach($resultRows as $key => $row){
                    $resultRows[$key][$moneyPosition] = $row[$moneyPosition]*$rate;
                }
            }

            //Cambiar moneda a Page Value
            if(in_array('ga:pageValue', $headers)){
                $moneyPosition = array_search('ga:pageValue', $headers);
                foreach($resultRows as $key => $row){
                    $resultRows[$key][$moneyPosition] = $row[$moneyPosition]*$rate;
                }
            }

            //Cambiar moneda a Per Search Goal Value
            if(in_array('ga:goalValueAllPerSearch', $headers)){
                $moneyPosition = array_search('ga:goalValueAllPerSearch', $headers);
                foreach($resultRows as $key => $row){
                    $resultRows[$key][$moneyPosition] = $row[$moneyPosition]*$rate;
                }
            }

        }


        return $resultRows;
    }

    public function testQuery(Request $request){
        $currencyQuote  = $request->currencyFrom . '/' . $request->currencyTo;
        return $currencyQuote;

    }
}
