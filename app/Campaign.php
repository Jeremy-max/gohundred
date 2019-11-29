<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = ['user_id', 'campaign', 'type'];
    public $timestamps = true;
    
    public function keywords()
    {
        return $this->hasMany('App\Keyword');
    }
    
}
