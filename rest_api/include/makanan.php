<?php

include_once 'db.php';

class Makanan{
	
	private $db;
	private $db_table = "makanan";
	
    public $FLD_MAKANAN_ID = "MAKANAN_ID";
    public $FLD_MAKANAN_NAME = "MAKANAN_NAME";
    public $FLD_MAKANAN_DETAIL = "MAKANAN_DETAIL";
    public $FLD_MAKANAN_HARGA = "MAKANAN_HARGA";
    public $FLD_MAKANAN_STATUS = "MAKANAN_STATUS";
    public $FLD_MAKANAN_IMG = "MAKANAN_IMG";
	
	public function __construct(){
		$this->db = new DbConnect();
	}
	
	public function isMakananNameAlready($makananname){		
				
		$query = "select * from " . $this->db_table . " where " . $this->FLD_MAKANAN_NAME . " = '$makananname' Limit 1";
		
		$result = mysqli_query($this->db->getDb(), $query);
		if(mysqli_num_rows($result) > 0){
			return true;
		}		
		return false;		
	}

	public function updateImageMakanan ($makananid, $makananimg){
			
			
		$query = "UPDATE `makanan` SET " 
		. $this->FLD_MAKANAN_IMG . "='$makananimg' " ;
		$query = $query. " WHERE "
		. $this->FLD_MAKANAN_ID . "='$makananid';";	
		
		echo $query;
		$update = mysqli_query($this->db->getDb(), $query);
		if($update == 1){
			$json['success'] = 1;									
		}else{
			$json['success'] = 0;
		}
		mysqli_close($this->db->getDb());
		return $json;
	}
	
	public function createMakanan($makananid,$makananname, $makanandetail,$makananharga,$makananstatus, $makananimg){
		$json = array();
		
		$isMakanannameALready = $this->isMakananNameAlready($makananname);
		if ($isMakanannameALready){
		$json['makanannameReady'] = 1;
		$json['success'] = 0;
		return $json;
		}
		
			
		$query = "INSERT INTO `makanan`
		(" . $this->FLD_MAKANAN_NAME . "," . $this->FLD_MAKANAN_DETAIL . "," . $this->FLD_MAKANAN_HARGA . "," . $this->FLD_MAKANAN_STATUS . "," . $this->FLD_MAKANAN_IMG . ") VALUES 
		('$makananname','$makanandetail','$makananharga','$makananstatus','$makananimg');";			
		
		$inserted = mysqli_query($this->db->getDb(), $query);
		if($inserted == 1){
			$json['success'] = 1;									
		}else{
			$json['success'] = 5;
		}
		
			$json['query'] = $query;
		mysqli_close($this->db->getDb());
		return $json;
	}
	
	public function updateMakanan ($makananid,$makananname, $makanandetail,$makananharga,$makananstatus, $makananimg){
			
			
		$query = "UPDATE `makanan` SET " 
		. $this->FLD_MAKANAN_NAME . "='$makananname' " ;
		
		if (!empty($makanandetail) && $makanandetail != ""){
			$query = $query." , ".$this->FLD_MAKANAN_DETAIL . "='$makanandetail' " ;
		}
		if (!empty($makananharga) && $makananharga != ""){
			$query = $query." , ".$this->FLD_MAKANAN_HARGA . "='$makananharga' " ;
		}
		
			$query = $query." , ".$this->FLD_MAKANAN_STATUS . "='$makananstatus' " ;

		if (!empty($makananimg ) && $makananimg != ""){
			$query = $query." , ".$this->FLD_MAKANAN_IMG . "='$makananimg' " ;
		}
		$query = $query. " WHERE "
		. $this->FLD_MAKANAN_ID . "='$makananid'; 
 ";	
		
		echo $query;
		$update = mysqli_query($this->db->getDb(), $query);
		if($update == 1){
			$json['success'] = 1;									
		}else{
			$json['success'] = 0;
		}
		mysqli_close($this->db->getDb());
		return $json;
	}
	
	public function listMakananAll(){
		$listMAKANAN = $this->listMAKANAN("", "", "","","", "", "","","","","");
		return $listMAKANAN;
	}
	
	public function listMakanan($makananid,$makananname, $makanandetail,$makananharga,$makananstatus, $makananimg){
			
		$response = array();
		$query = "select * from " . $this->db_table . " WHERE 1=1 ";
		
			//$query = $query ." AND ". $this->FLD_MAKANAN_STATUS . " = '1' " ;
		
		if (!empty($makananid)){
			$query = $query ." AND ". $this->FLD_MAKANAN_ID . " = '$makananid' " ;
		}
		if (!empty($makananname)){
			$query = $query ." AND ". $this->FLD_MAKANAN_NAME . " LIKE '%$makananname%' " ;
		}
		if (!empty($makanandetail)){
			$query = $query ." AND ". $this->FLD_MAKANAN_DETAIL . " LIKE '%$makanandetail%' " ;
		}
		if (!empty($makananharga)){
			$query = $query ." AND ". $this->FLD_MAKANAN_HARGA . " LIKE '%$makananharga%' " ;
		}
		if (!empty($makananstatus)){
			$query = $query ." AND ". $this->FLD_MAKANAN_IMG . " = '$makananimg' " ;
		}

	
		
		$result = mysqli_query($this->db->getDb(), $query);
		
		
		$no = 0;
		if(mysqli_num_rows($result) > 0){
			while($row = $result->fetch_array()){
		    	$response["data"]["$no"][$this->FLD_MAKANAN_ID] = $row[$this->FLD_MAKANAN_ID];
		    	$response["data"]["$no"][$this->FLD_MAKANAN_NAME] = $row[$this->FLD_MAKANAN_NAME];
		    	$response["data"]["$no"][$this->FLD_MAKANAN_DETAIL] = $row[$this->FLD_MAKANAN_DETAIL];
		    	$response["data"]["$no"][$this->FLD_MAKANAN_HARGA] = $row[$this->FLD_MAKANAN_HARGA];
		    	$response["data"]["$no"][$this->FLD_MAKANAN_STATUS] = $row[$this->FLD_MAKANAN_STATUS];
		    	$response["data"]["$no"][$this->FLD_MAKANAN_IMG] = $row[$this->FLD_MAKANAN_IMG];
				
				$no++;
	    	}
		}
		mysqli_close($this->db->getDb());
		
		return $response;
	}
	
