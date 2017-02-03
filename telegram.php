<?php
//namespace tg;

class Telegram{

  private $token;
  private $data = array();

  function __construct($token){
    $this->token = $token;
    $this->data = $this->getData();
  }

  public function getData(){
    return json_decode(file_get_contents("php://input"), true);
  }

  public function loadFile($path){
    return curl_file_create($path);
  }

  //¯\_(ツ)_/¯
  public function buildInlineButton(array $params){
    return $params;
  }

  //¯\_(ツ)_/¯
  public function buildReplyButton(array $params){
    return $params;
  }

  public function buildInlineKeyboard(array $buttons){
    return json_encode(array("inline_keyboard" => $buttons), true);
  }

  public function buildReplyKeyboard(array $buttons, array $params = array()){
    return json_encode(array("keyboard" => $buttons, $params), true);
  }

  public function buildForceReply(array $params = array()){
    return json_encode(array("force_reply" => true, $params), true);
  }

  public function removeReplyKeyboard(array $params = array()){
    return json_encode(array("remove_keyboard" => true, $params), true);
  }

  public function sendRequest($method, array $params){
    $ch = curl_init();
    $url = "https://api.telegram.org/bot".$this->token."/".$method;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    return json_decode($result, true);
  }

}
?>