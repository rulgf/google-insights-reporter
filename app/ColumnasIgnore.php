<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ColumnasIgnore extends Model
{
    /**
     * The attributes that are mass assignable.
     *trtr
     * @var array
     */
    protected $fillable = [
        'label', 'query_id', 'nombre'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    protected $table = 'columnasignore';

    /**
     * Create a new historia instance.
     *
     * @param  Request  $request
     * @return Response
     */
    public static function store($colig, $query_id){
        $columnasI = new ColumnasIgnore();
        $columnasI->query_id = $query_id;
        $columnasI->label = $colig['label'];
        $columnasI->nombre = $colig['nombre'];
        if($columnasI->save()){
            return true;
        }
        return true;
    }

    public function querie(){
        return $this->belongsTo('App\Query', 'query_id');
    }
}
