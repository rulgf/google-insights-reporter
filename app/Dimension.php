<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Dimension extends Model
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

    protected $table = 'dimension';

    /**
     * Create a new dimension instance.
     *
     * @param  Request  $request
     * @return Response
     */
    public static function store(Request $request, $id){
        $dimension = new Dimension();
        $dimension->cuenta_id = $id;
        $dimension->tipo_id = $request->tipo_id;
        $dimension->nombre = $request->nombre;
        $dimension->clave = $request->clave;
        if($dimension->save()){
            return true;
        }
        return true;
    }

    public function queries(){
        return $this->belongsToMany('App\Query','dimension_query');
    }

    public function tipo(){
        return $this->belongsTo('App\Tipo', 'tipo_id');
    }

    public function cuenta(){
        return $this->belongsTo('App\Cuentas', 'cuenta_id');
    }
}
