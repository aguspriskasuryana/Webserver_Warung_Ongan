<?php

require_once 'include/command.php';
require_once 'include/user.php';

$commandObject = new Command();
$command="0";
if(isset($_POST[$commandObject->CMD])){
	$command = $_POST[$commandObject->CMD];
}

$userObject = new User();
$userid="0";
$username=""; 
$password="";
$fullname=""; 
$email="";
$address="";
$fileattach="";
$phonenumber="";
$birthplace="";
$birthdate="";
$sex="0";
$joindate="";
$userprivilage="0";

$response="";
$fromweb="0";

if(isset($_POST["FROMWEB"])){
	$fromweb = $_POST["FROMWEB"];
}
$response = '';
if(isset($_POST[$userObject->FLD_USER_ID])){
	$userid = $_POST[$userObject->FLD_USER_ID];
}
if(isset($_POST[$userObject->FLD_USERNAME])){
	$username = $_POST[$userObject->FLD_USERNAME];
}
if(isset($_POST[$userObject->FLD_PASSWORD])){
	$password = $_POST[$userObject->FLD_PASSWORD];
}
if(isset($_POST[$userObject->FLD_FULL_NAME])){
	$fullname = $_POST[$userObject->FLD_FULL_NAME];
}
if(isset($_POST[$userObject->FLD_EMAIL])){
	$email = $_POST[$userObject->FLD_EMAIL];
}
if(isset($_POST[$userObject->FLD_ADDRESS])){
	$address = $_POST[$userObject->FLD_ADDRESS];
}
if(isset($_POST[$userObject->FLD_FILE_ATTACH])){
	$fileattach = $_POST[$userObject->FLD_FILE_ATTACH];
}
if(isset($_POST[$userObject->FLD_PHONE_NUMBER])){
	$phonenumber = $_POST[$userObject->FLD_PHONE_NUMBER];
}
if(isset($_POST[$userObject->FLD_BIRTH_PLACE])){
	$birthplace = $_POST[$userObject->FLD_BIRTH_PLACE];
}
if(isset($_POST[$userObject->FLD_BIRTH_DATE])){
	$birthdate = $_POST[$userObject->FLD_BIRTH_DATE];
}
if(isset($_POST[$userObject->FLD_SEX])){
	$sex = $_POST[$userObject->FLD_SEX];
}
if(isset($_POST[$userObject->FLD_JOIN_DATE])){
	$joindate = $_POST[$userObject->FLD_JOIN_DATE];
}
if(isset($_POST[$userObject->FLD_USER_PRIVILAGE_AS])){
	$userprivilage = $_POST[$userObject->FLD_USER_PRIVILAGE_AS];
}
$token = "";
if(isset($_POST["TOKEN_ID"])){
	$token = $_POST["TOKEN_ID"];
}




switch ($command) {
    case $commandObject->CMD_LOGIN:
        $json_array = $userObject->loginUsers($email, $password,$token);
    	echo json_encode($json_array);
        break;
    case $commandObject->CMD_SAVE:
      
			$hashed_password = md5($password);
			
			//$json_registration = $userObject->createUser($username, $password, $fullname, $email,$address,$fileattach, $phonenumber, $birthplace,$birthdate,$sex,$joindate,$positionid,$status,$userprivilage);
			$response = $userObject->createUser($username, $password, $fullname, $email,"","", "", "",$birthdate,"1","","0");
			
			echo json_encode($response);
		
        break;
    case $commandObject->CMD_UPDATE:
	
	
			echo "sex=".$sex;
        if(!empty($userid) && !empty($username) && !empty($password) && !empty($email)){
			$response = $userObject->updateUser($userid,$username, $password, $fullname, $email,$address,$fileattach, $phonenumber, $birthplace,$birthdate,$sex,$joindate,$userprivilage);
			echo json_encode($response);
		}
        break;
	case $commandObject->CMD_DELETE:
		if(!empty($userid) && $userid != 0 ){
			$response = $userObject->deleteUser($userid);
			
			echo json_encode($response);
		}
		break;
	case $commandObject->CMD_LIST:
		$response = $userObject->listUser($userid,$username, $password, $fullname, $email,$address,$fileattach, $phonenumber, $birthplace,$birthdate,$sex,$joindate,$userprivilage);
    		echo json_encode($response);
		break;
    default:
        echo "";
}

if ($fromweb == "1"){
 header("Location:../user.php?sukses=".$response['success']."&action=".$command);
}

?>