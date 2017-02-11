<?php
require("telegram.php");

$bot_token = "BOT_TOKEN";
$tg = new Telegram($bot_token);

$result = $tg->getData();
$text = $result['message']['text'];
$chatID = $result['message']['chat']['id'];

if($text == "/start"){
  $btn1 = $tg->buildReplyButton(["text" => "Ping"]);
  $btn2 = $tg->buildReplyButton(["text" => "🌅"]);
  $btn3 = $tg->buildReplyButton(["text" => "Close keyboard"]);
  $btn4 = $tg->buildReplyButton(["text" => "Help"]);

  $buttons = [
    [$btn1, $btn2],
    [$btn4],
    [$btn3]
  ];

  $rm = $tg->buildReplyKeyboard($buttons);

  $params = ["chat_id" => $chatID, "text" => "Hey. What do you want?", "reply_markup" => $rm];
  $tg->sendRequest("sendMessage", $params);
}

if($text == "Ping"){
  $params = ["chat_id" => $chatID, "text" => "Pong"];
  $tg->sendRequest("sendMessage", $params);
}

if($text == "🌅"){
  $img = $tg->loadFile("test.png");
  $params = ["chat_id" => $chatID, "photo" => $img, "caption" => "This is a simple example how to send a picture"];
  $tg->sendRequest("sendPhoto", $params);
}

if($text == "Close keyboard"){
  $rm = $tg->removeReplyKeyboard();
  $params = ["chat_id" => $chatID, "text" => "Send /start to see keyboard again", "reply_markup" => $rm];
  $tg->sendRequest("sendMessage", $params);
}

if($text == "Help"){
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
