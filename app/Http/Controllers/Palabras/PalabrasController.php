<?php

namespace App\Http\Controllers\Palabras;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use LaravelAnalytics;
use Carbon\Carbon;
use App\Cuentas;

class PalabrasController extends Controller
{
    public function countWords($id, $startDate, $endDate){
        //Fechas
        $expression = '/\((.*)*\)/';
        $initialDate = Carbon::parse(preg_replace($expression, '', $startDate));
        $finalDate = Carbon::parse(preg_replace($expression, '', $endDate));

        //Recuperar ID de la campaña asociada a la cuenta y el nombre de la cuenta
        $cuenta= Cuentas::where('siteId', $id)->get()->first();

        if($cuenta->campaign_id == null){
            $filter= 'ga:campaign=@'.$cuenta->nombre;
        }else{
            $filter= 'ga:adwordsCampaignID=='.$cuenta->campaign_id.',ga:campaign=@'.$cuenta->nombre;
        }

        $others=[
            'dimensions' => 'ga:adMatchedQuery,ga:campaign,ga:adwordsCampaignID',
            'sort' => null,
            'filters' => $filter,
            'segment' => null,
            'max-results' => null,
        ];

        //Compruebo que el Query se ejecuto correctamente----------------------------------
        try{
            //Guardo la ejecución del query en una variable
            $analyticsData = LaravelAnalytics::setSiteId($id)->performQuery(
                $initialDate,
                $finalDate,
                'ga:impressions,ga:CPC,ga:adClicks',
                $others
            );
        }catch (\Exception $e){
            $error =["La query no se pudo ejecutar: revisa los campos"];
            return false;
        }

        $results= $analyticsData->rows;
        $finalwords= collect([]);

        //ARTICULOS Y PREPOSICIONES QUE DEBEN SER IGNORADOS
        $articulos = array('unos', 'unas', 'este','estos', 'esos', 'aquel', 'aquellos', 'esta', 'estas', 'esas',
            'aquella', 'aquellas', 'éste', 'éstos', 'ésos', 'aquél', 'aquéllos', 'ésta', 'éstas', 'ésas', 'aquélla',
            'aquéllas', 'el', 'la', 'los', 'un', 'una', 'del', 'de');

        $preposiciones = array('a', 'ante', 'bajo', 'cabe', 'con','contra', 'de' ,'desde', 'durante', 'excepto',
            'en', 'mediante', 'hacia', 'hasta', 'para', 'por', 'salvo', 'según', 'sin', 'sobre', 'tras');

        
        //Recorrer cada resultado y crear un objeto por palabra
        foreach ($results as $result){
            //Creo un array con las palabras usadas
            $words = explode(" ", $result[0]);
            
            foreach ($words as $word){

                //dd($articulosPreposiciones);

                if (!in_array($word, $articulos) && !in_array($word, $preposiciones)){
                    //Busco que ya este registrada la palabra
                    $repeatedWords = $finalwords->contains('palabra', $word);

                    if($repeatedWords){
                        //Existe la palabra actualizar registro
                        $actualword= $finalwords->where('palabra', $word)->first();

                        $actualword['impresiones']= $actualword['impresiones']+intval($result[3]);//total de impresiones
                        array_push($actualword['cpc'], floatval($result[4]));// cpc actualizado
                        $actualword['avg']= array_sum($actualword['cpc'])/count($actualword['cpc']); //promedio cpc
                        $actualword['clicks']= $actualword['clicks']+intval($result[5]);//total de clicks
                        $actualword['costo']= $actualword['avg']*$actualword['clicks'];

                        $finalwords = $finalwords->keyBy('palabra');
                        $finalwords->forget($word);

                        $finalwords->push($actualword);


                    }else{
                        //No existe la palabra crear nuevo registro
                        $finalwords->push([
                            'palabra'=>$word,
                            'impresiones'=> intval($result[3]),
                            'cpc'=>[floatval($result[4])],
                            'avg'=>floatval($result[4]),
                            'clicks' =>intval($result[5]),
                            'costo' =>floatval($result[5]) * floatval($result[4])
                        ]);
                    }
                }

                $finalwords = $finalwords->keyBy('palabra');
            }
        }
        return($finalwords);
    }


    public function topTen(Request $request, $id){
        $fechaI = $request->fecha_inicial;
        $fechaF = $request->fecha_final;
        $topTen = $this->countWords($id, $fechaI, $fechaF);
        if($topTen){
            $topTen = $topTen->sortByDesc('impresiones');
            $rest = $topTen->splice(10);
            return $topTen;
        }else{
            return response()->json(array('errors' => ["No se pudo ejecutar la consulta"], 200));
        }
    }

    public function worstTen(Request $request, $id){
        $fechaI = $request->fecha_inicial;
        $fechaF = $request->fecha_final;
        $topTen = $this->countWords($id, $fechaI, $fechaF);
        if($topTen){
            $topTen = $topTen->sortBy('impresiones');
            $rest = $topTen->splice(10);
            return $topTen;
        }else{
            return response()->json(array('errors' => ["No se pudo ejecutar la consulta"], 200));
        }
    }

    public function allWords(Request $request, $id){
        $fechaI = $request->fecha_inicial;
        $fechaF = $request->fecha_final;
        $all = $this->countWords($id, $fechaI, $fechaF);
        if($all){
            $all = $all->sortByDesc('impresiones');
            return $all;
        }else{
            return response()->json(array('errors' => ["No se pudo ejecutar la consulta"], 200));
        }
    }
}
