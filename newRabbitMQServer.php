#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
include 'functions.php';

//defined in functions.php:
//doLogin (checks user input vs. server data. returns true/false)
//returnSteamUser
//returnFriendlist
//doAccountCreate
//doCollectSteamUser
//doCompareSteamData


function requestProcessor($request){
	echo "received request".PHP_EOL;
	var_dump($request);

	if(!isset($request['type'])){
		return "ERROR: unsupported message type";
	}

	switch ($request['type']){
		case "login":
			return true;//
		case "register":
			return true; //
		case "steam_user":
			return true; //
		case "steam_friendlist":
			return true; //
/*

		case "validate_session":
			//return;
*/
	}

	return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("newRabbitMQ.ini","newServer");

$server->process_requests('requestProcessor');
exit();

?>
