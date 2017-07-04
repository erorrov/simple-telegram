<?php
/**
 * Telegram webhook bot Example.
 * @author Egor Egorov <egor@erorrov.ru>
 */

//Include class with all necessary stuff
require("../telegram.php");

//Instances class
$tg = new Telegram("BOT_TOKEN");


$lastupdid = 1;
while(true){
	$upd = $tg->sendRequest("getUpdates", ["offset" => $lastupdid]);

	if(isset($upd['result'][0])){
		$text = $upd['result'][0]['message']['text'];
		$chat_id = $upd['result'][0]['message']['chat']['id'];


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
		  $params = ["chat_id" => $chat_id, "text" => "Hey. What do you want?", "reply_markup" => $rm];
		  $tg->sendRequest("sendMessage", $params);
		}

		//Send simple text messages
		if($text == "Ping"){
		  $params = ["chat_id" => $chat_id, "text" => "Pong"];
		  $tg->sendRequest("sendMessage", $params);
		}

		//Send image
		if($text == "🌅"){
		  //Load file (loadFile supports any file extension)
		  $img = $tg->loadFile("test.png");
		  //Sending a message with $img as photo
		  $params = ["chat_id" => $chat_id, "photo" => $img, "caption" => "This is a simple example how to send a picture"];
		  $tg->sendRequest("sendPhoto", $params);
		}

		//Closing keyboard
		if($text == "Close keyboard"){
		  $rm = $tg->removeReplyKeyboard();
		  $params = ["chat_id" => $chat_id, "text" => "Send /start to see keyboard again", "reply_markup" => $rm];
		  $tg->sendRequest("sendMessage", $params);
		}

		if($text == "Help"){
		  $params = ["chat_id" => $chat_id, "text" => "This bot is created by simple-telegram class"];
		  $tg->sendRequest("sendMessage", $params);
		}


		$lastupdid = $upd['result'][0]['update_id'] + 1;
	}	
}