<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Audio;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

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

    public function about(BotMan $bot)
    {
        $user = $bot->getUser();
        $username = $user->getUsername();
        $name = $user->getFirstName();

        $bot->typesAndWaits(3);

        $sender = is_null($username) ? $name : "@" . $username;

        $bot->reply("{$sender},\nEu sou um bot criado por campuseros, para campuseros 😁");
        $bot->reply("Se você quiser saber como eu funciono, pode dar uma olhadinha no meu código:\nhttps://github.com/CampuserosClub/CampuserosBot", [
            'disable_web_page_preview' => true,
        ]);
    }

    public function biscoitoBolacha(BotMan $bot)
    {
        $img = new Image('https://i.imgur.com/CRJaNRJ.png');
        $message = OutgoingMessage::create('É biscoito ou bolacha?')->withAttachment($img);
        $this->replySender($bot, $message);
    }

    public function cafe(BotMan $bot)
    {
        $stickers = collect([
            'BQADAQADigADc6QYA5uQxxPZmMZGAg',
            'BQADAQADYQADC1TfAAHnb5n94sar6AI',
            'BQADAgADgAADGgZFBBPEOyAbYERuAg',
            'BQADAQADVgEAAtpxZgdD4Q1UGK41qgI',
        ]);

        $bot->sendRequest('sendSticker', ['sticker' => $stickers->random()]);
    }

    public function gas(BotMan $bot)
    {
        $this->recordingAudio($bot);
        $audio = new Audio('https://www.myinstants.com/media/sounds/oooo-o-gas-oia-o-gas.mp3');
        $message = OutgoingMessage::create()->withAttachment($audio);
        $this->replySender($bot, $message);
    }

    public function grito(BotMan $bot)
    {
        $gritos = collect([
            'OooOOOOOOOoooOoooooo',
            'ooooooOOOOOoooOOOOooooo',
            'oooooooOOOOOOOOoooooO',
            'OooOOOOOOOoooo',
            'OoooOoooOoOOO',
        ]);

        $this->replySender($bot, $gritos->random());
    }

    private function replySender(Botman $bot, $message)
    {
        $payload = $bot->getMessage()->getPayload();
        $replyTo = $payload['message_id'];

        $bot->reply($message, ['reply_to_message_id' => $replyTo]);
    }

    private function recordingAudio(Botman $bot)
    {
        $bot->sendRequest('sendChatAction', ['action' => 'record_audio']);
    }
}
