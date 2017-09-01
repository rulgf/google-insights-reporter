<?php

namespace App\Http\Controllers\Mail;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Cuentas;
use App\Query;
use App\Reporte;
use Laracasts\Utilities\JavaScript\JavaScriptServiceProvider;
use LaravelAnalytics;
use Carbon\Carbon;
use Ghunti\HighchartsPHP\Highchart;
use Ghunti\HighchartsPHP\HighchartJsExpr;
use JavaScript;
use Illuminate\Support\Facades\View;

class Mailpdfcontroller extends Controller
{
    //Funcion principal del Reporte
    //Ejecuta todos los queries de un reporte, entre otras operaciones
    public function executeReporte($reporte_id){

        //Variables a mandar
        $nameQueries = []; //Arreglo con los nombres de las columnas
        $datesQueries = []; //Arreglo con las fechas a ejecutar reporte
        $totalQueries = []; //Arreglo con el resumen
        $contentQueries = []; //Arreglo con el contenido del desglose
        $chartsQueries = []; //Arreglo con el script necesario para cada chart

        //Obtengo todos los queries relacionados a un reporte
        $queries = Query::where('reporte_id', $reporte_id)
            ->with('segmentos')
            ->with('dimension')
            ->with('metrica')
            ->with('columnsIgnore')
            ->get();

        //Recupero el rango de fechas en los que se ejecutara el reporte
        $startDate=Carbon::parse('last friday');
        $endDate=Carbon::parse('this week thursday');

        //Reporte por día
        //Mostrar los resultados de cada día
        //Mostrar acumulados por semana

        //Armo el arreglo de fechas
        while ($startDate->lte($endDate)) {

            $dates[] = $startDate->copy();
            array_push($datesQueries, $startDate->format('d/m/Y'));
            $startDate->addDay();

        }

        //Recorro cada query y obtengo sus datos para ser ejecutados
        foreach ($queries as $query){
            //Obtengo los datos para ejecutar el query
            $metricas = $this->getMetrics($query['metrica']);
            $dimensiones = $this->getDimensions($query['dimension']);
            $segmentos = $this->getSegments($query['segmentos']);
            $columnasIgnore = $this->getColumnasI($query['columnsIgnore']);
            $filtro = $query['filtro'];
            $maxResults = $query['max_results'];
            $sort = $query['sort'];

            //Obtengo el nombre de la columna
            array_push($nameQueries, $query['nombre']);

            //Por cada fecha ejecutar el query
            $finalQuery = [];
            $length = count($dates);
            for($i = 0; $i < $length; ++$i) {

                array_push($finalQuery, $this->analyticQuery(current($dates),current($dates), $metricas,
                    $dimensiones, $segmentos, $columnasIgnore, $filtro, $maxResults, $sort));

                next($dates);

            }

            //Añado arrays vacios en caso de que el numero de rows no sea el mismo
            for($m = 0; $m < count($finalQuery); $m++){
                if(count($finalQuery[$m]) < $maxResults){
                    while(count($finalQuery[$m]) < $maxResults){
                        array_push($finalQuery[$m], ["-", 0]);
                    }

                }
            }

            array_push($contentQueries, $finalQuery);

            //Obtener resumen en un periodo
            array_push($totalQueries, $this->analyticQuery($dates[0], last($dates), $metricas, $dimensiones, $segmentos,
                $columnasIgnore, $filtro, $maxResults, $sort));

            reset($dates);
        }

        //Creo el ejecutable de cada chart--------------------
        $chartsQueries = $this->graphs($contentQueries, $datesQueries, $nameQueries);

        //return([$contentQueries, $nameQueries, $datesQueries, $totalQueries, $chartsQueries]);
        JavaScript::put([
            'contentQueries' => $contentQueries,
            'namesQueries' => $nameQueries ,
            'datesQueries' => $datesQueries,
            'totalQueries' => $totalQueries,
            'chartsQueries' => $chartsQueries
        ]);

        return View::make('reporte/reporte');

        /*return view('reporte/reporte', ['content' => $contentQueries,'names' => $nameQueries ,'dates' => $datesQueries, 
            'total' => $totalQueries, 'charts' => $chartsQueries]);*/
    }

    //Funcion para obtener las claves de cada metrica para la ejecución del query
    private function getMetrics($metricas){
        $finalMets = [];
        foreach ($metricas as $metric){
            array_push($finalMets, $metric['clave']);
        }
        return $finalMets;
    }

    //Funcion para obtener las claves de cada dimension para la ejecución del query
    private function getDimensions($dimensiones){
        $finalDims = [];
        foreach ($dimensiones as $dimension){
            array_push($finalDims, $dimension['clave']);
        }
        return $finalDims;
    }

    //Función para obtener la clave de las columnas que seran eliminadas del query final
    private function getColumnasI($columnsI){
        $finalCol = [];
        foreach ($columnsI as $column){
            array_push($finalCol, $column['label']);
        }
        return $finalCol;
    }

    //Función para obtener las claves de cada segmento para la ejecución del query
    private function getSegments($segmentos){
        $finalSegs = [];
        foreach ($segmentos as $segmento){
            array_push($finalSegs, $segmento['clave']);
        }
        return $finalSegs;
    }

