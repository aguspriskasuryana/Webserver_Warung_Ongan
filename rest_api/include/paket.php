<?php

include_once 'db.php';

class Paket{
	
	private $db;
	private $db_table = "paket";
	
    public $FLD_PAKET_ID = "PAKET_ID";
    public $FLD_PAKET_CATEGORY_ID = "PAKET_CATEGORY_ID";
    public $FLD_PAKET_NAME = "PAKET_NAME";
    public $FLD_PAKET_DETAIL = "PAKET_DETAIL";
    public $FLD_PAKET_HARGA = "PAKET_HARGA";
    public $FLD_PAKET_STATUS = "PAKET_STATUS";
    public $FLD_PAKET_IMG = "PAKET_IMG";
    public $FLD_MAX_KURSI = "MAX_KURSI";
	
	public function __construct(){
		$this->db = new DbConnect();
	}
	
	public function isPaketNameAlready($paketname){		
				
		$query = "select * from " . $this->db_table . " where " . $this->FLD_PAKET_NAME . " = '$paketname' Limit 1";
		
		$result = mysqli_query($this->db->getDb(), $query);
		if(mysqli_num_rows($result) > 0){
			return true;
		}		
		return false;		
	}
	
	public function createPaket($paketid,$paketcategoryid, $paketname, $paketdetail,$paketharga,$paketstatus, $paketimg, $maxkursi){
		$json = array();
		
		$isPaketnameALready = $this->isPaketNameAlready($paketname);
		if ($isPaketnameALready){
		$json['paketnameReady'] = 1;
		$json['success'] = 0;
		return $json;
		}
		
			
		$query = "INSERT INTO `paket`
		(" . $this->FLD_PAKET_NAME . "," . $this->FLD_PAKET_CATEGORY_ID . "," . $this->FLD_PAKET_DETAIL . "," . $this->FLD_PAKET_HARGA . "," . $this->FLD_PAKET_STATUS . "," . $this->FLD_PAKET_IMG . "," . $this->FLD_MAX_KURSI . ") VALUES 
		('$paketname','$paketcategoryid','$paketdetail','$paketharga','$paketstatus','$paketimg','$maxkursi');";	
		
		
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
	
	public function updatePaket ($paketid,$paketcategoryid, $paketname, $paketdetail,$paketharga,$paketstatus, $paketimg, $maxkursi){
			
			
		$query = "UPDATE `paket` SET " 
		. $this->FLD_PAKET_NAME . "='$paketname' " ;
		if (!empty($paketcategoryid) && $paketcategoryid != ""){
			$query = $query." , ".$this->FLD_PAKET_CATEGORY_ID . "='$paketcategoryid' " ;
		}
		if (!empty($paketdetail) && $paketdetail != ""){
			$query = $query." , ".$this->FLD_PAKET_DETAIL . "='$paketdetail' " ;
		}
		if (!empty($paketharga) && $paketharga != ""){
			$query = $query." , ".$this->FLD_PAKET_HARGA . "='$paketharga' " ;
		}
		if (!empty($paketstatus) && $paketstatus != ""){
			$query = $query." , ".$this->FLD_PAKET_STATUS . "='$paketstatus' " ;
		}
		if (!empty($paketimg ) && $paketimg != ""){
			$query = $query." , ".$this->FLD_PAKET_IMG . "='$paketimg' " ;
		}
		if (!empty($maxkursi ) && $maxkursi != ""){
			$query = $query." , ".$this->FLD_MAX_KURSI . "='$maxkursi' " ;
		}
		$query = $query. " WHERE "
		. $this->FLD_PAKET_ID . "='$paketid';";	
		
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

	public function updateImagePaket ($paketid, $paketimg){
			
			
		$query = "UPDATE `paket` SET " 
		. $this->FLD_PAKET_IMG . "='$paketimg' " ;
		$query = $query. " WHERE "
		. $this->FLD_PAKET_ID . "='$paketid';";	
		
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
	
	public function listPaketAll(){
		$listPAKET = $this->listPAKET("","", "", "", "","","", "", "","","","","");
		return $listPAKET;
	}
	
	public function listPaket($paketid,$paketcategoryid, $paketname, $paketdetail,$paketharga,$paketstatus, $paketimg, $maxkursi){
			
		$response = array();
		$query = "select * from " . $this->db_table . " WHERE 1=1 ";
			$query = $query ." AND ". $this->FLD_PAKET_STATUS . " = '1' " ;
		
		if (!empty($paketid)){
			$query = $query ." AND ". $this->FLD_PAKET_ID . " = '$paketid' " ;
		}
		if (!empty($paketname)){
			$query = $query ." AND ". $this->FLD_PAKET_NAME . " LIKE '%$paketname%' " ;
		}
		if (!empty($paketcategoryid)){
			$query = $query ." AND ". $this->FLD_PAKET_CATEGORY_ID . " = '$paketcategoryid' " ;
		}
		if (!empty($paketdetail)){
			$query = $query ." AND ". $this->FLD_PAKET_DETAIL . " LIKE '%$paketdetail%' " ;
		}
		if (!empty($paketharga)){
			$query = $query ." AND ". $this->FLD_PAKET_HARGA . " LIKE '%$paketharga%' " ;
		}
		if (!empty($paketstatus)){
			$query = $query ." AND ". $this->FLD_PAKET_IMG . " = '$paketimg' " ;
		}

		if (!empty($maxkursi)){
			$query = $query ." AND ". $this->FLD_MAX_KURSI . " = '$maxkursi' " ;
		}
	
		
		$result = mysqli_query($this->db->getDb(), $query);
		
		
		$no = 0;
		if(mysqli_num_rows($result) > 0){
			while($row = $result->fetch_array()){
		    	$response["data"]["$no"][$this->FLD_PAKET_ID] = $row[$this->FLD_PAKET_ID];
		    	$response["data"]["$no"][$this->FLD_PAKET_CATEGORY_ID] = $row[$this->FLD_PAKET_CATEGORY_ID];
		    	$response["data"]["$no"][$this->FLD_PAKET_NAME] = $row[$this->FLD_PAKET_NAME];
		    	$response["data"]["$no"][$this->FLD_PAKET_DETAIL] = $row[$this->FLD_PAKET_DETAIL];
		    	$response["data"]["$no"][$this->FLD_PAKET_HARGA] = $row[$this->FLD_PAKET_HARGA];
		    	$response["data"]["$no"][$this->FLD_PAKET_STATUS] = $row[$this->FLD_PAKET_STATUS];
		    	$response["data"]["$no"][$this->FLD_PAKET_IMG] = $row[$this->FLD_PAKET_IMG];
				$response["data"]["$no"][$this->FLD_MAX_KURSI] = $row[$this->FLD_MAX_KURSI];
				
				$no++;
	    	}
		}
		mysqli_close($this->db->getDb());
		
		return $response;
	}


	public function listPaketInnerJoin($paketid,$paketcategoryid, $paketname, $paketdetail,$paketharga,$paketstatus, $paketimg, $maxkursi){
			
		$response = array();
		$query = "select p.*,pc.PAKET_CATEGORY_NAME from " . $this->db_table . " p INNER JOIN PAKET_CATEGORY pc ON pc.PAKET_CATEGORY_ID = p.PAKET_CATEGORY_ID "." WHERE 1=1 ";
		
		if (!empty($paketid)){
			$query = $query ." AND p.". $this->FLD_PAKET_ID . " = '$paketid' " ;
		}
		if (!empty($paketname)){
			$query = $query ." AND p.". $this->FLD_PAKET_NAME . " LIKE '%$paketname%' " ;
		}
		if (!empty($paketcategoryid)){
			$query = $query ." AND p.". $this->FLD_PAKET_CATEGORY_ID . " = '$paketcategoryid' " ;
		}
		if (!empty($paketdetail)){
			$query = $query ." AND p.". $this->FLD_PAKET_DETAIL . " LIKE '%$paketdetail%' " ;
		}
		if (!empty($paketharga)){
			$query = $query ." AND p.". $this->FLD_PAKET_HARGA . " LIKE '%$paketharga%' " ;
		}
		if (!empty($paketstatus)){
			$query = $query ." AND p.". $this->FLD_PAKET_IMG . " = '$paketimg' " ;
		}

		if (!empty($maxkursi)){
			$query = $query ." AND p.". $this->FLD_MAX_KURSI . " = '$maxkursi' " ;
		}
	
		
		$result = mysqli_query($this->db->getDb(), $query);
		
		
		$no = 0;
		if(mysqli_num_rows($result) > 0){
			while($row = $result->fetch_array()){
		    	$response["data"]["$no"][$this->FLD_PAKET_ID] = $row[$this->FLD_PAKET_ID];
		    	$response["data"]["$no"][$this->FLD_PAKET_CATEGORY_ID] = $row[$this->FLD_PAKET_CATEGORY_ID];
		    	$response["data"]["$no"][$this->FLD_PAKET_NAME] = $row[$this->FLD_PAKET_NAME];
		    	$response["data"]["$no"][$this->FLD_PAKET_DETAIL] = $row[$this->FLD_PAKET_DETAIL];
		    	$response["data"]["$no"][$this->FLD_PAKET_HARGA] = $row[$this->FLD_PAKET_HARGA];
		    	$response["data"]["$no"][$this->FLD_PAKET_STATUS] = $row[$this->FLD_PAKET_STATUS];
		    	$response["data"]["$no"][$this->FLD_PAKET_IMG] = $row[$this->FLD_PAKET_IMG];
				$response["data"]["$no"][$this->FLD_MAX_KURSI] = $row[$this->FLD_MAX_KURSI];
				$response["data"]["$no"]["PAKET_CATEGORY_NAME"] = $row["PAKET_CATEGORY_NAME"];
				
				$no++;
	    	}
		}
		mysqli_close($this->db->getDb());
		
		return $response;
	}
	
	public function getPaketBYId($paketid){
			
		$response = array();
		$query = "select * from " . $this->db_table . " WHERE 1=1 ";
		
		if (!empty($paketid)){
			$query = $query ." AND ". $this->FLD_PAKET_ID . " = '$paketid' " ;
		}
		
		$result = mysqli_query($this->db->getDb(), $query);
		
		
		$no = 0;
		if(mysqli_num_rows($result) > 0){
			while($row = $result->fetch_array()){
		    	$response["data"]["$no"][$this->FLD_PAKET_ID] = $row[$this->FLD_PAKET_ID];
		    	$response["data"]["$no"][$this->FLD_PAKET_CATEGORY_ID] = $row[$this->FLD_PAKET_CATEGORY_ID];
		    	$response["data"]["$no"][$this->FLD_PAKET_NAME] = $row[$this->FLD_PAKET_NAME];
		    	$response["data"]["$no"][$this->FLD_PAKET_DETAIL] = $row[$this->FLD_PAKET_DETAIL];
		    	$response["data"]["$no"][$this->FLD_PAKET_HARGA] = $row[$this->FLD_PAKET_HARGA];
		    	$response["data"]["$no"][$this->FLD_PAKET_STATUS] = $row[$this->FLD_PAKET_STATUS];
		    	$response["data"]["$no"][$this->FLD_PAKET_IMG] = $row[$this->FLD_PAKET_IMG];
				$response["data"]["$no"][$this->FLD_MAX_KURSI] = $row[$this->FLD_MAX_KURSI];
				
				$no++;
	    	}
		}
		mysqli_close($this->db->getDb());
		
		return $response;
	}
	
	public function getPaketnameById($paketid){
			
		$response = "";
		$query = "select * from " . $this->db_table . " WHERE 1=1 ";
		
		if (!empty($paketid)){
			$query = $query ." AND ". $this->FLD_PAKET_ID . " = '$paketid' " ;
		}
		
		$result = mysqli_query($this->db->getDb(), $query);
		
	
		if(mysqli_num_rows($result) > 0){
			while($row = $result->fetch_array()){
		    	$response = $row[$this->FLD_PAKET_NAME];
	    	}
		}
		mysqli_close($this->db->getDb());
		
		return $response;
	}

	public function deletePaket($paketid){
			
		$response = "";
		$query = "delete from " . $this->db_table . " WHERE 1=1 ";
		
		if (!empty($paketid)){
			$query = $query ." AND ". $this->FLD_PAKET_ID . " = '$paketid' " ;
		}
		
		$result = mysqli_query($this->db->getDb(), $query);
		
		mysqli_close($this->db->getDb());
		
		return $response;
	}
	
	

}


?>