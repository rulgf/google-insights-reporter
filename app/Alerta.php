<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Alerta extends Model
{
    /**
     * The attributes that are mass assignable.
     *trtr
     * @var array
     */
    protected $fillable = [
        'metrica_id', 'nombre', 'condicion', 'parametro', 'status',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    protected $table = 'alerta';
    /**
     * Create a new Alerta instance.
     *
     * @param  Request  $request
     * @return Response
     */
    public static function store(Request $request,$cuenta_id){
        $alerta = new Alerta();
        $alerta->metrica_id = $request->metrica;
        $alerta->cuenta_id = $cuenta_id;
        $alerta->nombre = $request->nombre;
        $alerta->condicion = $request->condicion;
        $alerta->parametro = $request->parametro;
        $alerta->status = $request->status;
        if($alerta->save()){
            return true;
        }
        return true;
    }

    public function metricas(){
        return $this->belongsTo('App\Metrica', 'metrica_id');
    }

    public function cuenta(){
        return $this->belongsTo('App\Cuentas', 'cuenta_id');
    }
}
