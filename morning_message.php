<?php

require_once 'vendor/autoload.php';
require_once 'Weather.php';
require_once 'TelegramBot.php';

$bot = new TelegramBot();

$weather = new Weather();
// $i = true;
while(true){
  if(date('H:i') == '08:00'){

    echo 'Morning message ';

    $freshData = $weather->getWeather('Moscow');

    $description = [];

    foreach ($freshData->weather as $weather_data_array) {

      $description[] = $weather_data_array->description;

    }

    $msg = "Сейчас в городе $freshData->name:";

    foreach ($description as $key => $value) {

      if($key==0) $msg .= ' ' . $value;

      else $msg .= ', ' . $value;
    }

    $msg .= ".\nТемпература составляет " . round($freshData->main->temp - 273, 0, PHP_ROUND_HALF_UP) . " ℃.\nНе простуди жопу!";

    $bot->sendMessage('-250143773', $msg);


    sleep(60);
  }
}
 ?>
