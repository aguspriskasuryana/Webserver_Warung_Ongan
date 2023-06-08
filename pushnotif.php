
<?php 

$tokens = "dnR_HXCJ8AQ:APA91bHP84oN4aLv56tQASAFET3qRm6lMOhW7DKxtLo8j1jmeUwFsgHXnLdIL4rNl8L2ylhudhF_7DR70Lj5VpwEri59Q80vbN6OpI8UtELqaxD6ElUz3izfnb8wQeFFFUx3_5nSM_Zbq2EdUe1pZjdtwkrBHUsNTQ";
$message ="tes push notif";
 $url = 'https://fcm.googleapis.com/fcm/send';
 
 $msg = array
 (
 'body' => "$message",
 'title' => "Reservation"
 );
 $fields = array
 (
 'registration_ids' => $tokens,
 'notification' => $msg
 );
 $headers = array(
 'Authorization:key = AAAAT05kaKs:APA91bHYx5fb0uoyfSQS3I2dIZ47chpqUvWZ2wxIQk0yWjaGtlyv04cMtK5jx2-Qsbrs-SMt_kGkNUzVKaXUs1HT0u-gGR9mNFb9kDkkU4orjUe3cuv-KHv24JqB3AJ9sbjiniM73qADNaoj9AHgALWRX4bUa6j_7Q',
 'Content-Type: application/json'
 );
 
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_POST, true);
 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);  
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 $result = curl_exec($ch);           
 if ($result === FALSE) {
 die('Curl failed: ' . curl_error($ch));
echo "gagal";
 }
echo "berhasil";
 curl_close($ch);
 
?>