<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use App\Conversations\ExampleConversation;
use App\Conversations\CustomConversation;
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

    public function startCustomConversation(BotMan $bot)
    {
        $bot->startConversation(new CustomConversation());
    }

    public function data(){

        $client = new Client();
        $result = $client->get('https://api.wit.ai/message?v=20200206&q=hello', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ZBQE6FF7EGSC3ILKNQWBZ2MIYYILBUJL'
            ]
        ]);

        //$dataIntent = json_decode($result->getBody());

              
    }

    public function optin(){
        return view('optin');
    }
}
