#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function doLogin($username,$password)
{
	//lookup username in database
	//check password
	return true;
	//return false if not valid
}

function returnSteamUser(){
	return true;
	//lookup steamID in database
	//return array containing steam user informaton (avatar, etc.)
}

function returnFriendlist(){
	return true;
	//lookup steamID in database
	//return friendlist data containing returnSteamUser() data	
}

function doAccountCreate(){
        return true;
	//if: account/steamID already exists, return error.
	//else: input data into database
}

function doCollectSteamUser(){
        return true;
        //if: not in database (through friend), scrape Steam and add.
        //else: find in database.
	//returnSteamID()?
}

function doCompareSteamData(){
	return true;
	//??
	//Finds users most similar to user's tastes and habits (achievements)
}


function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "steam_user":
      return returnSteamUser($request['username'],$request['password']);
    case "friendlist":
      return returnFriendlist($request['username'],$request['password']);
    case "new_account":
      return doCreateAccount($request['username'],$request['password']);
    case "login":
      return doLogin($request['username'],$request['password']);
    case "validate_session":
      return doValidate($request['sessionId']);
    case "compare":
      return doCompareSteamData($request['username'],$request['password']);
    case "collect":
      return doCollectSteamUser($request['username'],$request['password']);

  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("newRabbitMQ.ini","newServer");

$server->process_requests('requestProcessor');
exit();
?>

