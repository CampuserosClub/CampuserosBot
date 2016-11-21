<?php

namespace App\Http\Controllers;

use Telegram\Bot\Api;

class WebhookController extends Controller
{
    /**
     * @var Api
     */
    protected $telegram;

    /**
     * @var \Telegram\Bot\Objects\Update
     */
    protected $update;

    /**
     * @var \Telegram\Bot\Objects\Message
     */
    protected $message;

    /**
     * @var \Telegram\Bot\Objects\Chat
     */
    protected $chat;

    /**
     * @var array
     */
    protected $triggers = [
        \App\Support\Triggers\Grito::class,
        \App\Support\Triggers\Pizza::class,
        \App\Support\Triggers\Treta::class,
        \App\Support\Triggers\Cafe::class,
        \App\Support\Triggers\Proximo::class,
        \App\Support\Triggers\Sexta::class,
        \App\Support\Triggers\Tonico::class,
        \App\Support\Triggers\Pombo::class,
        \App\Support\Triggers\LinkGrupoTelegram::class,
        \App\Support\Triggers\LinkGrupoFacebook::class,
    ];

    /**
     * WebhookController constructor.
     *
     * @param Api $telegram
     */
    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
        if (!is_null($this->telegram)) {
            $this->update = $this->telegram->getWebhookUpdates();

            if (!is_null($this->update)) {
                $this->message = $this->update->getMessage();

                if (!is_null($this->message)) {
                    $this->chat = $this->message->getChat();
                }
            }
        }
    }

    public function handle()
    {
        if (!is_null($this->chat)) {
            foreach ($this->triggers as $trigger) {
                new $trigger($this->telegram);
            }
        }
    }
}
