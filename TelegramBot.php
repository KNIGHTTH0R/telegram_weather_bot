<?php

use GuzzleHttp\Client;

class TelegramBot{

  protected $update_id;

  protected $token = '***token***';

  protected function query($method, $params = []){
    
    $url = 'https://api.telegram.org/bot' . $this->token . '/' . $method;

    if(!empty($params))

      $url .= '?' . http_build_query($params);

    $client = new Client(['base_uri' => $url]);

    $result = $client->request('GET');

    return json_decode($result->getBody());
  }

  public function sendMessage($chat_id, $text){

    $response = $this->query('sendMessage', ['chat_id' => $chat_id, 'text' => $text]);

    return $response->result;
  }

  public function getUpdates(){

    $response = $this->query('getUpdates', ['offset' => $this->update_id+1]);

    if(!empty($response->result))

      $this->update_id = $response->result[count($response->result)-1]->update_id;

    return $response->result;
  }

}

?>