	public function listMakananForAdmin(){
			
		$response = array();
		$query = "select * from " . $this->db_table . " WHERE 1=1 ";
		
		
		if (!empty($makananid)){
			$query = $query ." AND ". $this->FLD_MAKANAN_ID . " = '$makananid' " ;
		}
		if (!empty($makananname)){
			$query = $query ." AND ". $this->FLD_MAKANAN_NAME . " LIKE '%$makananname%' " ;
		}
		if (!empty($makanandetail)){
			$query = $query ." AND ". $this->FLD_MAKANAN_DETAIL . " LIKE '%$makanandetail%' " ;
		}
		if (!empty($makananharga)){
			$query = $query ." AND ". $this->FLD_MAKANAN_HARGA . " LIKE '%$makananharga%' " ;
		}
		if (!empty($makananstatus)){
			$query = $query ." AND ". $this->FLD_MAKANAN_IMG . " = '$makananimg' " ;
		}

	
		
		$result = mysqli_query($this->db->getDb(), $query);
		
		
		$no = 0;
		if(mysqli_num_rows($result) > 0){
			while($row = $result->fetch_array()){
		    	$response["data"]["$no"][$this->FLD_MAKANAN_ID] = $row[$this->FLD_MAKANAN_ID];
		    	$response["data"]["$no"][$this->FLD_MAKANAN_NAME] = $row[$this->FLD_MAKANAN_NAME];
		    	$response["data"]["$no"][$this->FLD_MAKANAN_DETAIL] = $row[$this->FLD_MAKANAN_DETAIL];
		    	$response["data"]["$no"][$this->FLD_MAKANAN_HARGA] = $row[$this->FLD_MAKANAN_HARGA];
		    	$response["data"]["$no"][$this->FLD_MAKANAN_STATUS] = $row[$this->FLD_MAKANAN_STATUS];
		    	$response["data"]["$no"][$this->FLD_MAKANAN_IMG] = $row[$this->FLD_MAKANAN_IMG];
				
				$no++;
	    	}
		}
		mysqli_close($this->db->getDb());
		
		return $response;
	}

	
	public function getMakananBYId($makananid){
			
		$response = array();
		$query = "select * from " . $this->db_table . " WHERE 1=1 ";
		
		if (!empty($makananid)){
			$query = $query ." AND ". $this->FLD_MAKANAN_ID . " = '$makananid' " ;
		}
		
		$result = mysqli_query($this->db->getDb(), $query);
		
		
		$no = 0;
		if(mysqli_num_rows($result) > 0){
			while($row = $result->fetch_array()){
		    	$response["data"]["$no"][$this->FLD_MAKANAN_ID] = $row[$this->FLD_MAKANAN_ID];
		    	$response["data"]["$no"][$this->FLD_MAKANAN_NAME] = $row[$this->FLD_MAKANAN_NAME];
		    	$response["data"]["$no"][$this->FLD_MAKANAN_DETAIL] = $row[$this->FLD_MAKANAN_DETAIL];
		    	$response["data"]["$no"][$this->FLD_MAKANAN_HARGA] = $row[$this->FLD_MAKANAN_HARGA];
		    	$response["data"]["$no"][$this->FLD_MAKANAN_STATUS] = $row[$this->FLD_MAKANAN_STATUS];
		    	$response["data"]["$no"][$this->FLD_MAKANAN_IMG] = $row[$this->FLD_MAKANAN_IMG];
				
				$no++;
	    	}
		}
		mysqli_close($this->db->getDb());
		
		return $response;
	}
	
	public function getMakanannameById($makananid){
			
		$response = "";
		$query = "select * from " . $this->db_table . " WHERE 1=1 ";
		
		if (!empty($makananid)){
			$query = $query ." AND ". $this->FLD_MAKANAN_ID . " = '$makananid' " ;
		}
		
		$result = mysqli_query($this->db->getDb(), $query);
		
	
		if(mysqli_num_rows($result) > 0){
			while($row = $result->fetch_array()){
		    	$response = $row[$this->FLD_MAKANAN_NAME];
	    	}
		}
		mysqli_close($this->db->getDb());
		
		return $response;
	}

	public function deleteMakanan($makananid){
			
		$response = "";
		$query = "delete from " . $this->db_table . " WHERE 1=1 ";
		
		if (!empty($makananid)){
			$query = $query ." AND ". $this->FLD_MAKANAN_ID . " = '$makananid' " ;
		}
		
		$result = mysqli_query($this->db->getDb(), $query);
		
		mysqli_close($this->db->getDb());
		
		return $response;
	}
	
	

}


?>