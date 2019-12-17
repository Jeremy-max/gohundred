<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Keyword extends Model
{
    use Notifiable;
    protected $fillable = ['campaign_id', 'keyword'];
    public $timestamps = true;

    public function searches()
    {
        return $this->hasMany('App\Search');
    }

    public function campaign()
    {
        return $this->belongsTo('App\Campaign');
    }

}
