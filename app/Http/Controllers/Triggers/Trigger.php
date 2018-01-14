<?php

namespace App\Http\Controllers\Triggers;

use BotMan\BotMan\BotMan;

abstract class Trigger
{
    /**
     * @var BotMan
     */
    protected $bot;
    protected $triggers = [];
    protected $texts = [];
    protected $stickers = [];
    protected $gifs = [];
    protected $voices = [];
    protected $message;

    public function __construct(BotMan $bot, $message = null)
    {
        $this->bot = $bot;
        $this->message = $message;

        $this->handle();
    }

    protected function handle()
    {
        if ($this->triggerWasFired()) $this->reply();
    }

    protected function triggerWasFired() {
        if (is_null($this->message) || empty($this->message)) return false;

        return $this->checkText($this->message, $this->triggers);
    }

    protected function checkText($text, $pattern)
    {
        return str_contains(strtolower($text), $pattern);
    }

    protected function reply() {
        $this->randomTexts();
        $this->randomStickers();
        $this->randomGifs();
        $this->randomVoices();
        $this->customReply();
    }

    protected function randomTexts() {
        $texts = collect($this->texts);

        if ($texts->isNotEmpty()) {
            $this->bot->reply($texts->random());
        }
    }

    protected function randomStickers() {
        $stickers = collect($this->stickers);

        if($stickers->isNotEmpty()) {
            $this->bot->sendRequest('sendSticker', [
                'sticker' => $stickers->random()
            ]);
        }
    }

    protected function randomGifs() {
        return null;
    }

    protected function randomVoices() {
        return null;
    }

    protected function customReply() {
        return null;
    }
}