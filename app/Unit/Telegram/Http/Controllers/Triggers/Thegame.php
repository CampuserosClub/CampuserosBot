<?php

namespace CampuserosBot\Unit\Telegram\Http\Controllers\Triggers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Thegame extends Trigger
{
    protected $triggers = [
        'o jogo',
        'the game',
    ];

    protected function run()
    {
      $this->telegram->sendMessage([
          'chat_id' => $this->chat->getId(),
          'reply_to_message_id' => $this->message->getMessageId(),
          'text' => "Você perdeu! #TheGame",
      ]);
    }
}
