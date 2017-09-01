<?php

namespace App\Http\Controllers\Segmento;

use App\Segmento;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SegmentoController extends Controller
{
    public function getSegmentos(){
        $segmentos = Segmento::select('id as value', 'clave as label', 'nombre as name')->get();
        
        return $segmentos;
    }
}
