<?php

include_once 'db.php';

class Book{
	
	private $db;
	private $db_table = "reservasi";
	
    public $FLD_BOOK_ID = "RESERVASI_ID";
    public $FLD_MEMBER_ID = "MEMBER_ID";
    public $FLD_PAKET_ID = "PAKET_ID";
    public $FLD_TANGGAL_DARI = "TANGGAL_DARI";
    public $FLD_TANGGAL_BERHENTI = "TANGGAL_BERHENTI";
    public $FLD_BOOKING_STATUS = "RESERVASI_STATUS";
    public $FLD_TANGGAL_REQUEST = "TANGGAL_REQUEST";
    public $FLD_MAKANAN_ID = "MAKANAN_ID";
    public $FLD_TOTAL_HARGA = "TOTAL_HARGA";
    public $FLD_DETAIL = "DETAIL";
    public $FLD_NOTE = "NOTE";
    public $FLD_NOTIF = "NOTIF";
	
	public function __construct(){
		$this->db = new DbConnect();
	}
	
	public function createBook($memberId,$paketId, $tanggalDari, $tanggalBerhenti, $bookingStatus,$tanggalRequest,$makananId,$totalharga,$detail,$note,$tokenid){
		$json = array();
			
		$query = "INSERT INTO " . $this->db_table . "
	 (" . $this->FLD_MEMBER_ID . "," . $this->FLD_PAKET_ID . "," . $this->FLD_TANGGAL_DARI . "," . $this->FLD_TANGGAL_BERHENTI . "," . $this->FLD_BOOKING_STATUS . "," . $this->FLD_TANGGAL_REQUEST . "," . $this->FLD_MAKANAN_ID . "," . $this->FLD_TOTAL_HARGA . "," . $this->FLD_DETAIL . "," . $this->FLD_NOTE . ") VALUES 
('$memberId','$paketId','$tanggalDari','$tanggalBerhenti','$bookingStatus','$tanggalRequest','$makananId','$totalharga','$detail','$note');";	
		
		
		$inserted = mysqli_query($this->db->getDb(), $query);
		if($inserted == 1){
			$json['success'] = 1;			
			
			#API access key from Google API's Console
				define( 'API_ACCESS_KEY', 'AIzaSyAck0-uRI3SKyNrm_891x4TStbd4s0ErCE' );
				$registrationIds = $tokenid;
			
			#prep the bundle
				 $msg = array
					  (
					'body' 	=> 'AA'.$memberId,
					'title'	=> $detail.": Kode Pembayaran ",
							'icon'	=> 'myicon',
							'sound' => 'mySound'
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
			//echo $result;

			
									
		}else{
			$json['success'] = 2;
		}
		
			$json['query'] = $query;
		mysqli_close($this->db->getDb());
		return $json;
	}
	
	public function listBookAll(){
		$listBook = $this->listBook("","", "", "", "","","");
		return $listBook;
	}
	
	public function listBook($bookid,$memberid, $paketid, $tanggaldari,$tanggalberhenti,$bookingstatus, $tanggalrequest){
			
		$response = array();
		$query = "select " . $this->db_table . ".*,paket.* ,user.* from " . $this->db_table . " INNER JOIN paket on paket.paket_id = reservasi.paket_id  INNER JOIN user on user.USER_ID = reservasi.MEMBER_ID  WHERE 1=1 ";
		
			$query = $query ." AND " . $this->db_table . ".". $this->FLD_BOOKING_STATUS . " = '0' " ;
		
		if (!empty($memberid)){
			$query = $query ." AND " . $this->db_table . ".". $this->FLD_MEMBER_ID . " = '$memberid' " ;
		}
		if (!empty($paketid)){
			$query = $query ." AND " . $this->db_table . ".". $this->FLD_PAKET_ID . " = '$paketid' " ;
		}
		if (!empty($tanggaldari)){
			$query = $query ." AND " . $this->db_table . ".". $this->FLD_TANGGAL_DARI . " = '$tanggaldari' " ;
		}
		if (!empty($tanggalberhenti)){
			$query = $query ." AND " . $this->db_table . ".". $this->FLD_TANGGAL_BERHENTI . " = '$tanggalberhenti' " ;
		}
		if (!empty($bookingstatus)){
			$query = $query ." AND " . $this->db_table . ".". $this->FLD_BOOKING_STATUS . " LIKE '%$bookingstatus%' " ;
		}
		if (!empty($TANGGAL_REQUEST)){
			$query = $query ." AND " . $this->db_table . ".". $this->FLD_TANGGAL_REQUEST . " = '$tanggalrequest' " ;
		}
	
		$query = $query ." ORDER BY " . $this->db_table . ".". $this->FLD_TANGGAL_REQUEST . " ASC " ;
		$result = mysqli_query($this->db->getDb(), $query);
		
		//var_dump($query);
		$no = 0;
		if(mysqli_num_rows($result) > 0){
			while($row = $result->fetch_array()){
		    	$response["data"]["$no"][$this->FLD_BOOK_ID] = $row[$this->FLD_BOOK_ID];
		    	$response["data"]["$no"][$this->FLD_MEMBER_ID] = $row[$this->FLD_MEMBER_ID];
		    	$response["data"]["$no"][$this->FLD_PAKET_ID] = $row[$this->FLD_PAKET_ID];
		    	$response["data"]["$no"][$this->FLD_TANGGAL_DARI] = $row[$this->FLD_TANGGAL_DARI];
		    	$response["data"]["$no"][$this->FLD_TANGGAL_BERHENTI] = $row[$this->FLD_TANGGAL_BERHENTI];
		    	$response["data"]["$no"][$this->FLD_BOOKING_STATUS] = $row[$this->FLD_BOOKING_STATUS];
		    	$response["data"]["$no"][$this->FLD_TANGGAL_REQUEST] = $row[$this->FLD_TANGGAL_REQUEST];
		    	$response["data"]["$no"]["PAKET_NAME"] = $row["PAKET_NAME"];
		    	$response["data"]["$no"]["FULL_NAME"] = $row["FULL_NAME"];
		    	$response["data"]["$no"]["PAKET_HARGA"] = $row["PAKET_HARGA"];
		    	$response["data"]["$no"]["PAKET_IMG"] = $row["PAKET_IMG"];
		    	$response["data"]["$no"]["TOTAL_HARGA"] = $row["TOTAL_HARGA"];
		    	
				$no++;
	    	}
		}
		mysqli_close($this->db->getDb());
		
		return $response;
	}
	
	public function listBookforAdmin(){
			
		$response = array();
		$query = "select " . $this->db_table . ".*,paket.* ,user.*,token.TOKEN_ID from " . $this->db_table . " INNER JOIN paket on paket.paket_id = reservasi.paket_id  INNER JOIN user on user.USER_ID = reservasi.MEMBER_ID LEFT JOIN token on token.TOKEN = user.USER_ID  WHERE 1=1 ";
		
			//$query = $query ." AND " . $this->db_table . ".". $this->FLD_BOOKING_STATUS . " = '0' " ;
		
		$query = $query ." ORDER BY " . $this->db_table . ".". $this->FLD_TANGGAL_REQUEST . " ASC " ;
		$result = mysqli_query($this->db->getDb(), $query);
		
		//var_dump($query);
		$no = 0;
		if(mysqli_num_rows($result) > 0){
			while($row = $result->fetch_array()){
		    	$response["data"]["$no"][$this->FLD_BOOK_ID] = $row[$this->FLD_BOOK_ID];
		    	$response["data"]["$no"][$this->FLD_MEMBER_ID] = $row[$this->FLD_MEMBER_ID];
		    	$response["data"]["$no"][$this->FLD_PAKET_ID] = $row[$this->FLD_PAKET_ID];
		    	$response["data"]["$no"][$this->FLD_TANGGAL_DARI] = $row[$this->FLD_TANGGAL_DARI];
		    	$response["data"]["$no"][$this->FLD_TANGGAL_BERHENTI] = $row[$this->FLD_TANGGAL_BERHENTI];
		    	$response["data"]["$no"][$this->FLD_BOOKING_STATUS] = $row[$this->FLD_BOOKING_STATUS];
		    	$response["data"]["$no"][$this->FLD_TANGGAL_REQUEST] = $row[$this->FLD_TANGGAL_REQUEST];
		    	$response["data"]["$no"][$this->FLD_NOTE] = $row[$this->FLD_NOTE];
		    	$response["data"]["$no"]["PAKET_NAME"] = $row["PAKET_NAME"];
		    	$response["data"]["$no"]["FULL_NAME"] = $row["FULL_NAME"];
		    	$response["data"]["$no"]["PAKET_HARGA"] = $row["PAKET_HARGA"];
		    	$response["data"]["$no"]["PAKET_IMG"] = $row["PAKET_IMG"];
		    	$response["data"]["$no"]["TOTAL_HARGA"] = $row["TOTAL_HARGA"];
		    	$response["data"]["$no"]["TOKEN_ID"] = $row["TOKEN_ID"];
		    	
				$no++;
	    	}
		}
		mysqli_close($this->db->getDb());
		
		return $response;
	}

	public function listBookforsend(){
		$tgl = date("Y-m-d");	
		$response = array();
		$query = "select " . $this->db_table . ".*,paket.* ,user.*,token.TOKEN_ID from " . $this->db_table . " INNER JOIN paket on paket.paket_id = reservasi.paket_id  INNER JOIN user on user.USER_ID = reservasi.MEMBER_ID INNER JOIN token on token.TOKEN = user.USER_ID  WHERE 1=1 ";
		
		$query = $query ." AND " . $this->db_table . ".". $this->FLD_BOOKING_STATUS . " = '1' " ;
		$query = $query ." AND " . $this->db_table . ".". $this->FLD_NOTIF. " = '0' " ;
		
		$query = $query ." ORDER BY " . $this->db_table . ".". $this->FLD_TANGGAL_REQUEST . " ASC " ;
		$result = mysqli_query($this->db->getDb(), $query);
		
		//var_dump($query);
		$no = 0;
		if(mysqli_num_rows($result) > 0){
			while($row = $result->fetch_array()){
		    	$response["data"]["$no"][$this->FLD_BOOK_ID] = $row[$this->FLD_BOOK_ID];
		    	$response["data"]["$no"][$this->FLD_MEMBER_ID] = $row[$this->FLD_MEMBER_ID];
		    	$response["data"]["$no"][$this->FLD_PAKET_ID] = $row[$this->FLD_PAKET_ID];
		    	$response["data"]["$no"][$this->FLD_TANGGAL_DARI] = $row[$this->FLD_TANGGAL_DARI];
		    	$response["data"]["$no"][$this->FLD_TANGGAL_BERHENTI] = $row[$this->FLD_TANGGAL_BERHENTI];
		    	$response["data"]["$no"][$this->FLD_BOOKING_STATUS] = $row[$this->FLD_BOOKING_STATUS];
		    	$response["data"]["$no"][$this->FLD_TANGGAL_REQUEST] = $row[$this->FLD_TANGGAL_REQUEST];
		    	$response["data"]["$no"][$this->FLD_NOTE] = $row[$this->FLD_NOTE];
		    	$response["data"]["$no"]["PAKET_NAME"] = $row["PAKET_NAME"];
		    	$response["data"]["$no"]["FULL_NAME"] = $row["FULL_NAME"];
		    	$response["data"]["$no"]["PAKET_HARGA"] = $row["PAKET_HARGA"];
		    	$response["data"]["$no"]["PAKET_IMG"] = $row["PAKET_IMG"];
		    	$response["data"]["$no"]["TOTAL_HARGA"] = $row["TOTAL_HARGA"];
		    	$response["data"]["$no"]["TOKEN_ID"] = $row["TOKEN_ID"];
		    	
				
				
				$no++;
	    	}
		}
		mysqli_close($this->db->getDb());
		
		return $response;
	}
	
	public function listBookApprove($bookid,$memberid, $paketid, $tanggaldari,$tanggalberhenti,$bookingstatus, $tanggalrequest){
			
		$response = array();
		$query = "select " . $this->db_table . ".*,paket.* ,user.* from " . $this->db_table . " INNER JOIN paket on paket.paket_id = reservasi.paket_id  INNER JOIN user on user.USER_ID = reservasi.MEMBER_ID  WHERE 1=1 ";
		
		
		$query = $query ." AND " . $this->db_table . ".". $this->FLD_BOOKING_STATUS . " = '1' " ;
		
		if (!empty($memberid)){
			$query = $query ." AND " . $this->db_table . ".". $this->FLD_MEMBER_ID . " = '$memberid' " ;
		}
		if (!empty($paketid)){
			$query = $query ." AND " . $this->db_table . ".". $this->FLD_PAKET_ID . " = '$paketid' " ;
		}
		if (!empty($tanggaldari)){
			$query = $query ." AND " . $this->db_table . ".". $this->FLD_TANGGAL_DARI . " = '$tanggaldari' " ;
		}
		if (!empty($tanggalberhenti)){
			$query = $query ." AND " . $this->db_table . ".". $this->FLD_TANGGAL_BERHENTI . " = '$tanggalberhenti' " ;
		}
		if (!empty($bookingstatus)){
			$query = $query ." AND " . $this->db_table . ".". $this->FLD_BOOKING_STATUS . " LIKE '%$bookingstatus%' " ;
		}
		if (!empty($TANGGAL_REQUEST)){
			$query = $query ." AND " . $this->db_table . ".". $this->FLD_TANGGAL_REQUEST . " = '$tanggalrequest' " ;
		}
	
		$query = $query ." ORDER BY " . $this->db_table . ".". $this->FLD_TANGGAL_REQUEST . " ASC " ;
		$result = mysqli_query($this->db->getDb(), $query);
		$response["query"] = $query;
		//var_dump($query);
		$no = 0;
		if(mysqli_num_rows($result) > 0){
			while($row = $result->fetch_array()){
		    	$response["data"]["$no"][$this->FLD_BOOK_ID] = $row[$this->FLD_BOOK_ID];
		    	$response["data"]["$no"][$this->FLD_MEMBER_ID] = $row[$this->FLD_MEMBER_ID];
		    	$response["data"]["$no"][$this->FLD_PAKET_ID] = $row[$this->FLD_PAKET_ID];
		    	$response["data"]["$no"][$this->FLD_TANGGAL_DARI] = $row[$this->FLD_TANGGAL_DARI];
		    	$response["data"]["$no"][$this->FLD_TANGGAL_BERHENTI] = $row[$this->FLD_TANGGAL_BERHENTI];
		    	$response["data"]["$no"][$this->FLD_BOOKING_STATUS] = $row[$this->FLD_BOOKING_STATUS];
		    	$response["data"]["$no"][$this->FLD_TANGGAL_REQUEST] = $row[$this->FLD_TANGGAL_REQUEST];
		    	$response["data"]["$no"]["PAKET_NAME"] = $row["PAKET_NAME"];
		    	$response["data"]["$no"]["FULL_NAME"] = $row["FULL_NAME"];
		    	$response["data"]["$no"]["PAKET_HARGA"] = $row["PAKET_HARGA"];
		    	$response["data"]["$no"]["PAKET_IMG"] = $row["PAKET_IMG"];
		    	$response["data"]["$no"]["TOTAL_HARGA"] = $row["TOTAL_HARGA"];
		    	
				$no++;
	    	}
		}
		mysqli_close($this->db->getDb());
		
		return $response;
	}
	
	public function approveBook($bookid,$paketname,$tokenid){
			
			
		$query = "UPDATE " . $this->db_table . " SET " 
		. $this->FLD_BOOKING_STATUS . "='1' " ;
		echo "x".$paketname;
		$query = $query. " WHERE "
		. $this->FLD_BOOK_ID . "='$bookid'; 
 ";	
		
		echo $query;
		$update = mysqli_query($this->db->getDb(), $query);
		if($update == 1){
			$json['success'] = 1;									
		}else{
			$json['success'] = 0;
		}
		mysqli_close($this->db->getDb());
		
	
	#API access key from Google API's Console
    define( 'API_ACCESS_KEY', 'AIzaSyAck0-uRI3SKyNrm_891x4TStbd4s0ErCE' );
    $registrationIds = $tokenid;

#prep the bundle
     $msg = array
          (
		'body' 	=> 'sukses',
		'title'	=> $paketname."Berhasil",
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
//echo $result;

		
		return $json;
	}
	
	public function deleteBook($bookid){
			
		$response = "";
		$query = "delete from " . $this->db_table . " WHERE 1=1 ";
		$query = $query ." AND ". $this->FLD_BOOK_ID . " = '$bookid' " ;		
		$result = mysqli_query($this->db->getDb(), $query);
		var_dump($query);
		mysqli_close($this->db->getDb());
		
		return $response;
	}

	public function getBookById($bookid){
			
		$response = array();
		$query = "select * from " . $this->db_table . " WHERE 1=1 ";
		
		if (!empty($bookid)){
			$query = $query ." AND ". $this->FLD_BOOK_ID . " = '$bookid' " ;
		}
		
		$result = mysqli_query($this->db->getDb(), $query);
		
		
		$no = 0;
		if(mysqli_num_rows($result) > 0){
			while($row = $result->fetch_array()){
		    	
		    	$response["data"]["$no"][$this->FLD_BOOK_ID] = $row[$this->FLD_BOOK_ID];
		    	$response["data"]["$no"][$this->FLD_MEMBER_ID] = $row[$this->FLD_MEMBER_ID];
		    	$response["data"]["$no"][$this->FLD_PAKET_ID] = $row[$this->FLD_PAKET_ID];
		    	$response["data"]["$no"][$this->FLD_TANGGAL_DARI] = $row[$this->FLD_TANGGAL_DARI];
		    	$response["data"]["$no"][$this->FLD_TANGGAL_BERHENTI] = $row[$this->FLD_TANGGAL_BERHENTI];
		    	$response["data"]["$no"][$this->FLD_BOOKING_STATUS] = $row[$this->FLD_BOOKING_STATUS];
		    	$response["data"]["$no"][$this->FLD_TANGGAL_REQUEST] = $row[$this->FLD_TANGGAL_REQUEST];
				
				$no++;
	    	}
		}
		mysqli_close($this->db->getDb());
		
		return $response;
	}
	
	
}


?>