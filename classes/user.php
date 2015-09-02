<?php
include_once 'dbconnect.php';

class User implements JsonSerializable {
	
	private $id;
	private $name;
	private $con;
	private $exists=false;
	
	function __construct($id=0) {

		//constructor - takes dbconnect.php and stores SQLconnection object as personal database link
		$this->con=new SQLconnection();
		$this->id=$id;
		$result_fields=array("name","pass");
		
		$table="User";
		
		$eid = new stdClass();
		$eid->column="id";
		$eid->compare="=";
		$eid->logical="";
		$eid->value=$id;
		$query_params=array($eid);
		
		
		$obj=$this->con->pdo_query_wparam($result_fields,$table,$query_params);
		if(!empty($obj)){
			$this->exists = true;
			$this->name=$obj[0]->name;
			
		}
		else{
			$this->exists = true;
			$this->name="Sorry, this user doesn't exist or may have been removed";
		}
		
		
	}
	function __tostring(){
		return $this->id;
	}
	function exists(){
		return $this->exists;
	}
	function id(){
		return $this->id;
	}
	function name(){
		return $this->name;
		
	}
	function pass(){
		return "No Password Revealed";
	}
	function jsonSerialize(){
		 return get_object_vars($this);
	}
	
	
} 
