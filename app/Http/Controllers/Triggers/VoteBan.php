<?php

namespace App\Http\Controllers\Triggers;

use Illuminate\Support\Facades\Log;

class VoteBan extends TriggerController
{
    protected $triggers = ['/voteban'];

    protected function run()
    {

        $chat_id = '@campuserosclub';
        $ban_id = '115220712';
        $ban_name = 'Victor Hugo';

        $votes = \App\VoteBan::all()->count();

        if ($votes < 10) {
            $user_id = $this->message->getFrom()->getId();

            $vote = collect(\App\VoteBan::where('user_id', $user_id)->get());

            if ($vote->isEmpty()) {
                \App\VoteBan::firstOrCreate(['user_id' => $user_id]);

                $votes = \App\VoteBan::all()->count();

                $this->telegram->sendMessage([
                    'chat_id' => $this->chat->id,
                    'text' => (string) 'BAN ('.$ban_name.') : ' . $votes . '/10',
                ]);
            }
        }

        $votes = \App\VoteBan::all()->count();

        if ($votes == 10) {
            $this->telegram->kickChatMember([
                'chat_id' => $chat_id,
                'user_id' => $ban_id,
            ]);

            $this->telegram->sendMessage([
                'chat_id' => $this->chat->id,
                'text' => (string) $ban_name . ' foi banido com sucesso. Assim como o ban, vocês são 10/10 <3',
            ]);
        }
    }
}