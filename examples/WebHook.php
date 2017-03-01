<?php
/**
 * Telegram webhook bot Example.
 * @author Egor Egorov <github@erorrov.ru>
 */

//Include file (class)
require("telegram.php");

//Instances class
$tg = new Telegram("BOT_TOKEN");

//Get an array of an incoming update
$result = $tg->getData();
$text = $result['message']['text']; 
$chatID = $result['message']['chat']['id'];

//First command
if($text == "/start"){
  //Build buttons
  $btn1 = $tg->buildReplyButton(["text" => "Ping"]);
  $btn2 = $tg->buildReplyButton(["text" => "🌅"]);
  $btn3 = $tg->buildReplyButton(["text" => "Close keyboard"]);
  $btn4 = $tg->buildReplyButton(["text" => "Help"]);

  //Position of buttons on keyboard
  $buttons = [
    [$btn1, $btn2],
    [$btn4],
    [$btn3]
  ];

  //Build keyboard
  $rm = $tg->buildReplyKeyboard($buttons);

  //Send a message with keyboard (reply_markup)
  $params = ["chat_id" => $chatID, "text" => "Hey. What do you want?", "reply_markup" => $rm];
  $tg->sendRequest("sendMessage", $params);
}

//Send simple text messages
if($text == "Ping"){
  $params = ["chat_id" => $chatID, "text" => "Pong"];
  $tg->sendRequest("sendMessage", $params);
}

//Send image
if($text == "🌅"){
  //Load file (loadFile supports any file extension)
  $img = $tg->loadFile("test.png");
  //Sending a message with $img as photo
  $params = ["chat_id" => $chatID, "photo" => $img, "caption" => "This is a simple example how to send a picture"];
  $tg->sendRequest("sendPhoto", $params);
}

//Closing keyboard
if($text == "Close keyboard"){
  $rm = $tg->removeReplyKeyboard();
  $params = ["chat_id" => $chatID, "text" => "Send /start to see keyboard again", "reply_markup" => $rm];
  $tg->sendRequest("sendMessage", $params);
}

//Message with an inline keyboard
if($text == "Help"){
  //Build buttons (https://core.telegram.org/bots/api#inlinekeyboardbutton)
  $btn1 = $tg->buildInlineButton(["text" => "📄 View on GitHub", "url" => "https://github.com/erorrov/simple-telegram"]);
  $btn2 = $tg->buildInlineButton(["text" => "Author", "url" => "https://t.me/erorrov"]);

  //Position of buttons
  $buttons = [
    [$btn1],
    [$btn2]
  ];

  //Build keyboard
  $rm = $tg->buildInlineKeyboard($buttons);

  //Send a message with an inline keyboard (reply_markup)
  $params = ["chat_id" => $chatID, "text" => "This bot is created by simple-telegram class", "reply_markup" => $rm];
  $tg->sendRequest("sendMessage", $params);
}
?>
