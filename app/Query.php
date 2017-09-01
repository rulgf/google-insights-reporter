<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Query extends Model
{
    /**
     * The attributes that are mass assignable.
     *trtr
     * @var array
     */
    protected $fillable = [
        'filtro', 'nombre', 'operando_metrica', 'operando_total', 'max_results', 'reporte_id', 'tipo', 'sort'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    protected $table = 'query';

    /**
     * Create a new query instance.
     *
     * @param  Request  $request
     * @return Response
     */
    public static function store(Request $request, $reporte_id){
        $query = new Query();
        $query->reporte_id = $reporte_id;
        $query->filtro = $request->filtro;
        $query->nombre = $request->nombre;
        $query->sort = $request->sort[0]['label'];
        $query->max_results = $request->max_result;
        if($query->save()){
            return $query;
        }
        return true;
    }

    public static function storekpi($nombre, $reporte_id){
        $query = new Query();
        $query->reporte_id = $reporte_id;
        $query->nombre = $nombre;
        if($query->save()){
            return $query;
        }
        return true;
    }

    public function reporte(){
        return $this->belongsTo('App\Reporte', 'reporte_id');
    }

    public function dimension(){
        return $this->belongsToMany('App\Dimension','query_dimensiones','query_id','dimension_id');
    }

    public function metrica(){
        return $this->belongsToMany('App\Metrica', 'query_metricas', 'query_id', 'metrica_id');
    }

    public function columnsIgnore(){
        return $this->hasMany('App\ColumnasIgnore');
    }

    public function segmentos(){
        return $this->belongsToMany('App\Segmento', 'query_segmentos', 'query_id', 'segmento_id');
    }
}
