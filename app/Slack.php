<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slack extends Model
{
    protected $fillable = ['campaign_id', 'team_name', 'channel', 'channel_id', 'webhook_url', 'configuration_url'];

}
