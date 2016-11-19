<?php

require 'vendor/autoload.php';
require 'vendor/rmccue/requests/library/Requests.php';
Requests::register_autoloader();

use Telegram\Bot\Api as Telegram;
use Telegram\Bot\Actions as TelegramAction;

/**
 * Class Api
 */
class Api
{
    protected $api = 'https://campuserosclub-api.herokuapp.com';
    public $response;

    /**
     * Api constructor.
     *
     * @param string $type
     * @param string $url
     * @param array $options
     * @param array $headers
     */
    public function __construct($type = 'get', $url = '', $options = [], $headers = ['Accept' => 'application/json'])
    {
        $request = Requests::{$type}($this->api.$url, $headers, $options);

        $this->response = $request->body;
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->response;
    }
}

/**
 * Class CampuserosBot
 */
class CampuserosBot
{
    /**
     * Telegram Token
     * @var string
     */
    protected $token = '246482286:AAEvSsv3Y9kJJUxbWR5YIkH8XLD_92hwby0';

    /**
     * @var Telegram
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
    protected $params = [];

    /**
     * @var array
     */
    protected $triggers = [
        'link do grupo' => 'https://telegram.me/CampuserosClub',
        'ooo' => [
            'OooOOOOOOOoooOoooooo',
            'ooooooOOOOOoooOOOOooooo',
            'oooooooOOOOOOOOoooooO',
            'OooOOOOOOOoooo',
            'OoooOoooOoOOO',
        ],
        'pizza' => [
            'Pizzaaaaaaaaaaaaaaaaaaaaaaaaaaaa!!!',
            'PIZZAAAAAAA!',
            'Pizzaaaaaaaaaaaaaaaaaaa!!',
        ],
        'biscoito' => 'É bolacha',
        'bolacha' => 'É biscoito',
        'cafe' => [
            'stickers' => [
                'BQADAQADigADc6QYA5uQxxPZmMZGAg',
                'BQADAQADYQADC1TfAAHnb5n94sar6AI',
                'BQADAgADgAADGgZFBBPEOyAbYERuAg',
                'BQADAQADVgEAAtpxZgdD4Q1UGK41qgI',
            ],
        ],
        'proximo' => [
            'stickers' => [
                'BQADAQADEAEAAm-8_wKeTmVwt36EGAI'
            ],
        ],
        'quanto tempo falta' => 'api',
    ];

    /**
     * CampuserosBot constructor.
     */
    public function __construct()
    {
        $this->telegram = new Telegram($this->token, true);

        $this->run();
    }

    protected function run()
    {
        $this->update = $this->telegram->getWebhookUpdates();

        if (!empty($this->update->all())) {
            $this->message = $this->update->getMessage();

            if (!is_null($this->message)) {
                $this->chat = $this->message->getChat();

                if (!is_null($this->chat)) {
                    $this->params = ['chat_id' => $this->chat->getId()];

                    $this->processMessage();
                }
            }
        }
    }

    protected function processMessage()
    {
        $text = $this->message->getText();

        foreach ($this->triggers as $key => $value) {
            if (stripos($text, $key) !== FALSE) {
                if (is_array($value) AND key($value) === 'stickers') {
                    $this->sendSticker($this->rand($value['stickers']));
                } else {
                    if ($value === 'api') {
                        $this->sendMessage(self::callTimeTo(explode(strtoupper($key), strtoupper($text))[1]));
                    } else {
                        $this->params['disable_web_page_preview'] = true;
                        $this->sendMessage((is_array($value)) ? $this->rand($value) : $value);
                    }
                }
            }
        }
    }

    protected function callTimeTo($slug)
    {
      $slug = trim($slug);
      if($slug == NULL){
        return "Por favor, informe qual é a edição que desejas... Ex: quanto tempo falta CPBR, quanto tempo falta CPAR";
      }else{
        $content = file_get_contents("http://campuserosclub-api.herokuapp.com/editions/".$slug);
        $json = json_decode($content);
        if(!property_exists($json, "message")){
          if(is_object($json->countdown)){
            $return = "Para a #".strtoupper($json->slug).$json->number." falta ";

            if($json->countdown->left->days == 1){
              $return .= $json->countdown->left->days." dia ";
            }elseif($json->countdown->left->days > 0){
              $return .= $json->countdown->left->days." dias ";
            }

            if($json->countdown->left->hours == 1){
              $return .= $json->countdown->left->hours." hora ";
            }elseif($json->countdown->left->hours > 0){
              $return .= $json->countdown->left->hours." hora(s) ";
            }

            if($json->countdown->left->minutes == 1){
              $return .= $json->countdown->left->minutes." minuto ";
            }elseif($json->countdown->left->minutes > 0){
              $return .= $json->countdown->left->minutes." minuto(s) ";
            }

            $return .= $json->countdown->left->seconds." segundo(s)!";
            return $return;

          }elseif(is_bool($json->countdown)){
            return "Opaaaa! A #".strtoupper($json->slug).$json->number." já ocorreu, e não tem uma próxima edição agendada... :/";
          }else{
            return $json->countdown;
          }
        }else{
          return "Erro! Cara, não existe uma edição com esse slug! ".$slug;
        }
      }
    }

    protected function sendMessage($text)
    {
        $this->actionTyping();
        $this->params['text'] = $text;

        $this->telegram->sendMessage($this->params);
    }

    protected function sendSticker($sticker)
    {
        $this->actionTyping();
        $this->params['sticker'] = $sticker;
        $this->telegram->sendSticker($this->params);
    }

    protected function actionTyping()
    {
        $this->params['action'] = TelegramAction::TYPING;
        $this->telegram->sendChatAction($this->params);
    }

    protected function rand(array $array)
    {
        $keys = array_keys($array);
        shuffle($keys);
        $random = array_rand($keys);
        return $array[$random];
    }
}

new CampuserosBot();
