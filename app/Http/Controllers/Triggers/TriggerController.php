<?php

namespace App\Http\Controllers\Triggers;

use App\Http\Controllers\TelegramController;
use App\TelegramUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
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
            if ($this->userCanUse()) {
                $this->handle();
            }
        }
    }

    protected function userCanUse()
    {
        $minutes_blocked = 30;
        $this->cleanLog();

        $user_id = $this->message->getFrom()->getId();
        $message_timestamp = $this->message->getDate();
        $message_date = Carbon::createFromTimestamp($message_timestamp);

        $user = TelegramUser::firstOrCreate(['user_id' => $user_id]);

        if (!$user->blocked) {
            $user->last_message = $message_date;
            $user->messages++;
            $user->save();


            if ($user->messages >= 5) {
                $user->blocked = true;
                $user->times_blocked++;

                $user->save();

                $blockedUntil = $user->last_message->copy()->addMinutes($minutes_blocked);
                $text = "PARABÉNS! Você foi bloqueado.\nVou te ignorar até:". $blockedUntil->format('d/m/Y H:i:s');

                $this->telegram->sendMessage([
                    'chat_id' => $this->chat->getId(),
                    'text' => $text,
                    'reply_to_message_id' => $this->message->getMessageId(),
                ]);

                return false;
            }

            return true;
        } else {
            $now = \Carbon\Carbon::now();
            $blockedUntil = $user->last_message->copy()->addMinutes($minutes_blocked);
            $diff = $now->diffInSeconds($blockedUntil, false);

            if ($diff < 0) {
                $user->blocked = false;
                $user->save();
            }
        }

        return false;
    }

    protected function cleanLog()
    {
        $now = \Carbon\Carbon::now();
        $last_clean = Cache::remember('last_clean', 1, function () use ($now) {
            return $now;
        });


        $diff = $now->diffInSeconds($last_clean);

        if ($diff == 0) {
            foreach (TelegramUser::all() as $user) {
                $user->messages = 0;
                $user->save();
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