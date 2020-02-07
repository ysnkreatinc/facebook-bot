<?php
use App\Http\Controllers\BotManController;
use Botman\Botman\Messages\Outgoing\OutgoingMessage;
use Botman\BotMan\Messages\Attachments\Image;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use BotMan\Drivers\Facebook\Extensions\ButtonTemplate;
use BotMan\Drivers\Facebook\Extensions\ElementButton;
use BotMan\Drivers\Facebook\Extensions\Element;
use BotMan\Drivers\Facebook\Extensions\GenericTemplate;
use BotMan\Drivers\Facebook\Extensions\OpenGraphTemplate;
use BotMan\Drivers\Facebook\Extensions\OpenGraMediaTemplatephElement;
use BotMan\Drivers\Facebook\Extensions\MediaTemplate;
use BotMan\Drivers\Facebook\Extensions\MediaUrlElement;



$botman = resolve('botman');


$botman->hears('hi', function ($bot) {

    //$dataIntent = json_decode($result->getBody()); 
    /*
    $user = $bot->getUser();
    $bot->reply('Hello '.$user->getFirstName());
    */

           
            
    $bot->reply(ButtonTemplate::create('Do you want to know more about Kreatinc?')
        ->addButton(ElementButton::create('Tell me more')
            ->type('postback')
            ->payload('tellmemore')
        )
        ->addButton(ElementButton::create('Show me the website')
            ->url('http://kreatinc.com/')
        )
    );
 

});
//$botman->hears('Start conversation', BotManController::class.'@startConversation');
$botman->hears('Startme', BotManController::class.'@startCustomConversation');





$botman->hears('hi2', function ($bot) {


    $bot->reply(GenericTemplate::create()
    ->addImageAspectRatio(GenericTemplate::RATIO_SQUARE)
    ->addElements([
        Element::create('BotMan Documentation')
            ->subtitle('All about BotMan')
            ->image('http://botman.io/img/botman-body.png')
            ->addButton(ElementButton::create('visit')
                ->url('http://botman.io')
            )
            ->addButton(ElementButton::create('tell me more')
                ->payload('tellmemore')
                ->type('postback')
            ),
        Element::create('BotMan Laravel Starter')
            ->subtitle('This is the best way to start with Laravel and BotMan')
            ->image('http://botman.io/img/botman-body.png')
            ->addButton(ElementButton::create('visit')
                ->url('https://github.com/mpociot/botman-laravel-starter')
            ),
    ])
    );
 

});



$botman->hears('hi3', function ($bot) {

    $bot->reply(MediaTemplate::create()
        ->element(MediaUrlElement::create('video')
            ->url('https://www.facebook.com/liechteneckers/videos/10155225087428922/')
            ->addButtons([
                ElementButton::create('Web URL')->url('http://liechtenecker.at'),
                ElementButton::create('Web URL')->url('http://liechtenecker.at'),
                ElementButton::create('payload')->type('postback')->payload('test'),
            ])
        )
    );

});





$botman->hears('test', function ($bot) {
    $bot->reply('A test message');
});




$botman->on('facebook_optin', function($payload, $bot) {
    $bot->reply('Messaging referrals');
});

$botman->on('messaging_optins', function($payload, $bot) {
    if($payload === 'first shake')
        $bot->reply('Messaging optins playload');
    else
        $bot->reply('Messaging optins');
});













    // Do Request to Wit.ai to get Intities.
    /*
    $client = new Client();
    $result = $client->get('https://api.wit.ai/message?v=20200206&q='.$msg, [
        'headers' => [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ZBQE6FF7EGSC3ILKNQWBZ2MIYYILBUJL'
        ]
    ]);
    */
            