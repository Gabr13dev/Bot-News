<?php

use Discord\Discord;
use Discord\WebSockets\Intents;
use Discord\WebSockets\Event;

include __DIR__.'/vendor/autoload.php';

$discord = new Discord([
    'token' => 'OTY4NTgyNzI0MDgyMzY4NjAz.Ymg89A.pLiOEkNTwwwj93A20waF2Vl5Vj4'
]);


$discord->on('ready', function (Discord $discord) {
    echo "Bot is ready" , PHP_EOL;

    $discord->on(Event::MESSAGE_CREATE, function ($message, Discord $discord) {
        if($message->author->bot) {
            return;
        }

        if($message->content == "#news") {
            $url = "http://servicodados.ibge.gov.br/api/v3/noticias/";
            $json = file_get_contents($url);
            $obj = json_decode($json);
            $notice_id = rand(0, (int)$obj->count);
            $reply = "";
            $reply .= "**Notícias do IBGE**" . PHP_EOL;
            $reply .= "**Data:** ".$obj->items[$notice_id]->data_publicacao . PHP_EOL;
            $reply .= "**Título:** ".$obj->items[$notice_id]->titulo . PHP_EOL;
            $reply .= "**Link:** ".$obj->items[$notice_id]->link . PHP_EOL;
            $message->reply($reply);
        }
    });
});

$discord->run();