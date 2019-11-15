<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    protected $fillable = ['user_id', 'keyword', 'type', 'notification_type'];
    public $timestamps = true;
    
    public function searches()
    {
        return $this->hasMany('App\Search');
    }
    
}
