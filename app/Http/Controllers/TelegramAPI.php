<?php

namespace App\Http\Controllers;

use Telegram\Bot\Api;

class TelegramAPI extends Api
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
}