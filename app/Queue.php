<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Queue extends Model
{
    use Notifiable;
    protected $fillable = [];
}
