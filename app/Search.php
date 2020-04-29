<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Search extends Model
{
    use Notifiable;
    protected $fillable = ['keyword_id', 'social_type', 'title', 'date', 'url', 'sentiment'];
}
