<?php

namespace CampuserosBot\Unit\Telegram\Http\Controllers\Triggers;

use CampuserosBot\Core\Unit\Http\TelegramController;
use Telegram\Bot\Api;

abstract class Trigger extends TelegramController
{
    /**
     * @var array
     */
    protected $triggers = [];
    protected $responses = [];
    protected $stickers = [];
    protected $gifs = [];
    /**
     * All of responses.
     * [type, return]
     * Type codes:
     * 0 - text
     * 1 - sticker
     * 2 - gif
     *
     * @var array
     */
    protected $returns = [];
    /**
     * Trigger constructor.
     *
     * @param Api $telegram
     */
    public function __construct(Api $telegram)
    {
        parent::__construct($telegram);

        if ($this->hasTrigger()) {
            $this->handle();
        }
    }

    /**
     * Check if the message has a trigger.
     *
     * @return bool
     */
    protected function hasTrigger()
    {
        if (!is_null($message = $this->message->getText())) {
            return $this->checkText($message, $this->triggers);
        }

        return false;
    }

    /**
     * @param $text
     * @param $check
     *
     * @return bool
     */
    protected function checkText($text, $check)
    {
        return (str_contains(strtolower($text), $check));
    }

    protected function handle()
    {
        $return = collect($this->returns)->random();
        switch ($return["type"]) {
          case 0:
            # Text
            $this->handleResponse($return["return"]);
            break;
          case 1:
            # Sticker
            $this->handleSticker($return["return"]);
            break;
          default:
            # If is not 0 and 1: is 2 - GIF
            $this->handleGif($return["return"]);
            break;
        }
        $this->run();
    }

    protected function handleResponses()
    {
        $responses = collect($this->responses);
        if (!$responses->isEmpty()) {
            $this->telegram->sendMessage([
                'chat_id' => $this->chat->getId(),
                'text' => $responses->random(),
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


  /**
   * Returns for after the refactor did in 18/12/2016
   *
   */
    protected function handleResponse($response)
    {
        $this->telegram->sendMessage([
            'chat_id' => $this->chat->getId(),
            'text' => $response,
        ]);
    }

    protected function handleSticker($response)
    {
        $this->telegram->sendSticker([
            'chat_id' => $this->chat->getId(),
            'sticker' => $response,
        ]);
    }

    protected function handleGif($response)
    {
        $this->telegram->sendDocument([
            'chat_id' => $this->chat->getId(),
            'document' => $response,
        ]);
    }

    /**
     * Action to take if there is a trigger.
     *
     * @return mixed
     */
    protected function run() {
        // NOTHING
        return null;
    }
}
