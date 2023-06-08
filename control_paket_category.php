<?php

require_once 'include/command.php';
require_once 'include/paket_category.php';

$commandObject = new Command();
$command="0";
if(isset($_POST[$commandObject->CMD])){
	$command = $_POST[$commandObject->CMD];
}

$fromweb="0";

if(isset($_POST["FROMWEB"])){
	$fromweb = $_POST["FROMWEB"];
}
$paket_categoryObject = new Paket();
$paket_categoryid="0";
$paket_categoryname=""; 
$paket_categoryimg="";

if(isset($_POST[$paket_categoryObject->FLD_PAKET_CATEGORY_ID])){
	$paket_categoryid = $_POST[$paket_categoryObject->FLD_PAKET_CATEGORY_ID];
}
if(isset($_POST[$paket_categoryObject->FLD_PAKET_CATEGORY_NAME])){
	$paket_categoryname = $_POST[$paket_categoryObject->FLD_PAKET_CATEGORY_NAME];
}
if(isset($_POST[$paket_categoryObject->FLD_PAKET_CATEGORY_IMG])){
	$paket_categoryimg = $_POST[$paket_categoryObject->FLD_PAKET_CATEGORY_IMG];
}

switch ($command) {
	case $commandObject->CMD_SAVE:
      
			$jsonsave = $paket_categoryObject->create($paket_categoryid,$paket_categoryname,$paket_categoryimg);
			
			echo json_encode($jsonsave);
		
        break;
	case $commandObject->CMD_UPDATE:
		
			$jsonsave = $paket_categoryObject->updatePaket($paket_categoryid,$paket_categoryname, $paket_categoryimg);
			
			echo json_encode($jsonsave);
		
		break;
 	case $commandObject->CMD_LIST:
		$response = $paket_categoryObject->listPaket($paket_categoryid, $paket_categoryname, $paket_categoryimg);
			echo json_encode($response);
		break;

	case $commandObject->CMD_PRINT:
		$response = $paket_categoryObject->listPaketInnerJoin($paket_categoryid, $paket_categoryname, $paket_categoryimg);
		    echo json_encode($response);
		break;
    default:
        echo "";
}

if ($fromweb == "1"){
 header("Location:../paket_category.php");
}
?>