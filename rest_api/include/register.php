<?php

include_once 'db.php';

class User{
	
	private $db;
	private $db_table = "user";
	
    public $FLD_USER_ID = "USER_ID";
    public $FLD_USERNAME = "USERNAME";
    public $FLD_PASSWORD = "PASSWORD";
    public $FLD_FULL_NAME = "FULL_NAME";
    public $FLD_EMAIL = "EMAIL";
    public $FLD_ADDRESS = "ADDRESS";
    public $FLD_FILE_ATTACH = "FILE_ATTACH";
    public $FLD_PHONE_NUMBER = "PHONE_NUMBER";
    public $FLD_BIRTH_PLACE = "BIRTH_PLACE";
    public $FLD_BIRTH_DATE = "BIRTH_DATE";
    public $FLD_SEX = "SEX";
    public $FLD_JOIN_DATE = "JOIN_DATE";
	public $FLD_USER_PRIVILAGE_AS = "USER_PRIVILAGE_AS";
	
	public function __construct(){
		$this->db = new DbConnect();
	}
		
	
	public function isLoginExist($email, $password){		
				
		$query = "select * from " . $this->db_table . " where (" . $this->FLD_EMAIL . " = '$email' OR " . $this->FLD_USERNAME . " = '$email' ) AND " . $this->FLD_PASSWORD . " = '$password' Limit 1";
		
		$result = mysqli_query($this->db->getDb(), $query);
		if(mysqli_num_rows($result) > 0){
			mysqli_close($this->db->getDb());
			return true;
		}		
		mysqli_close($this->db->getDb());
		return false;		
	}
	
	public function isEmailAlready($email){		
				
		$query = "select * from " . $this->db_table . " where " . $this->FLD_EMAIL . " = '$email' Limit 1";
		
		$result = mysqli_query($this->db->getDb(), $query);
		if(mysqli_num_rows($result) > 0){
			//mysqli_close($this->db->getDb());
			return true;
		}		
		//mysqli_close($this->db->getDb());
		return false;		
	}
	public function isUsernameAlready($username){		
				
		$query = "select * from " . $this->db_table . " where " . $this->FLD_USERNAME . " = '$username' Limit 1";
		
		$result = mysqli_query($this->db->getDb(), $query);
		if(mysqli_num_rows($result) > 0){
			return true;
		}		
		return false;		
	}
	
	
	
	public function loginUsers($email, $password){
			
		$json = array();
		
		$queryX = "select * from " . $this->db_table . " where (" . $this->FLD_EMAIL . " = '$email' OR " . $this->FLD_USERNAME . " = '$email' ) AND ". $this->FLD_PASSWORD . " = '$password'";
		
		$resultX = mysqli_query($this->db->getDb(), $queryX);
		if(mysqli_num_rows($resultX) > 0){
			while($row = $resultX->fetch_array()){
			$json[$this->FLD_USER_ID] = $row[$this->FLD_USER_ID];
			$json[$this->FLD_USERNAME] = $row[$this->FLD_USERNAME];
			}
			
			$canUserLogin = $this->isLoginExist($email, $password);
			if($canUserLogin){
				$json['success'] = 2;
			}else{
				$json['success'] = 1;
			}
		} else {
			$json['success'] = 0;
			
		mysqli_close($this->db->getDb());
		}
		
		return $json;
	}

public function loginAdmin($username, $password){
			
		$response = array();
		
		$queryX = "select * from admin where ". $this->FLD_USERNAME . " = '$username' AND ". $this->FLD_PASSWORD . " = '$password' AND ". $this->FLD_USER_PRIVILAGE_AS . " = '1'";
		
		$result = mysqli_query($this->db->getDb(), $queryX);
		
		
		$no = 0;
		if(mysqli_num_rows($result) > 0){
			while($row = $result->fetch_array()){
		    	$response["$no"][$this->FLD_USER_ID] = $row[$this->FLD_USER_ID];
		    	$response["$no"][$this->FLD_USERNAME] = $row[$this->FLD_USERNAME];
		    	$response["$no"][$this->FLD_PASSWORD] = $row[$this->FLD_PASSWORD];
		    	$response["$no"][$this->FLD_FULL_NAME] = $row[$this->FLD_FULL_NAME];
		    	$response["$no"][$this->FLD_EMAIL] = $row[$this->FLD_EMAIL];
		    	$response["$no"][$this->FLD_ADDRESS] = $row[$this->FLD_ADDRESS];
		    	$response["$no"][$this->FLD_FILE_ATTACH] = $row[$this->FLD_FILE_ATTACH];
		    	$response["$no"][$this->FLD_PHONE_NUMBER] = $row[$this->FLD_PHONE_NUMBER];
		    	$response["$no"][$this->FLD_BIRTH_PLACE] = $row[$this->FLD_BIRTH_PLACE];
		    	$response["$no"][$this->FLD_BIRTH_DATE] = $row[$this->FLD_BIRTH_DATE];
		    	$response["$no"][$this->FLD_SEX] = $row[$this->FLD_SEX];
		    	$response["$no"][$this->FLD_JOIN_DATE] = $row[$this->FLD_JOIN_DATE];
		    	$response["$no"][$this->FLD_USER_PRIVILAGE_AS] = $row[$this->FLD_USER_PRIVILAGE_AS];
				
				$no++;
	    	}
		}
		mysqli_close($this->db->getDb());
		
		
		return $response;
	}
	
	
	
