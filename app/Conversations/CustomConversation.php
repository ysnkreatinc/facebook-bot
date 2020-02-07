<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class CustomConversation extends Conversation
{
    public function askQuestion()
    {
        $question = Question::create("This is kreatinc, What do you need ?")
                    ->fallback("Unable to ask question")
                    ->callbackId("asking")
                    ->addButtons([
                        Button::create('Addresse ?')->value('adr'),
                        Button::create('Mobile ?')->value('mon'),
                    ]);

        return $this->ask($question, function(Answer $answer){

            if ($answer->isInteractiveMessageReply()){
                if ($answer->getValue() === 'adr')
                {
                    $this->say('Here our Address');
                }
                else
                {
                    $this->say('Here our mobile');
                }
            }

        });

    }

    public function run()
    {
        return $this->askQuestion();
    }
}
