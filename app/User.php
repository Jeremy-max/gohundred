<?php

namespace App;

use App\Notifications\NewUserRegistered;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Notifiable;
    use Billable;

    // protected static function boot(){

    //     parent::boot();

    //     self::created(function($model){
    //         $model->notify(new NewUserRegistered());
    //     });
    // }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'country', 'login_via_google', 'login_via_facebook'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function campaigns()
    {
        return $this->hasMany('App\Campaign');
    }

    // public function routeNotificationFor($driver)
    // {
    //     return env('WEBHOOK_URL');
    // }
}
