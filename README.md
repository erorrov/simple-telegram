# simple-telegram
A simple PHP class for telegram bot API. Useful for learning.

**This class are currently under development<br/>
The README.md was updated Feb 27 2017**

Requirements
------------
* PHP 5 with cURL

Usage
------------
Copy telegram.php into your server and include it in your script.

```php
require("telegram.php");
$tg = new Telegram("BOT_TOKEN");
```


######Getting an array of the current message
```php
$result = $tg->getData();
$chat_id = $result['message']['chat']['id'];
$text = $result['message']['text'];
```


######Sending requests to API as an example of the method sendLocation
All available methods you can see [here](https://core.telegram.org/bots/api#available-methods).
```php
$params = ["chat_id" => $chat_id, "latitude" => "55.7539303", "longitude" => "37.620795"];
$tg->sendRequest("sendLocation", $params);
```


######Sending files
```php
$file = $tg->loadFile("test.jpg");
$params = ["chat_id" => $chat_id, "photo" => $file];
$tg->sendRequest("sendPhoto", $params);
```


######Sending messages with keyboard
```php
$btn1 = ["text" => "Button"];
$btn2 = ["text" => "Again button"];
$btn3 = ["text" => "Wow such button"];

$buttons = [
  [$btn1, $btn2],
  [$btn3]
];
  
$keyboard = $tg->buildReplyKeyboard($buttons); //supports a second parameter with array

$params = ["chat_id" => $chat_id, "text" => "Hello, it's me", "reply_markup" => $keyboard];
$tg->sendRequest("sendMessage", $params);
```


######Removing keyboard
```php
$rmkb = $tg->removeReplyKeyboard();

$params = ["chat_id" => $chat_id, "text" => "I was wondering if after all these years", "reply_markup" => $rmkb];
$tg->sendRequest("sendMessage", $params);
```


######Sending messages with inline-keyboard
```php
$btn1 = ["text" => "Button", "switch_inline_query" => "hello world"];
$btn2 = ["text" => "Again button", "switch_inline_query_current_chat" => "qwerty"];
$btn3 = ["text" => "Wow such button", "url" => "https://github.com/erorrov/simple-telegram"];

$buttons = [
  [$btn1, $btn2],
  [$btn3]
];
  
$keyboard = $tg->buildInlineKeyboard($buttons); //supports a second parameter with array

$params = ["chat_id" => $chat_id, "text" => "You'd like to meet", "reply_markup" => $keyboard];
$tg->sendRequest("sendMessage", $params);
```


######Enable debug mode
```php
$tg->debug(CHAT_ID);
```


######Disable debug mode
```php
$tg->debug();
```


######Response to inline query
```php
$lines = [
  ["type" => "contact", "id" => "1", "phone_number" => "+78005553535", "first_name" => "Tim", "last_name" => "Cook"],
  ["type" => "location", "id" => "2", "latitude" => 55.7539303, "longitude" => 37.620795, "title" => "Kremlin and Red Square, Moscow"],
  ["type" => "location", "id" => "3", "latitude" => 37.402473, "longitude" => -122.3212843, "title" => "Silicon Valley"]
];

$inline = $tg->buildInlineQueryResult($lines);
$params = ["inline_query_id" => $result['inline_query']['id'], "results" => $inline];
$res = $tg->sendRequest("answerInlineQuery", $params);
```

Contacts
------------
You can contact me [via Telegram](https://t.me/erorrov) but if you have an issue please [open](https://github.com/erorrov/simple-telegram/issues) one.
