<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use App\Http\Conversations\HelpConversation;


class PrivacyPolicyConversation extends Conversation
{
    public function privacyPolicy()
    {
        $message = 'Hi there! <br><br>';
        $message .= 'GoHundred would love to talk to you. In accordance with EU’s General Protection Regulation, we need your consent before we receive your personal information (your name and email address). <br><br>';
        $message .= '<strong>Please note:<strong> <br>';
        $message .= '1. We will store this information, so we are able to follow-up with you later.<br>';
        $message .= '2. We may send you further information about GoHundred and our services. <br>';
        $message .= 'Is this OK for you?<br>';
        $email = '<a href="mailto:email@email.com">email@email.com</a>';
        $message .= '<a target="_blank" href="https://gohundred.co/privacy_policy">View Privacy policy</a> <br><br>';
        $this->say($message);

        $question = Question::create('What kind of Service you are looking for?')
            ->callbackId('privacy_policy')
            ->addButtons([
                Button::create('Yep, that’s fine, let’s chat!')->value('yes'),
                Button::create('Nope, not now. ')->value('no'),
            ]);

        $this->ask($question, function(Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {

                if($answer->getValue() == 'yes')
                {

                    $this->bot->startConversation(new HelpConversation());
                }else{
                    $this->say('Ok, sorry to hear, but you’re always welcome!');
                }
            }
        });

    }

    public function run()
    {
        $this->privacyPolicy();
    }
}
