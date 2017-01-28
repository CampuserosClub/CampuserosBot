<?php

namespace App\Telegram;

use Telegram\Bot\Api as TelegramApi;
use Telegram\Bot\Objects\Update;

class Api extends TelegramApi
{
    /**
     * Kick a user from a group or a supergroup.
     *
     * @link https://core.telegram.org/bots/api#kickchatmember
     *
     * @param array $params
     *
     * @var int|string $params ['chat_id']
     * @var int $params ['user_id']
     *
     * @return \Telegram\Bot\TelegramResponse
     */
    public function kickChatMember(array $params)
    {
        return $this->post('kickChatMember', $params);
    }

    /**
     * @param array $keyboard
     * @return string
     */
    public function inlineKeyboardMarkup(array $keyboard)
    {
        return json_encode(['inline_keyboard' => [$keyboard]]);
    }

    public function callback(Update $update)
    {
        $response = collect($update->getRawResponse());

        $response = $response->get('callback_query', null);

        $callback = is_null($response) ? null : json_decode(collect($response)->toJson());

        return $callback;
    }
}