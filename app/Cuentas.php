<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Cuentas extends Model
{
    /**
     * The attributes that are mass assignable.
     *trtr
     * @var array
     */
    protected $fillable = [
        'nombre', 'siteId', 'nombre_cliente', 'mail_cliente', 'active', 'semaforo_state', 'campaign_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    protected $table = 'cuentas';
    /**
     * Create a new cuenta instance.
     *
     * @param  Request  $request
     * @return Response
     */
    public static function store(Request $request){
        $cuenta = new Cuentas();
        $cuenta->nombre = $request->nombre;
        $cuenta->siteId = 'ga:' . $request->siteId;
        $cuenta->nombre_cliente = $request->nombre_cliente;
        $cuenta->mail_cliente = $request->email_cliente;
        $cuenta->active = $request->active;
        $cuenta->semaforo_state = 0;
        $cuenta->campaign_id = $request->campaign_id;
        if($cuenta->save()){
            return true;
        }
        return true;
    }

    public function reporte(){
        return $this->hasMany('App\Reporte', 'cuenta_id');
    }

    public function alerta(){
        return $this->hasMany('App\Alerta','alerta_id','cuenta_id');
    }

    public function dimension(){
        return $this->hasMany('App\Dimension','dimension_id','cuenta_id');
    }

    public function metrica(){
        return $this->hasMany('App\Metrica','metrica_id','cuenta_id');
    }

    public function semaforo(){
        return $this->hasMany('App\Semaforo', 'cuenta_id');
    }
}
