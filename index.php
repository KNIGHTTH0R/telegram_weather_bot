<?php
require_once 'vendor/autoload.php';
require_once 'TelegramBot.php';
require_once 'Weather.php';

$bot = new TelegramBot();

$weather = new Weather();

while(true){

  $time_begin = time();

  sleep(1);

  $updates = $bot->getUpdates();

  if($updates == 0) echo 'No connection ';

  else{

    if(!empty($updates)){

      foreach ($updates as $update) {

        $freshData = $weather->getWeather($update->message->text);

        if(is_int($freshData) && $freshData == 404){

          $msg = 'Похоже на то, что такого города не существует, либо я не способен его найти. Попробуйте изменить свой запрос. Например ввести название крупного города рядом с вами.';

        }

        else{

          $description = [];

          foreach ($freshData->weather as $weather_data_array) {

            $description[] = $weather_data_array->description;

          }

          $msg = "Сейчас в городе $freshData->name:";

          foreach ($description as $key => $value) {

            if($key==0) $msg .= ' ' . $value;

            else $msg .= ', ' . $value;
          }

          $msg .= ".\nТемпература составляет " . round($freshData->main->temp - 273, 0, PHP_ROUND_HALF_UP) . " ℃.\nХорошего дня!";

          while(is_int($status = $bot->sendMessage($update->message->chat->id, $msg)) && $status == 0){

            echo 'No connection ';
            
            sleep(3);

          }

        }

      }

    }

  }

  echo (time() - $time_begin) . ' ';

}

?>
