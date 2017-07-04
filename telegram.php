<?php
/**
 * A simple PHP class for telegram bot API.
 * @author Egor Egorov <egor@erorrov.ru>
 * @license https://raw.githubusercontent.com/erorrov/simple-telegram/master/LICENSE
 */

//namespace tg;

class Telegram{

  /**
  * Set bot token
  * @var string
  */
  private $token;

  /**
  * Stores data of a message (WebHook)
  * @var string
  */
  private $data = array();

  /**
  * Debug mode switch
  * @var boolean
  */
  private $debug = false;

  /**
  * Constructor
  * @param string $token
  */
  function __construct($token){
    $this->token = $token;
    $this->data = $this->getData();
  }

  /**
  * Get an array of current message
  * @return array
  */
  public function getData(){
    return json_decode(file_get_contents("php://input"), true);
  }

  /**
  * Just curl_file_create()
  * @return resource
  */
  public function loadFile($path){
    return curl_file_create($path);
  }

  /**
  * Make an inline button. In fact, useless function but may be useful for beginners to grasp.
  * @return array
  */
  public function buildInlineButton(array $params){
    return $params;
  }

  /**
  * Make a button. In fact, useless function but may be useful for beginners to grasp.
  * @return array
  */
  public function buildReplyButton(array $params){
    return $params;
  }

  /**
  * Make an inline keyboard
  * @return array
  */
  public function buildInlineKeyboard(array $buttons){
    return json_encode(array("inline_keyboard" => $buttons), true);
  }

  /**
  * Make a reply keyboard
  * @return array
  */
  public function buildReplyKeyboard(array $buttons, array $params = array()){
    return json_encode(array("keyboard" => $buttons, $params), true);
  }

  /**
  * Make ForceReply
  * @return array
  */
  public function buildForceReply(array $params = array()){
    return json_encode(array("force_reply" => true, $params), true);
  }

  /**
  * To remove a reply keyboard
  * @return array
  */
  public function removeReplyKeyboard(array $params = array()){
    return json_encode(array("remove_keyboard" => true, $params), true);
  }

  /**
  * Make inline line. In fact, useless function but may be useful for beginners to grasp.
  * @return array
  */
  public function buildInlineLine(array $params){
    return $params;
  }

  /**
  * To build inline query result
  * @return array
  */
  public function buildInlineQueryResult(array $params){
    return json_encode($params);
  }

  /**
  * Debug mode
  */
  public function debug($chat_id = 0) {
    $this->debug = ($chat_id == 0 ? false : $chat_id);
  }

  /**
  * Make api request
  * @return array
  */
  public function sendRequest($method, array $params = array(), $debug = false){
    $ch = curl_init();
    $url = "https://api.telegram.org/bot".$this->token."/".$method;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);

    if(!$debug && $this->debug){
      $debugparams = array(
        "chat_id" => $this->debug,
        "text" => "<b>[Debug info]</b>\n<b>Parameters:</b>\n<pre>".print_r($params, true)."</pre>\n<b>Result:</b>\n<pre>".print_r(json_decode($result), true)."</pre>",
        "parse_mode" => "HTML"
      );

      $this->sendRequest("sendMessage", $debugparams, true);
    }

    return json_decode($result, true);
  }

}
?>