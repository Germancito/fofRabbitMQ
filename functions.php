<?php
/*
#stores functions that will be utilized to retrieve
#and store information into tables
*/







try{
	

	$apikey1="238E8D6B70BF7499EE36312EF39F91AA";
	
	function retrieveUserInfo($steamID)
	{
	
	
	/*
	#uses a members SteamID to fetch the users Steam username, and their avatar.
	#then stores it into a table called users, in the database profile;
	*/
	
		//echo 'User function working';
		//echo 'requsted steamid='.$steamID;
		$fetch_pInfo="http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=238E8D6B70BF7499EE36312EF39F91AA&steamids=$steamID";
		$jsonO=file_get_contents($fetch_pInfo);
		$jsondecoded=json_decode($jsonO);
		//echo $jsondecoded->response[0];
		$db1=mysqli_connect("localhost","root","password","profile");
			if (!mysqli_ping($db1)) 
			{
		    		echo 'Lost connection, exiting after query #1';
		    		exit;
			}
			
		foreach($jsondecoded->response->players as $player1)
		{
			$persona1 = $player1->personaname;
			$sID1 = $player1->steamid;
			$avatar1 = $player1->avatar;
			$sql_fetch_id1 ="SELECT * FROM users WHERE steamid = $sID1";
			$query_id1= mysqli_query($db1,$sql_fetch_id1);
			
			if(mysqli_num_rows($query_id1)==0)
				{				
				$storeProfile1 = "INSERT INTO users(name,steamid,avatar) VALUES ('$persona1','$sID1','$avatar1');";
				$q = mysqli_query($db1,$storeProfile1);
				}
			else{
				echo "already in database";
			}
		}

	
	}//endRetrieveUserInfo

	function addFriendsToUsers($steamID)
	{
		$apikey1="238E8D6B70BF7499EE36312EF39F91AA";
		$pushFriends="http://api.steampowered.com/ISteamUser/GetFriendList/v0001/?key=$apikey1&steamid=$steamID&relationship=friend";
		echo "addFriends initialized";
		echo $apikey1;
		$jsonList=file_get_contents($pushFriends);
		$json_decode=json_decode($jsonList);
		
		/*
		#When not requesting for a different file format
		#steam will output its data in a JSON.here I am 
		#taking the decoded JSON file and reading through 
		#for particular information;		
		*/
		
		
		//echo $json_decode->friendslist->friends[0]->steamid;
		
		foreach($json_decode->friendslist->friends as $friend)
		{
			$friendID= $friend->steamid;
			 
			retrieveUserInfo($friendID);
		}


	}//end addFriendsToUsers

	function showFriends($steamID)
	{
	$apikey1="238E8D6B70BF7499EE36312EF39F91AA";
		$pushFriends="http://api.steampowered.com/ISteamUser/GetFriendList/v0001/?key=$apikey1&steamid=$steamID&relationship=friend";
		//echo "addFriends initialized";
		//echo $apikey1;
		$jsonList=file_get_contents($pushFriends);
		$json_decode=json_decode($jsonList);
		//echo $json_decode->friendslist->friends[0]->steamid;
		
		$db1=mysqli_connect("localhost","root","password","profile");
			if (!mysqli_ping($db1)) 
			{
		    		echo 'Lost connection, exiting after query #1';
		    		exit;
			}
					
			 $i=0;
			 $friendArray=array();
			 
		foreach($json_decode->friendslist->friends as $friend)
		{
			$friendID=$friend->steamid;
			//echo $friendID;
			$sql_fetch_id ="SELECT * FROM users WHERE steamid = $friendID";
			$query_id= mysqli_query($db1,$sql_fetch_id);
			//echo $friendID;
			
			if(mysqli_num_rows($query_id)>0)
			{
				//echo "true";
				$sql_fetch_avatar ="SELECT avatar FROM users WHERE steamid = $friendID";
				$sql_fetch_id ="SELECT steamid FROM users WHERE steamid = $friendID";
				$sql_fetch_name ="SELECT name FROM users WHERE steamid = $friendID";
				
				$query_avatar= mysqli_query($db1,$sql_fetch_avatar);
				$row_avatar=mysqli_fetch_assoc($query_avatar);				
				
				//$query_id= mysqli_query($db1,$sql_fetch_id);
				//$row_id=mysqli_fetch_assoc($query_id);
				
				$query_name= mysqli_query($db1,$sql_fetch_name);				
				$row_name=mysqli_fetch_assoc($query_name);
				
				$avatar=$row_avatar["avatar"];
				//$fID=$row_avatar["id"];
				$fName=$row_name["name"];
				array_push($friendArray,$avatar,$fName);
				
				echo "<img src=$avatar>";
				echo "\r\n";
				echo $fName;
				echo "<br>";

			}
			else{
				addFriendsToUsers($steamID);
			}
		}
		return $friendArray;
	}//end show friends


	
}catch(ErrorException $e){
	echo $e->getMessage();
}



?>
