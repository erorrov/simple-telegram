<?php
/**
 * Telegram webhook bot Example.
 * @author Egor Egorov <github@erorrov.ru>
 */

//Load class
require("telegram.php");

//Instances class
$bot_token = "BOT_TOKEN";
$tg = new Telegram($bot_token);

//Get an array of current message
$result = $tg->getData();
$text = $result['message']['text'];
$chatID = $result['message']['chat']['id'];

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

  //Send a message
  $params = ["chat_id" => $chatID, "text" => "Hey. What do you want?", "reply_markup" => $rm];
  $tg->sendRequest("sendMessage", $params);
}

if($text == "Ping"){
  //Send simple text messages
  $params = ["chat_id" => $chatID, "text" => "Pong"];
  $tg->sendRequest("sendMessage", $params);
}

if($text == "🌅"){
  //Load gile at $img
  $img = $tg->loadFile("test.png");
  //Sending a message with $img as photo
  $params = ["chat_id" => $chatID, "photo" => $img, "caption" => "This is a simple example how to send a picture"];
  $tg->sendRequest("sendPhoto", $params);
}

if($text == "Close keyboard"){
  $rm = $tg->removeReplyKeyboard();
  $params = ["chat_id" => $chatID, "text" => "Send /start to see keyboard again", "reply_markup" => $rm];
  $tg->sendRequest("sendMessage", $params);
}

if($text == "Help"){
  //By analogy with that in line 20
  $btn1 = $tg->buildInlineButton(["text" => "📄 View on GitHub", "url" => "https://github.com/erorrov/simple-telegram"]);
  $btn2 = $tg->buildInlineButton(["text" => "Author", "url" => "https://t.me/erorrov"]);

  $buttons = [
    [$btn1],
    [$btn2]
  ];

  $rm = $tg->buildInlineKeyboard($buttons);

  $params = ["chat_id" => $chatID, "text" => "This bot is created by simple-telegram class", "reply_markup" => $rm];
  $tg->sendRequest("sendMessage", $params);
}
?>
