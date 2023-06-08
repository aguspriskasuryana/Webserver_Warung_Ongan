<?php

require_once 'include/command.php';
require_once 'include/makanan.php';

$commandObject = new Command();
$command="0";
if(isset($_POST[$commandObject->CMD])){
	$command = $_POST[$commandObject->CMD];
}

$fromweb="0";

if(isset($_POST["FROMWEB"])){
	$fromweb = $_POST["FROMWEB"];
}
$makananObject = new Makanan();
$makananid="0";
$makananname=""; 
$makanandetail="";
$makananharga=""; 
$makananstatus="";
$makananimg="";

$response ='';
if(isset($_POST[$makananObject->FLD_MAKANAN_ID])){
	$makananid = $_POST[$makananObject->FLD_MAKANAN_ID];
}
if(isset($_POST[$makananObject->FLD_MAKANAN_NAME])){
	$makananname = $_POST[$makananObject->FLD_MAKANAN_NAME];
}
if(isset($_POST[$makananObject->FLD_MAKANAN_DETAIL])){
	$makanandetail = $_POST[$makananObject->FLD_MAKANAN_DETAIL];
}
if(isset($_POST[$makananObject->FLD_MAKANAN_HARGA])){
	$makananharga = $_POST[$makananObject->FLD_MAKANAN_HARGA];
}
if(isset($_POST[$makananObject->FLD_MAKANAN_STATUS])){
	$makananstatus = $_POST[$makananObject->FLD_MAKANAN_STATUS];
}
if(isset($_POST[$makananObject->FLD_MAKANAN_IMG])){
	$makananimg = $_POST[$makananObject->FLD_MAKANAN_IMG];
}


switch ($command) {
	case $commandObject->CMD_SAVE:
      
			$response = $makananObject->createMakanan($makananid,$makananname,$makanandetail,$makananharga,$makananstatus,$makananimg);
			
			echo json_encode($response);
		
        break;
	case $commandObject->CMD_UPDATE:
			echo "makanan id ".$makananid."makananname ".$makananname."makanandetail ".$makanandetail."makanan harga ".$makananharga."makananstatus ".$makananstatus."makanan image ".$makananimg;
			$response = $makananObject->updateMakanan($makananid, $makananname, $makanandetail,$makananharga,$makananstatus, $makananimg);
			
			echo json_encode($response);
		
		break;
 	case $commandObject->CMD_LIST:
		$response = $makananObject->listMakananAll();
    		echo json_encode($response);
		break;

	
	case $commandObject->CMD_DELETE:
		$response = $makananObject->deleteMakanan($makananid);
    		echo json_encode($response);
		break;
    default:
        echo "";
}

if ($fromweb == "1"){
 header("Location:../makanan.php?sukses=".$response['success']."&action=".$command);
}
?>