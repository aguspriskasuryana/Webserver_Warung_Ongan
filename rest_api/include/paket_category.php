<?php

include_once 'db.php';

class Paket_Category{
	
	private $db;
	private $db_table = "paket_category";
	
    public $FLD_PAKET_CATEGORY_ID = "PAKET_CATEGORY_ID";
    public $FLD_PAKET_CATEGORY_NAME = "PAKET_CATEGORY_NAME";
    public $FLD_PAKET_CATEGORY_IMG = "PAKET_CATEGORY_IMG";
	
	public function __construct(){
		$this->db = new DbConnect();
	}
	
	public function ispaket_categoryNameAlready($paket_categoryname){		
				
		$query = "select * from " . $this->db_table . " where " . $this->FLD_paket_category_NAME . " = '$paket_categoryname' Limit 1";
		
		$result = mysqli_query($this->db->getDb(), $query);
		if(mysqli_num_rows($result) > 0){
			return true;
		}		
		return false;		
	}
	
	public function createpaket_category($paket_categoryid, $paket_categoryname, $paket_categoryimg){
		$json = array();
		
		$ispaket_categorynameALready = $this->ispaket_categoryNameAlready($paket_categoryname);
		if ($ispaket_categorynameALready){
		$json['paket_categorynameReady'] = 1;
		$json['success'] = 0;
		return $json;
		}
		
			
		$query = "INSERT INTO `paket_category`
		(" . $this->FLD_paket_category_NAME . "," . $this->FLD_paket_category_IMG . ") VALUES 
		('$paket_categoryname','$paket_categoryimg');";	
		
		
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
	
	public function updatepaket_category ($paket_categoryid, $paket_categoryname,$paket_categoryimg){
			
			
		$query = "UPDATE `paket_category` SET " 
		. $this->FLD_paket_category_NAME . "='$paket_categoryname' " ;
		if (!empty($paket_categorycategoryid) && $paket_categorycategoryid != ""){
			$query = $query." , ".$this->FLD_paket_category_CATEGORY_ID . "='$paket_categorycategoryid' " ;
		}
		if (!empty($paket_categoryimg ) && $paket_categoryimg != ""){
			$query = $query." , ".$this->FLD_paket_category_IMG . "='$paket_categoryimg' " ;
		}
		$query = $query. " WHERE "
		. $this->FLD_paket_category_ID . "='$paket_categoryid'; 
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
	
	public function listpaket_categoryAll(){
		$listpaket_category = $this->listpaket_category("","", "", "", "","","", "", "","","","","");
		return $listpaket_category;
	}
	
	public function listpaket_category($paket_categoryid, $paket_categoryname, $paket_categoryimg){
			
		$response = array();
		$query = "select * from " . $this->db_table . " WHERE 1=1 ";
		
		if (!empty($paket_categoryid)){
			$query = $query ." AND ". $this->FLD_PAKET_CATEGORY_ID . " = '$paket_categoryid' " ;
		}
		if (!empty($paket_categoryname)){
			$query = $query ." AND ". $this->FLD_PAKET_CATEGORY_NAME . " LIKE '%$paket_categoryname%' " ;
		}
		
		$result = mysqli_query($this->db->getDb(), $query);
		
		
		$no = 0;
		if(mysqli_num_rows($result) > 0){
			while($row = $result->fetch_array()){
		    	$response["data"]["$no"][$this->FLD_PAKET_CATEGORY_ID] = $row[$this->FLD_PAKET_CATEGORY_ID];
		    	$response["data"]["$no"][$this->FLD_PAKET_CATEGORY_NAME] = $row[$this->FLD_PAKET_CATEGORY_NAME];
		    	$response["data"]["$no"][$this->FLD_PAKET_CATEGORY_IMG] = $row[$this->FLD_PAKET_CATEGORY_IMG];
				
				$no++;
	    	}
		}
		mysqli_close($this->db->getDb());
		
		return $response;
	}


	public function getpaket_categoryBYId($paket_categoryid){
			
		$response = array();
		$query = "select * from " . $this->db_table . " WHERE 1=1 ";
		
		if (!empty($paket_categoryid)){
			$query = $query ." AND ". $this->FLD_paket_category_ID . " = '$paket_categoryid' " ;
		}
		
		$result = mysqli_query($this->db->getDb(), $query);
		
		
		$no = 0;
		if(mysqli_num_rows($result) > 0){
			while($row = $result->fetch_array()){
		    	$response["data"]["$no"][$this->FLD_paket_category_ID] = $row[$this->FLD_paket_category_ID];
		    	$response["data"]["$no"][$this->FLD_paket_category_NAME] = $row[$this->FLD_paket_category_NAME];
		    	$response["data"]["$no"][$this->FLD_paket_category_IMG] = $row[$this->FLD_paket_category_IMG];
				
				$no++;
	    	}
		}
		mysqli_close($this->db->getDb());
		
		return $response;
	}
	
	public function getpaket_categorynameById($paket_categoryid){
			
		$response = "";
		$query = "select * from " . $this->db_table . " WHERE 1=1 ";
		$query = $query ." AND ". $this->FLD_PAKET_CATEGORY_ID . " = '$paket_categoryid' " ;
		
		
		$result = mysqli_query($this->db->getDb(), $query);
		
		var_dump($query);
	
		if(mysqli_num_rows($result) > 0){
			while($row = $result->fetch_array()){
		    	$response = $row[$this->FLD_PAKET_CATEGORY_NAME];
	    	}
		}
		mysqli_close($this->db->getDb());
		
		//return $response;
	}
	
	

}


?>