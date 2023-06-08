<?php

require_once 'include/command.php';
require_once 'include/token.php';

$commandObject = new Command();
$command="0";
if(isset($_POST[$commandObject->CMD])){
	$command = $_POST[$commandObject->CMD];
}

$fromweb="0";

if(isset($_POST["FROMWEB"])){
	$fromweb = $_POST["FROMWEB"];
}
$tokenObject = new Token();
$tokenid="0";
$token="";

$response ='';

if(isset($_POST[$tokenObject->FLD_TOKEN_ID])){
	$tokenid = $_POST[$tokenObject->FLD_TOKEN_ID];
}
if(isset($_POST[$tokenObject->FLD_TOKEN])){
	$token = $_POST[$tokenObject->FLD_TOKEN];
}
switch ($command) {
	case $commandObject->CMD_SAVE:
      
			$jsonsave = $tokenObject->createToken($tokenid,$token);
			
			echo json_encode($jsonsave);
		
        break;
	case $commandObject->CMD_UPDATE:
			$jsonsave = $tokenObject->updateToken($tokenid, $token);
			
			echo json_encode($jsonsave);
		
		break;
 	case $commandObject->CMD_LIST:
		$response = $tokenObject->listToken($tokenid, $token);
		//$response = $tokenObject->listTokenAll();
    		echo json_encode($response);
		break;

	case $commandObject->CMD_DELETE:
		$response = $tokenObject->deleteToken($tokenid);
		//$response = $tokenObject->listTokenAll();
    		echo json_encode($response);
		break;
    default:
        echo "";
}

if ($fromweb == "1"){
 header("Location:../token.php");
}
?>