    //Función para adaptar los datos y ejecutar el query
    private function analyticQuery($fechaI, $fechaF, $metricas, $dimensiones, $segmentos,
                                   $columnasIgnore, $filtro, $maxResults, $sort){

        $metricasq = implode(',', $metricas);

        //Guardo en un array los headers del query--------------------------------------
        $headers=[];
        $key = 0;
        //Reviso si hay dimensiones
        if($dimensiones){
            $dimensionsq = $dimensiones;
            foreach ($dimensionsq as $head){
                $headers=array_add($headers, $key, $head);
                $key++;
            }
        }else{
            $dimensionsq =[];
        }

        //Guardo las metricas
        foreach ($metricas as $head){
            $headers=array_add($headers,$key, $head);
            $key++;
        }

        //Reviso que los parametros sort filters y segment  tengan contenido-----------------------
        if ($sort){
            $sortq=$sort;
        }else{
            $sortq=null;
        }

        if($filtro){
            $filtersq= $filtro;
        }else{
            $filtersq=null;
        }

        if($segmentos){
            $segmentq= $segmentos[0];
        }else{
            $segmentq=null;
        }

        if($maxResults){
            $maxq= $maxResults;
        }else{
            $maxq=null;
        }

        //Armo el array 'otros' para el Query--------------------------------------------
        $others=[
            'dimensions' => implode( ',' , $dimensionsq),
            'sort' => $sortq,
            'filters' => $filtersq,
            'segment' => $segmentq,
            'max-results' => $maxq,
        ];

        //Compruebo que el Query se ejecuto correctamente----------------------------------
        try{
            //Guardo la ejecución del query en una variable
            $analyticsData = LaravelAnalytics::setSiteId('ga:120480271')->performQuery(
                $fechaI,
                $fechaF,
                $metricasq,
                $others
            );
        }catch (\Exception $e){
            $error =["La query no se pudo ejecutar: revisa los campos"];
            return response()->json(array('errors' => $error, 200));
        }

        $resultRows = $analyticsData->rows; //variable con el resultado de la query

        if($resultRows == null){
            if(count($metricasq) == 1 && count($dimensionsq) ==0){
                $resultRows = [[0]];
            }else{
                $resultRows =[['-', 0]];
            }

        }
        //Si hay columnas que ignorar las elimino del arreglo final
        if(count($columnasIgnore) > 0){
            foreach ($columnasIgnore as $column){
                //Busco la columna que se quiere eliminar
                if(in_array($column, $headers)){
                    $columnPosition = array_search($column, $headers);
                    foreach($resultRows as $key => $row){
                        unset($resultRows[$key][$columnPosition]);
                    }
                }
            }
        }
        foreach($resultRows as $pos => $row){
            $resultRows[$pos]= array_values($resultRows[$pos]);
        }
        return $resultRows;
    }

    //Funcion para obtener los charts de un reporte
    private function graphs($contentQueries, $dateQueries, $nameQueries){
        $charts=[];
        $labels= $dateQueries;
        $result= $contentQueries;

        //adapto los datos
        for($i =0; $i<count($result); $i++){
            $total=[];

            if(count($result[$i][0]) == 1){
                //Query sencilla
                for($j=0; $j<count($result[$i]); $j++){
                    array_push($total, floatval(number_format(floatval($result[$i][$j][0][0]), 2)));
                }

                //Creo el chart ----- Query sencillo
                $chart = new Highchart();
                $chart->chart = array(
                    'renderTo' => 'chart-' . $i,
                    'type' => 'line'
                );
                $chart->title = array('text' => $nameQueries[$i]);
                $chart->xAxis->categories = $labels;
                $chart->yAxis->title->text = 'Total';
                $chart->tooltip->enabled = false;
                $chart->tooltip->formatter = new HighchartJsExpr(
                                "function() {
                    return '<b>' + this.series.name + '</b><br/>' +
                        this.x + ': ' + this.y;
                }");
                $chart->plotOptions->line->dataLabels->enabled = true;
                $chart->plotOptions->line->enableMouseTracking = false;
                $chart->series[] = array('name' => $nameQueries[$i], 'data' => $total);

                array_push($charts, $chart->render());

            }else{
                $chart = new Highchart();
                $chart->chart = array(
                    'renderTo' => 'chart-' . $i,
                    'type' => 'line'
                );

                //Query compleja
                for($k=0; $k<count($result[$i][0]); $k++){
                    $subdata = [];
                    for($j=0; $j<count($result[$i]); $j++){
                        //subdata.push(result[i][j][k][1]);
                        array_push($subdata, floatval(number_format(floatval($result[$i][$j][$k][1]), 2)));
                    }
                    array_push($total, $subdata);

                }

                //Creo el chart
                $sets = [];
                for($x=0; $x<count($total); $x++){
                    //creo el array de datasets
                    $chart->series[] = array('name' => $result[$i][0][$x][0], 'data' => $total[$x]);
                }
                $chart->title = array('text' => $nameQueries[$i]);
                $chart->xAxis->categories = $labels;
                $chart->yAxis->title->text = 'Total';
                $chart->tooltip->enabled = false;
                $chart->tooltip->formatter = new HighchartJsExpr(
                                "function() {
                    return '<b>' + this.series.name + '</b><br/>' +
                        this.x + ': ' + this.y;
                }");
                $chart->plotOptions->line->dataLabels->enabled = true;
                $chart->plotOptions->line->enableMouseTracking = false;
                array_push($charts, $chart->render());
            }
        }
        return $charts;
    }
}
