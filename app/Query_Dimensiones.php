<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Query_Dimensiones extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'query_dimensiones';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['remember_token'];
}
