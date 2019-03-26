<?php

use GuzzleHttp\Client;
use Guzzle\Http\Exception\ClientException;
class TelegramBot{

  protected $update_id;

  protected $token = '819783012:AAGEhpb5MSEqOBTYWr7tt7_F7cJ_ZKbJ_Qc';

  protected function query($method, $params = []){

    try{

      $url = 'https://api.telegram.org/bot';

      $url .= $this->token . '/' . $method;

      if(!empty($params)){

        $url .= '?' . http_build_query($params);

      }

      $client = new Client(['base_uri' => $url]);

      $result = $client->request('GET');

      return json_decode($result->getBody());

    }

    catch(\Exception $e){

      return 0;

    }

  }

  public function sendMessage($chat_id, $text){

    $response = $this->query('sendMessage', ['chat_id' => $chat_id, 'text' => $text]);

    if(is_int($response) && $response == 0)

      return 0;

    else

    return $response->result;

  }

  public function getUpdates(){

    $response = $this->query('getUpdates', ['offset' => $this->update_id+1]);

    if(!empty($response->result)){

      $this->update_id = $response->result[count($response->result)-1]->update_id;

      print_r($response->result);

    }

    if(is_int($response) && $response == 0)

      return 0;

    else

    return $response->result;

  }

}

?>
