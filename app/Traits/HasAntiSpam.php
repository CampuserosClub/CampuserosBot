<?php

namespace App\Traits;

use App\TelegramUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Telegram\Bot\Api;

trait HasAntiSpam
{
    protected $minutes_blocked = 30;

    protected function userCanUse(Api $telegram)
    {
        $message = $telegram->getWebhookUpdates()->getMessage();

        $this->cleanLog();

        $user_id = $message->getFrom()->getId();
        $message_timestamp = $message->getDate();
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

                $times_blocked = $user->times_blocked;

                $minutes_blocked = $this->minutes_blocked * $times_blocked;

                $blockedUntil = $user->last_message->copy()->addMinutes($minutes_blocked);
                $text = "PARABÉNS! Você foi bloqueado pela ".$times_blocked."ª vez.\nVou te ignorar até:". $blockedUntil->format('d/m/Y H:i:s');

                $telegram->sendMessage([
                    'chat_id' => $message->getChat()->getId(),
                    'text' => $text,
                    'reply_to_message_id' => $message->getMessageId(),
                ]);

                return false;
            }

            return true;
        } else {
            $now = \Carbon\Carbon::now();
            $times_blocked = $user->times_blocked;
            $minutes_blocked = $this->minutes_blocked * $times_blocked;
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
        $now = Carbon::now();
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
}