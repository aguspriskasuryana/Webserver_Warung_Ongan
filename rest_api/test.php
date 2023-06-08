<?php

require_once 'include/command.php';
require_once 'include/paket.php';
require_once 'include/user.php';

$commandObject = new Command();
$command="0";
if(isset($_POST[$commandObject->CMD])){
	$command = $_POST[$commandObject->CMD];
}

$paketObject = new Paket();
$userObject = new User();
			
			$response = $userObject->listUserAll();
			
			
			echo json_encode($response);
		

?>