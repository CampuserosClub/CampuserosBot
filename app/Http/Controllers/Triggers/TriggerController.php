<?php

namespace App\Http\Controllers\Triggers;

use App\Http\Controllers\TelegramController;
use Telegram\Bot\Api;

abstract class TriggerController extends TelegramController
{
    protected $triggers = [];
    protected $texts = [];
    protected $stickers = [];
    protected $gifs = [];

    protected $responses = [
        'text' => false,
        'sticker' => false,
        'gif' => false,
    ];

    public function __construct(Api $telegram)
    {
        parent::__construct($telegram);

        if ($this->hasTrigger()) {
            $this->handle();
        }
    }

    protected function hasTrigger()
    {
        if (!is_null($message = $this->message->getText())) {
            return $this->checkText($message, $this->triggers);
        }

        return false;
    }

    protected function checkText($text, $check)
    {
        return (str_contains(strtolower($text), $check));
    }

    protected function handle()
    {
        $this->handleTexts();
        $this->handleStickers();
        $this->handleGifs();
        $this->run();
    }

    protected function handleTexts()
    {
        $texts = collect($this->texts);

        if (!$texts->isEmpty()) {
            $this->telegram->sendMessage([
                'chat_id' => $this->chat->getId(),
                'text' => $texts->random(),
            ]);
        }
    }

    protected function handleStickers()
    {
        $stickers = collect($this->stickers);

        if (!$stickers->isEmpty()) {
            $this->telegram->sendSticker([
                'chat_id' => $this->chat->getId(),
                'sticker' => $stickers->random(),
            ]);
        }
    }

    protected function handleGifs()
    {
        $gifs = collect($this->gifs);

        if (!$gifs->isEmpty()) {
            $this->telegram->sendDocument([
                'chat_id' => $this->chat->getId(),
                'document' => $gifs->random(),
            ]);
        }
    }

    protected function run() {
        return null;
    }
}