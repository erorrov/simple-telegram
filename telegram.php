<?php
namespace tg;

class Telegram{

  private $token;
  private $data = array();
  private $ch;

  function __construct($token){
    $this->token = $token;
    $this->data = $this->getData();
  }

  public function getData(){
    return json_decode(file_get_contents("php://input"), true);
  }

  public function sendRequest($method, array $content){
    $ch = curl_init();
    $url = "https://api.telegram.org/bot".$this->token."/".$method;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    return json_decode($result);
  }

}
?>
