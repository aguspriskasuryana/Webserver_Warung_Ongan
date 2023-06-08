<?php

#API access key from Google API's Console
    define( 'API_ACCESS_KEY', 'AIzaSyAck0-uRI3SKyNrm_891x4TStbd4s0ErCE' );
    $registrationIds = 'cSWgj7oIN-s:APA91bFqx2gJeXpeSMi0AY7xLbC3T2OoqqdH1ZSlPShBPNb6ORW0NdhEoV7xLWMxYFYDudBHdbCsZSLnCBYu9BH_Q6U5Ijgnk6f8xjuMRUbvn60i3rW6-IOGy7Uu5FSEE5GEjBzBXjueNSnxLlfWWVhgAaBbhVyLyw';

#prep the bundle
     $msg = array
          (
		'body' 	=> 'B Of Notification',
		'title'	=> 'Pesanan Paket',
             	'icon'	=> 'myicon',/*Default Icon*/
              	'sound' => 'mySound'/*Default sound*/
          );

	$fields = array
			(
				'to'		=> $registrationIds,
				'notification'	=> $msg
			);
	
	
	$headers = array
			(
				'Authorization: key=' . API_ACCESS_KEY,
				'Content-Type: application/json'
			);

#Send Reponse To FireBase Server	
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );

#Echo Result Of FireBase Server
echo $result;
