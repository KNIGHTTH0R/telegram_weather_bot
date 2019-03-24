<?php

require_once '../telegram_api/vendor/autoload.php';
require_once 'TelegramBot.php';

$bot = new TelegramBot();

while(true){

  sleep(3);

  $updates = $bot->getUpdates();

  foreach ($updates as $update) {

    $bot->sendMessage($update->message->chat->id, 'Hello');

  }

}

?>
