<?php

require_once 'include/command.php';
require_once 'include/paket.php';

$commandObject = new Command();
$command="0";
if(isset($_POST[$commandObject->CMD])){
	$command = $_POST[$commandObject->CMD];
}

$fromweb="0";

if(isset($_POST["FROMWEB"])){
	$fromweb = $_POST["FROMWEB"];
}
$paketObject = new Paket();
$paketid="0";
$paketcategoryid="0";
$paketname=""; 
$paketdetail="";
$paketharga=""; 
$paketstatus="";
$paketimg="";
$maxkursi="";

if(isset($_POST[$paketObject->FLD_PAKET_ID])){
	$paketid = $_POST[$paketObject->FLD_PAKET_ID];
}
if(isset($_POST[$paketObject->FLD_PAKET_NAME])){
	$paketname = $_POST[$paketObject->FLD_PAKET_NAME];
}
if(isset($_POST[$paketObject->FLD_PAKET_CATEGORY_ID])){
	$paketcategoryid = $_POST[$paketObject->FLD_PAKET_CATEGORY_ID];
}
if(isset($_POST[$paketObject->FLD_PAKET_DETAIL])){
	$paketdetail = $_POST[$paketObject->FLD_PAKET_DETAIL];
}
if(isset($_POST[$paketObject->FLD_PAKET_HARGA])){
	$paketharga = $_POST[$paketObject->FLD_PAKET_HARGA];
}
if(isset($_POST[$paketObject->FLD_PAKET_STATUS])){
	$paketstatus = $_POST[$paketObject->FLD_PAKET_STATUS];
}
if(isset($_POST[$paketObject->FLD_PAKET_IMG])){
	$paketimg = $_POST[$paketObject->FLD_PAKET_IMG];
}

if(isset($_POST[$paketObject->FLD_MAX_KURSI])){
	$maxkursi = $_POST[$paketObject->FLD_MAX_KURSI];
}


switch ($command) {
	case $commandObject->CMD_SAVE:
      
			$jsonsave = $paketObject->createPaket($paketid,$paketcategoryid,$paketname,$paketdetail,$paketharga,$paketstatus,$paketimg,$maxkursi);
			
			echo json_encode($jsonsave);
		
        break;
	case $commandObject->CMD_UPDATE:
			echo "paket id ".$paketid."paket category id ".$paketcategoryid."paketname ".$paketname."paketdetail ".$paketdetail."paket harga ".$paketharga."paketstatus ".$paketstatus."paket image ".$paketimg;
			$jsonsave = $paketObject->updatePaket($paketid,$paketcategoryid, $paketname, $paketdetail,$paketharga,$paketstatus, $paketimg,$maxkursi);
			
			echo json_encode($jsonsave);
		
		break;
 	case $commandObject->CMD_LIST:
		$response = $paketObject->listPaket($paketid,$paketcategoryid, $paketname, $paketdetail,$paketharga,$paketstatus, $paketimg,$maxkursi);
		//$response = $paketObject->listPaketAll();
    		echo json_encode($response);
		break;

	case $commandObject->CMD_PRINT:
		$response = $paketObject->listPaketInnerJoin($paketid,$paketcategoryid, $paketname, $paketdetail,$paketharga,$paketstatus, $paketimg,$maxkursi);
		//$response = $paketObject->listPaketAll();
    		echo json_encode($response);
		break;
	case $commandObject->CMD_DELETE:
		$response = $paketObject->deletePaket($paketid);
		//$response = $paketObject->listPaketAll();
    		echo json_encode($response);
		break;
    default:
        echo "";
}

if ($fromweb == "1"){
 header("Location:../paket.php");
}
?>