	public function createUser($username, $password, $fullname, $email,$address,$fileattach, $phonenumber, $birthplace,$birthdate,$sex,$joindate,$userprivilage){
		$json = array();
		$isEmailALready = $this->isEmailAlready($email);
		if ($isEmailALready){
		$json['emailReady'] = 1;
		$json['success'] = 0;
		return $json;
		}
		$isUsernameALready = $this->isUsernameAlready($username);
		if ($isUsernameALready){
		$json['usernameReady'] = 1;
		$json['success'] = 0;
		return $json;
		}
		
		
			
		$query = "INSERT INTO `user`
	 (" . $this->FLD_USERNAME . "," . $this->FLD_PASSWORD . "," . $this->FLD_FULL_NAME . "," . $this->FLD_EMAIL . "," . $this->FLD_ADDRESS . "," . $this->FLD_FILE_ATTACH . "," . $this->FLD_PHONE_NUMBER . "," . $this->FLD_BIRTH_PLACE . "," . $this->FLD_BIRTH_DATE . "," . $this->FLD_SEX . "," . $this->FLD_JOIN_DATE . "," . $this->FLD_USER_PRIVILAGE_AS . ") VALUES 
		('$username','$password','$fullname','$email','$address','$fileattach','$phonenumber','$birthplace','$birthdate','$sex',NOW(),'$userprivilage');";	
		
		
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
	
	public function updateUser($userid,$username, $password, $fullname, $email,$address,$fileattach, $phonenumber, $birthplace,$birthdate,$sex,$joindate,$userprivilage){
			
			
		$query = "UPDATE `user` SET " 
		. $this->FLD_USERNAME . "='$username' ," 
		. $this->FLD_PASSWORD . "='$password'" ;
		if (!empty($fullname) && $fullname != ""){
			$query = $query." , ".$this->FLD_FULL_NAME . "='$fullname' " ;
		}
		if (!empty($email) && $email != ""){
			$query = $query." , ".$this->FLD_EMAIL . "='$email' " ;
		}
		if (!empty($address) && $address != ""){
			$query = $query." , ".$this->FLD_ADDRESS . "='$address' " ;
		}
		//if (!empty($fileattach) && $fileattach != ""){
		//	$query = $query." , ". $this->FLD_FILE_ATTACH . "='$fileattach',"  ;
		//}
		if (!empty($phonenumber) && $phonenumber != ""){
			$query = $query." , ". $this->FLD_PHONE_NUMBER . "='$phonenumber' " ;
		}
		if (!empty($birthplace) && $birthplace != ""){
			$query = $query." , ". $this->FLD_BIRTH_PLACE . "='$birthplace' " ;
		}
		if (!empty($birthdate) && $birthdate != ""){
			$query = $query." , ". $this->FLD_BIRTH_DATE . "='$birthdate' " ;
		}
		
			$query = $query." , ". $this->FLD_SEX . "='$sex' " ;
		
		if (!empty($joindate) && $joindate != ""){
			$query = $query." , ". $this->FLD_JOIN_DATE . "='$joindate' " ;
		}
		if (!empty($userprivilage) && $userprivilage != ""){
			$query = $query." , ". $this->FLD_USER_PRIVILAGE_AS . "='$userprivilage'" ;
		}
		
		
		$query = $query. " WHERE "
		. $this->FLD_USER_ID . "='$userid'; 
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
	
	public function deleteUser($userid){
			
		$query = "DELETE FROM `user` WHERE ". $this->FLD_USER_ID . "='$userid'";	
		
		$delete = mysqli_query($this->db->getDb(), $query);
		if($delete == 1){
			$json['success'] = 1;									
		}else{
			$json['success'] = 0;
		}
		mysqli_close($this->db->getDb());
		return $json;
	}
	
	
	public function listUserAll(){
		$listUser = $this->listUser("","", "", "", "","","", "", "","","","","");
		return $listUser;
	}
	
	public function listUser($userid,$username, $password, $fullname, $email,$address,$fileattach, $phonenumber, $birthplace,$birthdate,$sex,$joindate,$userprivilage){
			
		$response = array();
		$query = "select * from " . $this->db_table . " WHERE 1=1 ";
		
		if (!empty($userid)){
			$query = $query ." AND ". $this->FLD_USER_ID . " = '$userid' " ;
		}
		if (!empty($username)){
			$query = $query ." AND ". $this->FLD_USERNAME . " LIKE '%$username%' " ;
		}
		if (!empty($password)){
			$query = " AND ". $this->FLD_PASSWORD . " = '$password' " ;
		}
		if (!empty($fullname)){
			$query = " AND ". $this->FLD_FULL_NAME . " LIKE '%$fullname%' " ;
		}
		if (!empty($email)){
			$query = " AND ". $this->FLD_EMAIL . " = '$email' " ;
		}
		if (!empty($address)){
			$query = " AND ". $this->FLD_ADDRESS . " LIKE '%$address%' " ;
		}
		if (!empty($phonenumber)){
			$query = " AND ". $this->FLD_PHONE_NUMBER . " LIKE '%$phonenumber&' " ;
		}
		if (!empty($birthplace)){
			$query = " AND ". $this->FLD_BIRTH_PLACE . " = '$birthplace' " ;
		}
		if (!empty($birthdate)){
			$query = " AND ". $this->FLD_BIRTH_DATE . " = '$birthdate' " ;
		}
		if (!empty($sex)){
			$query = " AND ". $this->FLD_SEX . " = '$sex' " ;
		}
		if (!empty($joindate)){
			$query = " AND ". $this->FLD_JOIN_DATE . " = '$joindate' " ;
		}
		if (!empty($userprivilage)){
			$query = " AND ". $this->FLD_USER_PRIVILAGE_AS . " = '$userprivilage' " ;
		}
		
		$result = mysqli_query($this->db->getDb(), $query);
		
		
		$no = 0;
		if(mysqli_num_rows($result) > 0){
			while($row = $result->fetch_array()){
		    	$response["$no"][$this->FLD_USER_ID] = $row[$this->FLD_USER_ID];
		    	$response["$no"][$this->FLD_USERNAME] = $row[$this->FLD_USERNAME];
		    	$response["$no"][$this->FLD_PASSWORD] = $row[$this->FLD_PASSWORD];
		    	$response["$no"][$this->FLD_FULL_NAME] = $row[$this->FLD_FULL_NAME];
		    	$response["$no"][$this->FLD_EMAIL] = $row[$this->FLD_EMAIL];
		    	$response["$no"][$this->FLD_ADDRESS] = $row[$this->FLD_ADDRESS];
		    	$response["$no"][$this->FLD_FILE_ATTACH] = $row[$this->FLD_FILE_ATTACH];
		    	$response["$no"][$this->FLD_PHONE_NUMBER] = $row[$this->FLD_PHONE_NUMBER];
		    	$response["$no"][$this->FLD_BIRTH_PLACE] = $row[$this->FLD_BIRTH_PLACE];
		    	$response["$no"][$this->FLD_BIRTH_DATE] = $row[$this->FLD_BIRTH_DATE];
		    	$response["$no"][$this->FLD_SEX] = $row[$this->FLD_SEX];
		    	$response["$no"][$this->FLD_JOIN_DATE] = $row[$this->FLD_JOIN_DATE];
		    	$response["$no"][$this->FLD_USER_PRIVILAGE_AS] = $row[$this->FLD_USER_PRIVILAGE_AS];
				
				$no++;
	    	}
		}
		mysqli_close($this->db->getDb());
		
		return $response;
	}


public function getUserById($userid){
			
		$response = array();
		$query = "select * from " . $this->db_table . " WHERE 1=1 ";
		
		if (!empty($userid)){
			$query = $query ." AND ". $this->FLD_USER_ID . " = '$userid' " ;
		}
		
		$result = mysqli_query($this->db->getDb(), $query);
		
		
		$no = 0;
		if(mysqli_num_rows($result) > 0){
			while($row = $result->fetch_array()){
		    	$response["$no"][$this->FLD_USER_ID] = $row[$this->FLD_USER_ID];
		    	$response["$no"][$this->FLD_USERNAME] = $row[$this->FLD_USERNAME];
		    	$response["$no"][$this->FLD_PASSWORD] = $row[$this->FLD_PASSWORD];
		    	$response["$no"][$this->FLD_FULL_NAME] = $row[$this->FLD_FULL_NAME];
		    	$response["$no"][$this->FLD_EMAIL] = $row[$this->FLD_EMAIL];
		    	$response["$no"][$this->FLD_ADDRESS] = $row[$this->FLD_ADDRESS];
		    	$response["$no"][$this->FLD_FILE_ATTACH] = $row[$this->FLD_FILE_ATTACH];
		    	$response["$no"][$this->FLD_PHONE_NUMBER] = $row[$this->FLD_PHONE_NUMBER];
		    	$response["$no"][$this->FLD_BIRTH_PLACE] = $row[$this->FLD_BIRTH_PLACE];
		    	$response["$no"][$this->FLD_BIRTH_DATE] = $row[$this->FLD_BIRTH_DATE];
		    	$response["$no"][$this->FLD_SEX] = $row[$this->FLD_SEX];
		    	$response["$no"][$this->FLD_JOIN_DATE] = $row[$this->FLD_JOIN_DATE];
		    	$response["$no"][$this->FLD_USER_PRIVILAGE_AS] = $row[$this->FLD_USER_PRIVILAGE_AS];
				
				$no++;
	    	}
		}
		mysqli_close($this->db->getDb());
		
		return $response;
	}
	
	public function getUsernameById($userid){
			
		$response = "";
		$query = "select * from " . $this->db_table . " WHERE 1=1 ";
		
		if (!empty($userid)){
			$query = $query ." AND ". $this->FLD_USER_ID . " = '$userid' " ;
		}
		
		$result = mysqli_query($this->db->getDb(), $query);
		
		
		if(mysqli_num_rows($result) > 0){
			while($row = $result->fetch_array()){
		    	$response = $row[$this->FLD_USERNAME];
		    }
		}
		mysqli_close($this->db->getDb());
		
		return $response;
	}
}


?>