<?php

require_once 'include/command.php';
require_once 'include/book.php';

$commandObject = new Command();
$command="0";
if(isset($_POST[$commandObject->CMD])){
	$command = $_POST[$commandObject->CMD];
}


$response ='';

$fromweb="0";

if(isset($_POST["FROMWEB"])){
	$fromweb = $_POST["FROMWEB"];
}
$bookObject = new Book();
$bookid="0";
$memberid="0";
$paketid="0"; 
$tanggaldari="";
$tanggalberhenti=""; 
$bookingstatus="";
$tanggalrequest="";
$makananid="";
$totalharga="";
$detail="";
$note="";

$paketname="";

if(isset($_POST["paketnamex"])){
	$paketname = $_POST["paketnamex"];
}

$tokenid="";

if(isset($_POST["token_id"])){
	$tokenid = $_POST["token_id"];
}
if(isset($_POST[$bookObject->FLD_BOOK_ID])){
	$bookid = $_POST[$bookObject->FLD_BOOK_ID];
}
if(isset($_POST[$bookObject->FLD_MEMBER_ID])){
	$memberid = $_POST[$bookObject->FLD_MEMBER_ID];
}
if(isset($_POST[$bookObject->FLD_PAKET_ID])){
	$paketid = $_POST[$bookObject->FLD_PAKET_ID];
}
if(isset($_POST[$bookObject->FLD_TANGGAL_DARI])){
	$tanggaldari = $_POST[$bookObject->FLD_TANGGAL_DARI];
}
if(isset($_POST[$bookObject->FLD_TANGGAL_BERHENTI])){
	$tanggalberhenti = $_POST[$bookObject->FLD_TANGGAL_BERHENTI];
}
if(isset($_POST[$bookObject->FLD_BOOKING_STATUS])){
	$bookingstatus = $_POST[$bookObject->FLD_BOOKING_STATUS];
}
if(isset($_POST[$bookObject->FLD_TANGGAL_REQUEST])){
	$tanggalrequest = $_POST[$bookObject->FLD_TANGGAL_REQUEST];
}
if(isset($_POST[$bookObject->FLD_MAKANAN_ID])){
	$makananid = $_POST[$bookObject->FLD_MAKANAN_ID];
}
if(isset($_POST[$bookObject->FLD_TOTAL_HARGA])){
	$totalharga = $_POST[$bookObject->FLD_TOTAL_HARGA];
}
if(isset($_POST[$bookObject->FLD_DETAIL])){
	$detail = $_POST[$bookObject->FLD_DETAIL];
}
if(isset($_POST[$bookObject->FLD_NOTE])){
	$note = $_POST[$bookObject->FLD_NOTE];
}



switch ($command) {
	
 	case $commandObject->CMD_APPROVE:
		$response = $bookObject->approveBook($bookid,$paketname,$tokenid);
    		echo json_encode($response);
		break;
	case $commandObject->CMD_DELETE:
		$response = $bookObject->deleteBook($bookid);
    		echo json_encode($response);
		break;	
	case $commandObject->CMD_LIST:
		$response = $bookObject->listBook($bookid,$memberid, $paketid, $tanggaldari,$tanggalberhenti,$bookingstatus, $tanggalrequest);
    		echo json_encode($response);
		break;
	case $commandObject->CMD_PRINT:
		$response = $bookObject->listBookApprove($bookid,$memberid, $paketid, $tanggaldari,$tanggalberhenti,$bookingstatus, $tanggalrequest);
    		echo json_encode($response);
		break;
	case $commandObject->CMD_SAVE:
		$response = $bookObject->createBook($memberid, $paketid, $tanggaldari,$tanggalberhenti,$bookingstatus, $tanggalrequest,$makananid,$totalharga,$detail,$note,$tokenid);
    		echo json_encode($response);
		break;
	case $commandObject->CMD_GENERATE:
		$response = $bookObject->getJamOnrequest($tanggaldari);
    		echo json_encode($response);
		break;

		
		
		case $commandObject->CMD_DELETE:
		$response = $bookObject->deleteBook($bookid);
    		echo json_encode($response);
		break;
    default:
        echo "";
}

//$responsex = $bookObject->listBook($bookid,$memberid, $paketid, $tanggaldari,$tanggalberhenti,$bookingstatus, $tanggalrequest);
   // echo json_encode($responsex);


if ($fromweb == "1"){
 header("Location:../book.php?sukses=".$response['success']."&action=".$command);
}
?>