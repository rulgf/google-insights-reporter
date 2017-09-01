<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Segmento extends Model
{
    /**
     * The attributes that are mass assignable.
     *trtr
     * @var array
     */
    protected $fillable = [
        'nombre', 'clave',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    protected $table = 'segmentos';

    /**
     * Create a new segmento instance.
     *
     * @param  Request  $request
     * @return Response
     */
    public static function store(Request $request){
        $segmento = new Segmento();
        $segmento->nombre = $request->nombre;
        $segmento->clave = $request->clave;
        if($segmento->save()){
            return true;
        }
        return true;
    }

    public function querie(){
        return $this->belongsToMany('App\Query','query_segmento');
    }
}
