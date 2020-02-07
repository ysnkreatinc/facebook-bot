<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use App\Conversations\ExampleConversation;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;


class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->listen();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tinker()
    {
        return view('tinker');
    }

    /**
     * Loaded through routes/botman.php
     * @param  BotMan $bot
     */
    public function startConversation(BotMan $bot)
    {
        $bot->startConversation(new ExampleConversation());
    }

    public function data(){

        //Session::put('key1', 'val1');
        //session::put('key2', 'val2');

        return session('key2');

        $converstion = [
            'greetings' => [
                'hasBeenResponded' => false,
                'responses' => [
                    ['Hello, How i can help you today ?', false], // false mean that this response has already used.
                    ['Hello, can i do something for you ?', false],
                ],
                'foo' => [
                    'Realy!!!'
                ]
            ]
        ];


        $client = new Client();
        $result = $client->get('https://api.wit.ai/message?v=20200206&q=hello', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ZBQE6FF7EGSC3ILKNQWBZ2MIYYILBUJL'
            ]
        ]);

        $dataIntent = json_decode($result->getBody());

        $arr = array();
              
        foreach ($dataIntent->entities as $key => $val){
 

            if ($key == 'greetings'){

                foreach($val as $key2 => $val2){
                    if($val2->confidence * 100 > 70)
                        return ("Hello, how can i help you ?");
                }

            }
            
         
         else if ($val[0]->value == 'learn'){
             return ("What do you learn ?");
         }
         
         else if ($key == 'langs'){

            foreach($val as $key2 => $val2){
                if($val2->confidence * 100 > 70)
                    return ("What's your level ?");
            }

            
         }
 
         else if ($key == 'levels'){
             return ("Where are you from ?");
         }
 
         else if ($key == 'location'){
             return ("Please give us your email address.");
         }
 
         else if ($key == 'email'){
             return ("Please enter you phone number.");
         }
         else if($key == 'phone_number')
             return ("Thank you so much, an email has been, please verify! GoodBye :D");

             /*
            foreach ($dataIntent->entities->$key as $key2 => $val2){
                if($val2->confidence  > 50 ){

                }
            }
            */
            /*
            if ($key == 'intent' && $dataIntent->entities->greetings[0]->confidence * 100 > 50 )
                return 'its greeting';
            */
        }

        return dd($arr);

        //return array_key_exists('greetings', $dataIntent->entities->greetings);
        //return count($dataIntent->entities->greetings);
        //return $dataIntent->entities->greetings[0]->value;
    }
}
