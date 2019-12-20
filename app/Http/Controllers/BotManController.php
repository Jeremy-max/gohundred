<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use App\Http\Conversations\PrivacyPolicyConversation;

class BotManController extends Controller
{

    public function handle()
    {
        $botman = app('botman');


        $botman->hears('{message}', function($botman, $message) {

            if ($message == 'Hi'|| $message == 'Hello' || $message == 'hi'|| $message == 'hello') {

                $botman->startConversation(new PrivacyPolicyConversation());
            }else{
                $botman->reply("Write 'Hi' or 'Hello' for starting chat");
            }

        });


        $botman->listen();
    }


    // public function tinker()
    // {
    //     return view('tinker');._(Hi|Hello)._
    // }

}

