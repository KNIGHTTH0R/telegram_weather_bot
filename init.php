<?php

require_once 'vendor/autoload.php';
require_once 'TelegramBot.php';
require_once 'Weather.php';

$bot = new TelegramBot();
// print_r($updates);
$weather = new Weather();

// while(true){
//
//   $fresh_data_weather = $weather->getWeather();
//
//   print_r($fresh_data_weather);
//
//   sleep(1800);
//
// }
//
//
//
// while(true){
//
//   sleep(3);
//
//   $updates = $bot->getUpdates();
//
//   foreach($updates as $update){
//
//     $bot->sendMessage($update->message->chat->id, 'Привет!');
//     // print_r($update);
//     // $bot->sendMessage($update->message->chat_id, $weather->getWeather()->main->temp);
//
//   }
//
// }

while(true){

  sleep(3);
  $updates = $bot->getUpdates();
  if(!empty($updates)){

    foreach ($updates as $update) {

      try{
        $freshData = getFreshWeatherData($weather, $update->message->text);
        $description = [];
        foreach ($freshData->weather as $weather_data_array) {
          $description[] = $weather_data_array->description;
        }
        $msg = "Сейчас в городе $freshData->name:";
        foreach ($description as $key => $value) {
          if($key==0) $msg .= ' ' . $value;
          else $msg .= ', ' . $value;
        }
        $msg .= '. Температура составляет ' . round($freshData->main->temp - 273, 0, PHP_ROUND_HALF_UP) . " градусов Цельсия.\nХорошего дня!";
        $bot->sendMessage($update->message->chat->id, $msg);
      }
      catch(Exception $e){
        $msg = $e->getMessage();
        $bot->sendMessage($update->message->chat->id, $msg);
      }


    }

  }

}

function getFreshWeatherData($weather, $city_name){
  $fresh_data_weather = $weather->getWeather($city_name);
  // if(!$fresh_data_weather) throw new Exception('Не могу найти такой город.');
  return $fresh_data_weather;
}

?>
