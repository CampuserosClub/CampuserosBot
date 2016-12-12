<?php

namespace CampuserosBot\Unit\Telegram\Http\Controllers\Triggers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Regrasthegame extends Trigger
{
    protected $triggers = [
        '/thegame',
    ];

    protected function run()
    {
      $this->telegram->sendMessage([
          'chat_id' => $this->chat->getId(),
          'reply_to_message_id' => $this->message->getMessageId(),
          'text' => "Olá! Se você solicitou essas regras, provavelmente não está jogando, mas alguém está, portanto: The Game! E alguém perdeu!\n\n
          Há seis regras para jogar o O Jogo:\n
          1) Não é possível ganhar \"O Jogo\";\n
          2) Todos que sabem do Jogo, automaticamente começam a jogar;\n
          3) Sempre que alguém pensa no \"O Jogo\", este alguém perde;\n
          4) Cada vez que alguém perde \"O Jogo\", deve ser anunciado a perda usando uma frase como "eu perdi", "perdi O Jogo", ou meios alternativos;\n
          5) Deve ser respeitado o período de imunidade de no minimo 30 minutos depois de perder "O jogo", durante o qual um jogador pode se lembrar do "O jogo" sem perder novamente.\n
          6) O jogador em imunidade esta proibido de se expressar verbalmente sobre o fato de ter perdido "O jogo" até o fim de sua imunidade.\n
          Lembrando que a expressão \"O Jogo\" sempre se refere ao jogo e também \"The Game\".",
      ]);
    }
}
