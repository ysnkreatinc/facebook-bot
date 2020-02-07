<?php
use App\Http\Controllers\BotManController;
use Botman\Botman\Messages\Outgoing\OutgoingMessage;
use Botman\BotMan\Messages\Attachments\Image;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

$botman = resolve('botman');


$botman->hears('{msg}', function ($bot, $msg) {

    // Do Request to Wit.ai to get Intities.
    $client = new Client();
    $result = $client->get('https://api.wit.ai/message?v=20200206&q='.$msg, [
        'headers' => [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ZBQE6FF7EGSC3ILKNQWBZ2MIYYILBUJL'
        ]
    ]);

    // Parsing body content to json.
    $dataIntent = json_decode($result->getBody());
    // Fetching json to get keys and get entities      
    foreach ($dataIntent->entities as $key => $val)
    {
 

        if ($key == 'greetings'){
           $bot->reply("Hello, how can i help you ?");
            break;
        }

        else if ($val[0]->value == 'learn'){
            $bot->reply("What do you learn ?");
         break;
        }
        
        else if ($key == 'langs'){
            
            foreach($val as $key2 => $val2){
                if($val2->confidence * 100 > 70){
                    $bot->reply("What's your level ?");
                    Session::put('langs', $msg);
                    break;
                }
            }

        }

        else if ($key == 'levels'){
            Session::put('levels', $msg);
            $bot->reply("Where are you from ?");
        }

        else if ($key == 'location'){
            Session::put('location', $msg);
            $bot->reply("Please give us your email address.");
            break;
        }

        else if ($key == 'email'){
            Session::put('email', $msg);
            $bot->reply("Please enter you phone number.");
            break;
        }

        else if($key == 'phone_number')
        {
            Session::put('phone', $msg);
            Session::put('finish', true);
            $bot->reply("Thank you so much, an email has been, please verify! GoodBye :D");
            break;
        }
    }
    
    if (Session::has('key'))
    {
        $bot->reply('You want to learn : '. session('langs') . 
        ' You Level is : '. session('levels') .
        ' You are from : '. session('location').
        ' Email : '. session('email').
        ' Phone number : '. session('phone')
        );
        //Session::flush();
    }
    
    //$bot->reply(session('key'));
    //Session::flush();
});
//$botman->hears('Start conversation', BotManController::class.'@startConversation');
