<?php

namespace App;

use App\Notifications\NewCampaignAddedNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Campaign extends Model
{
    use Notifiable;

    protected $fillable = ['user_id', 'campaign', 'type'];
    public $timestamps = true;

    public function keywords()
    {
        return $this->hasMany('App\Keyword');
    }

    protected static function boot(){

        parent::boot();

        self::created(function($model){
            $model->notify(new NewCampaignAddedNotification());
        });
    }
}
