#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


function checkLogin{
        $client = new rabbitMQClient("newRabbitMQ.ini","newServer");
        
        //create array, include type (decides switch option for server)
        //add necessary data for functions in additional array slots
        //send request
        $request = array();
        $request['type'] = "Login";
        //$request['']="";
        $response = $client->send_request($request);
        
        echo "client received response: ".PHP_EOL;
        print_r($response);
        echo "\n\n";

}

function registerUser{
	//
	$client = new rabbitMQClient("newRabbitMQ.ini","newServer");

}

function getSteamUser{
	//
	$client = new rabbitMQClient("newRabbitMQ.ini","newServer");

}

function getFriends{
        $client = new rabbitMQClient("newRabbitMQ.ini","newServer");

        //create array, include type (decides switch option for server)
        //add necessary data for functions in additional array slots
        //send request
        $request = array();
        $request['type'] = "friendlist";
	$request['id'] = "steamid";
        //$request['']="";
        $response = $client->send_request($request);

        foreach($request as $friend){
		$avatar = $friend['avatar']
		$fName = $friend['fName']
                echo "<img src=$avatar>";
                echo "\r\n";
                echo $fName;
                echo "<br>";
        }



        echo "client received response: ".PHP_EOL;
        print_r($response);
        echo "\n\n";

}

$client = new rabbitMQClient("newRabbitMQ.ini","newServer");

$request = array();

/*
if (isset($argv[1]))
{
  $msg = $argv[1];
}
else
{
  $msg = "test message";
}

$request = array();
$request['type'] = "Login";
$request['username'] = "steve";
$request['password'] = "password";
$request['message'] = $msg;
$response = $client->send_request($request);
//$response = $client->publish($request);
*/


echo "client received response: ".PHP_EOL;
print_r($response);
echo "\n\n";

echo $argv[0]." END".PHP_EOL;

