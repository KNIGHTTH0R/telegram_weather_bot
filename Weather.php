<?php

use GuzzleHttp\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;
class Weather{

  protected $token = '49301bf5017ce6142ac02c8b6fedcaf8'; //Киев
  // http://api.openweathermap.org/data/2.5/forecast/daily?id=524901&lang={lang}

  public function getWeather($city_name){

    $url = 'http://api.openweathermap.org/data/2.5/weather?';

    $url .= 'q=' . $city_name . '&APPID=' . $this->token . '&lang=RU';

    try{

      $client = new Client(['base_uri' => $url]);

      $result = $client->request('GET');
      print_r($result);
      // print_r(json_decode($result->getBody()));
      // if(!$result) throw new Exception('Не могу найти такой город.');
      return json_decode($result->getBody());
    }
    catch(ClientErrorResponseException $exception){
      return 'Не могу найти такой город.';
    }

  }

}

?>
