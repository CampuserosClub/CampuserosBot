<?php

namespace App\Http\Controllers\Triggers;

use App\Telegram\Api;
use App\Traits\HasAntiSpam;
use App\Http\Controllers\TelegramController;
use App\Traits\TelegramHelpers;

abstract class TriggerController extends TelegramController
{
    use HasAntiSpam, TelegramHelpers;

    protected $triggers = [];
    protected $texts = [];
    protected $stickers = [];
    protected $gifs = [];
    protected $voices = [];

    public function __construct(Api $telegram)
    {
        parent::__construct($telegram);

        if ($this->hasTrigger()) {
            if ($this->userCanUse($telegram)) {
                $this->handle();
            }
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
        $this->handleVoices();
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
        $from = env('APP_ENV') == 'production' ? 'production' : 'local';
        $gifs = collect(array_get($this->gifs, $from));

        if (!$gifs->isEmpty()) {
            $this->telegram->sendDocument([
                'chat_id' => $this->chat->getId(),
                'document' => $gifs->random(),
            ]);
        }
    }

    protected function handleVoices()
    {
        $voices = collect($this->voices);

        if (!$voices->isEmpty()) {
            $resource = 'assets/telegram/' . $voices->random();
            $voice = resource_path($resource);

            $this->telegram->sendVoice([
                'chat_id' => $this->chat->getId(),
                'voice' => $voice,
            ]);
        }
    }

    protected function run() {
        return null;
    }
}
