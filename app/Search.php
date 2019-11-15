<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    //
    protected $fillable = ['keyword_id', 'social_type', 'title', 'date', 'url'];
}
