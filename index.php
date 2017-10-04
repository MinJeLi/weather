<?php

function Weather($p){

	$text = "";
	$user_name = "";

	if (isset($p["text"])) {
			$text = strval($p["text"]);
	}
	
	if (isset($p["token"])) {
			$token = strval($p["token"]);
	}
	
	if ($token != "l3SS4ioOoets"){
		exit("~想亂來？~");
	}
	
	if (isset($p["username"])) {
			$user_name = strval($p["username"]);
	}
	
	$LocateName = explode(" ", $text,2);
	$total = "";
	
	foreach($LocateName as $value){
		
		$id = trim($value);
		
		if($id == "天氣預報" or $id == "weather"){
			continue;
		}
		
		if (is_string($id) and !empty($id)) {
			
			$PostURL = "http://api.openweathermap.org/data/2.5/forecast?q=".$id."&type=like&units=metric&APPID=991dc5ce2495a8a1349c57c8aa05c56d";
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, $PostURL);
			$result = curl_exec($ch);
			curl_close($ch);

			$obj = json_decode($result);
			$Link = $obj->city->name ."  未來天氣\n";
			
			
			for ( $i=0 ; $i<=32 ; $i=$i+8 ) {
				$WeatherDay = date('Y-m-d H:i:s', $obj->list[$i]->dt);
				$Link = $Link.$WeatherDay."  ";
				$Link = $Link."氣溫：".$obj->list[$i]->main->temp."  ";
				$Link = $Link."天氣：".$obj->list[$i]->weather[0]->main."\n";
			}
			
			$total = $total.$Link;
		}else{
			$xxx = "~別惡搞了~";
			$total = $total.$xxx;
//			$total = $total."ID 要'#'+'數字'哦 (◕ܫ◕)\n";
		}
		
	}
	echo "{\"text\": \"" . $total . "\"}";
	
}

Weather($_POST) 

?>