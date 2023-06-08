<?php

include_once 'db.php';

class Token{
	
	private $db;
	private $db_table = "token";
	
    public $FLD_TOKEN_ID = "TOKEN_ID";
    public $FLD_TOKEN = "TOKEN";
	
	public function __construct(){
		$this->db = new DbConnect();
	}
	
	public function createToken($token,$userid){
		$json = array();
		
		$queryx = "delete from " . $this->db_table . " WHERE ". $this->FLD_TOKEN_ID . " = '$token' " ;	
		var_dump($queryx);	
		$resultx = mysqli_query($this->db->getDb(), $queryx);
		
		$query = "INSERT INTO " . $this->db_table . "
	 (" . $this->FLD_TOKEN_ID . "," . $this->FLD_TOKEN . ") VALUES 
('$token','$userid');";	
		
		
		$inserted = mysqli_query($this->db->getDb(), $query);
		if($inserted == 1){
			$json['success'] = 1;									
		}else{
			$json['success'] = 2;
		}
		
			$json['query'] = $queryx;
		mysqli_close($this->db->getDb());
		return $json;
	}
	
	public function listTokenAll(){
		$listBook = $this->listToken("");
		return $listBook;
	}
	
	public function listToken($token){
			
		$response = array();
		$query = "select " . $this->db_table . ".* from " . $this->db_table . "  WHERE 1=1 ";
				
		if (!empty($token)){
			$query = $query ." AND " . $this->db_table . ".". $this->FLD_TOKEN . " = '$token' " ;
		}
	
		$result = mysqli_query($this->db->getDb(), $query);
		
		//var_dump($query);
		$no = 0;
		if(mysqli_num_rows($result) > 0){
			while($row = $result->fetch_array()){
		    	$response["data"]["$no"][$this->FLD_TOKEN] = $row[$this->FLD_TOKEN];			$no++;
	    	}
		}
		mysqli_close($this->db->getDb());
		
		return $response;
	}
	
	public function deleteToken($tokenid){
			
		$response = "";
		$query = "delete from " . $this->db_table . " WHERE 1=1 ";
		$query = $query ." AND ". $this->FLD_TOKEN_ID . " = '$tokenid' " ;		
		$result = mysqli_query($this->db->getDb(), $query);
		
		mysqli_close($this->db->getDb());
		
		return $response;
	}

	public function getTokenById($tokenid){
			
		$response = array();
		$query = "select * from " . $this->db_table . " WHERE 1=1 ";
		
		if (!empty($tokenid)){
			$query = $query ." AND ". $this->FLD_TOKEN_ID . " = '$tokenid' " ;
		}
		
		$result = mysqli_query($this->db->getDb(), $query);
		
		
		$no = 0;
		if(mysqli_num_rows($result) > 0){
			while($row = $result->fetch_array()){
		    	
		    	$response["data"]["$no"][$this->FLD_TOKEN] = $row[$this->FLD_TOKEN];
				
				$no++;
	    	}
		}
		mysqli_close($this->db->getDb());
		
		return $response;
	}
	
	
}


?>