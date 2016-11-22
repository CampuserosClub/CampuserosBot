<?php

namespace CampuserosBot\Unit\Telegram\Http\Controllers\Triggers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Countdown extends Trigger
{
    protected $triggers = [
        '/quantotempofalta',
        'eu quero saber quanto tempo falta para a #',
    ];

    protected function run()
    {
        $responses = collect($this->triggers);
        $text = $this->message->getText();

        if ($this->checkText($text, $responses->first())) {
            $this->showKeyboard();
        } elseif ($this->checkText($text, $responses->last())) {
            $slug = $this->identifySlug($text);
            $this->sendTimeLeft($slug);
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function getEditions()
    {
        $url = 'https://campuserosclub-api.herokuapp.com/editions';
        $client = new Client();
        $response = $client->get($url);
        $contents = $response->getBody()->getContents();

        return collect(json_decode($contents));
    }

    /**
     * @param string $slug
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getEdition($slug)
    {
        $url = 'https://campuserosclub-api.herokuapp.com/editions/'.$slug;
        $client = new Client();

        try {
            $response = $client->get($url);
            $contents = $response->getBody()->getContents();

            return collect(json_decode($contents));
        } catch (ClientException $e) {
            return null;
        }
    }

    protected function showKeyboard()
    {
        $alias = collect($this->triggers)->last();

        $items = collect([]);

        foreach ($this->getEditions() as $edition) {
            $items = $items->merge($alias.$edition->slug.$edition->number);
        }

        $keyboard = [
            $items->toArray(),
        ];

        $reply_markup = $this->telegram->replyKeyboardMarkup([
            'selective' => true,
            'one_time_keyboard' => true,
            'resize_keyboard' => true,
            'keyboard' => $keyboard,
        ]);

        $this->telegram->sendMessage([
            'chat_id' => $this->chat->getId(),
            'reply_to_message_id' => $this->message->getMessageId(),
            'text' => 'Para qual edição?',
            'reply_markup' => $reply_markup,
        ]);
    }

    /**
     * @param string $text
     *
     * @return string
     */
    protected function identifySlug($text)
    {
        return preg_replace('/\d+/', '', collect(explode('#', $text))->last());
    }

    /**
     * @param $slug
     */
    protected function sendTimeLeft($slug)
    {
        $edition = $this->getEdition($slug);

        if (!is_null($edition)) {
            $countdown = collect($edition->toArray()['countdown']);

            if (!$countdown->first()) {
                $text = 'Já passou :P';
            } else {
                $left = $countdown->toArray()['left'];

                $text = "Faltam";
                $text .= "\n";
                $text .= "{$left->days} dias";
                $text .= "\n";
                $text .= "{$left->hours} horas";
                $text .= "\n";
                $text .= "{$left->minutes} minutos";
                $text .= "\n";
                $text .= "{$left->seconds} segundos";
            }

            $reply_markup = json_encode([
                'remove_keyboard' => true,
            ]);

            $this->telegram->sendMessage([
                'chat_id' => $this->chat->getId(),
                'reply_to_message_id' => $this->message->getMessageId(),
                'text' => $text,
                'reply_markup' => $reply_markup,
            ]);
        }
    }
}