<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Historia extends Model
{
    /**
     * The attributes that are mass assignable.
     *trtr
     * @var array
     */
    protected $fillable = [
        'reporte_id', 'fecha_inicio', 'fecha_final',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    protected $table = 'historia';
    
    /**
     * Create a new historia instance.
     *
     * @param  Request  $request
     * @return Response
     */
    public static function store(Request $request){
        $historia = new Historia();
        $historia->reporte_id = $request->reporte_id;
        $historia->fecha_inicio = $request->fecha_inicio;
        $historia->fecha_final = $request->fecha_final;
        if($historia->save()){
            return true;
        }
        return true;
    }

    public function reporte(){
        return $this->belongsTo('App\Reporte', 'reporte_id');
    }
}
