<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Tipo extends Model
{
    /**
     * The attributes that are mass assignable.
     *trtr
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    protected $table = 'tipo';

    /**
     * Create a new metrica instance.
     *
     * @param  Request  $request
     * @return Response
     */
    public static function store(Request $request){
        $tipo = new Tipo();
        $tipo->nombre = $request->nombre;
        if($tipo->save()){
            return true;
        }
        return true;
    }

    public function queries(){
        return $this->hasMany('App\Query','query_id','metrica_id');
    }

    public function dimension(){
        return $this->hasMany('App\Dimension','dimension_id','tipo_id');
    }

    public function metrica(){
        return $this->hasMany('App\Metrica','metrica_id','tipo_id');
    }
}
