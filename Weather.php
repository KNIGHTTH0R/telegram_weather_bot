<?php

use GuzzleHttp\Client;
use Guzzle\Http\Exception\ClientException;
class Weather{

  protected $token = '49301bf5017ce6142ac02c8b6fedcaf8';

  public function getWeather($city_name){

    try{

      $url = 'http://api.openweathermap.org/data/2.5/weather?';

      $url .= 'q=' . $city_name . '&APPID=' . $this->token . '&lang=RU';

      $client = new Client(['base_uri' => $url]);

      $result = $client->request('GET');

      print_r(json_decode($result->getBody()));

      return json_decode($result->getBody());

    }

    catch(\Exception $e){

      return 404;

    }

  }

}

?>
