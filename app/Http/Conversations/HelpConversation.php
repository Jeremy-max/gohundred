<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class HelpConversation extends Conversation
{
    public function askHelp()
    {
        $question = Question::create('Please tell us what you need to know:')
            ->callbackId('help')
            ->addButtons([
                Button::create('What is a campaign?')->value('1'),
                Button::create('Can I sign up for free?')->value('2'),
                Button::create('How do I sign up?')->value('3'),
                Button::create('How do I upgrade my account?')->value('4'),
                Button::create('How do I use the dashboard?')->value('5'),
                Button::create('Can I sign up from any country?')->value('6'),
                Button::create('What is EUR?')->value('7'),
                Button::create('Can I delete my account?')->value('8'),
                Button::create('Do you want to talk to a human?')->value('9'),
            ]);

        $this->ask($question, function(Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                switch($answer->getValue())
                {
                    case 1:
                        $message = '<strong>Answer</strong>:<br> A campaign is a search on a topic, company or a competitor. By entering one or several keywords, the dashboard will find and display information from Social Media. Example: You are an ice-cream store and you want to know more about what is happening in the ice-cream business. You enter the keywords: Ice cream, new store, vegan ice cream. These keywords form a campaign and you will get information every time these keywords are used on Social Media. ';
                        break;
                    case 2:
                        $message = '<strong>Answer</strong>:<br> Yes, you can sign up at any time for a 14-day free trial. When the trial ends, you can upgrade your account to keep using GoHundred.';
                        break;
                    case 3:
                        $message = '<strong>Answer</strong>:<br> You can sign up clicking on the “Get me started”-button. Next you will be redirected to the sign up form, where you can enter your information.';
                        break;
                    case 4:
                        $message = '<strong>Answer</strong>:<br> You can upgrade your account from the profile tab in the right corner of your dashboard. Click “Upgrade plan” and you will be redirected to the upgrade page.';
                        break;
                    case 5:
                        $message = '<strong>Answer</strong>:<br> The dashboard consists of a range of functionalities. The table displays the data collected on each of your campaigns. Use the filters to display only the data you wish to see. You will be able to export the data to an excel file.';
                        break;
                    case 6:
                        $message = '<strong>Answer</strong>:<br> Yes, wherever you are located in the world, you can sign up to GoHundred and use the dashboard search service.';
                        break;
                    case 7:
                        $message = '<strong>Answer</strong>:<br> EUR is short for Euro, which is the European common currency.';
                        break;
                    case 8:
                        $message = '<strong>Answer</strong>:<br> Yes, as GoHundred is GDPR compliant, you have the right to at any time withdraw your consent to being registered as a user on GoHundred. In order to delete your account, simply go to your profile settings and click “Delete my account”. When you have deleted your account, GoHundred will no longer be in possession of any data that you have entered into your profile when you registered.';
                        break;
                    case 9:
                        $message = '<strong>Answer</strong>:<br>Sorry, my teammates are asleep, but you can leave your email address here and they will get back to you shortly!';
                        break;

                }
                $this->say($message);
                $this->askAgain();
            }
        });


    }

    public function askAgain()
    {

        $this->ask("Please write 'q' to ask again.", function(Answer $answer) {
            if($answer->getText() == 'q')
            {
                $this->run();
            }
        });
    }

    public function run()
    {
        $this->askHelp();
    }
}
