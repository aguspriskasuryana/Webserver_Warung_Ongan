<?php

#API access key from Google API's Console
    define( 'API_ACCESS_KEY', 'AIzaSyAck0-uRI3SKyNrm_891x4TStbd4s0ErCE' );
    $registrationIds = 'ewhcHg9EiAU:APA91bFEPxCr4NOCLcwnB8jWlFrBpZkMFNtBARFP-fL-h27pd2XYbK7f8nYQhkiKCEsmGoeJDCNXLT8azahNtud8gzL68CyVR_nI3rBxhQo3C688ZpYuyG8XnI-tnQ-187Q69CXp6MOEELhyLO5r99eXl0k0cQWSDw';

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
