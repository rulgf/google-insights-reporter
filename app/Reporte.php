<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    /**
     * The attributes that are mass assignable.
     *trtr
     * @var array
     */
    protected $fillable = [
        'nombre', 'descripcion', 'cuenta_id', 'mail_active'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    protected $table = 'reportes';
    /**
     * Create a new reporte instance.
     *
     * @param  Request  $request
     * @return Response
     */
    public static function store(Request $request, $id){
        $reporte = new Reporte();
        $reporte->cuenta_id = $id;
        $reporte->nombre = $request->nombre;
        $reporte->descripcion = $request->descripcion;
        $reporte->mail_active = $request->mail_active;
        if($reporte->save()){
            return $reporte;
        }
        return true;
    }

    public function cuenta(){
        return $this->belongsTo('App\Cuentas', 'cuenta_id');
    }

    public function active_reports() {
        return $this->cuenta()->where('active','=', 0);
    }

    public function historia(){
        return $this->hasMany('App\Historia','historia_id','reporte_id');
    }

    public function queries(){
        return $this->hasMany('App\Query','query_id','reporte_id');
    }
}
