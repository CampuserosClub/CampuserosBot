<?php

require 'vendor/autoload.php';

use Telegram\Bot\Api as Telegram;

$token = "264465611:AAGWW5A0idShoji3KmK_pt1APAYo3560xoI";
$telegram = new Telegram($token);

$update = $telegram->getWebhookUpdates();
$message = $update->getMessage();
$chat = $message->getChat();

$params = ['chat_id' => $chat->getId()];

$params['text'] = $message->getText();

$telegram->sendMessage($params);