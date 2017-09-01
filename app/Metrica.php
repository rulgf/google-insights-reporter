<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Metrica extends Model
{
    /**
     * The attributes that are mass assignable.
     *trtr
     * @var array
     */
    protected $fillable = [
        'nombre', 'clave', 'cuenta_id', 'tipo_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    protected $table = 'metrica';

    /**
     * Create a new metrica instance.
     *
     * @param  Request  $request
     * @return Response
     */
    public static function store(Request $request, $id){
        $metrica = new Metrica();
        $metrica->cuenta_id = $id;
        $metrica->tipo_id = $request->tipo_id;
        $metrica->nombre = $request->nombre;
        $metrica->clave = $request->clave;
        if($metrica->save()){
            return true;
        }
        return true;
    }

    public function queries(){
        return $this->hasMany('App\Query','query_id','metrica_id');
    }

    public function tipo(){
        return $this->belongsTo('App\Tipo', 'tipo_id');
    }

    public function cuenta(){
        return $this->belongsTo('App\Cuentas', 'cuenta_id');
    }

    public function alerta(){
        return $this->hasMany('App\Alerta');
    }
}
