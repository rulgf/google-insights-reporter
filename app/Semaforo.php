<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Semaforo extends Model
{
    /**
     * The attributes that are mass assignable.
     *trtr
     * @var array
     */
    protected $fillable = [
        'metrica_id', 'nombre', 'condicion', 'parametro', 'estado'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    protected $table = 'semaforo';
    /**
     * Create a new Alerta instance.
     *
     * @param  Request  $request
     * @return Response
     */
    public static function store(Request $request,$cuenta_id){
        $semaforo = new Semaforo();
        $semaforo->metrica_id = $request->metrica;
        $semaforo->cuenta_id = $cuenta_id;
        $semaforo->nombre = $request->nombre;
        $semaforo->condicion = $request->condicion;
        $semaforo->parametro = $request->parametro;
        $semaforo->estado = 0;
        $semaforo->obtained = 0;
        if($semaforo->save()){
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
