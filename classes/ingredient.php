<?php
include_once 'dbconnect.php';

class Ingredient implements JsonSerializable{
	
	private $quantity;
	private $id;
	private $name;
	private $unit;
	private $unitRep;
	private $con;
	private $exists=false;
	
	function __construct($id=0) {
		//constructor - takes dbconnect.php and stores SQLconnection object as personal database link
		$this->con=new SQLconnection();
		
		$result_fields=array("name","unit","unitRep");
		
		$table="Ingredient";
		
		$eid = new stdClass();
		$eid->column="id";
		$eid->compare="=";
		$eid->logical="";
		$eid->value=$id;
		$query_params=array($eid);
		
		
		$obj=$this->con->pdo_query_wparam($result_fields,$table,$query_params);
		if(!empty($obj)){
			$this->exists = true;
			$this->name=$obj->results[0]->name;
			$this->unit=$obj->results[0]->unit;
			$this->unitRep=$obj->results[0]->unitRep;
		}
		else{
			$this->exists = false;
			$this->name="Sorry, this recipe doesn't exist or may have been removed";
			$this->unit="N/A";
			$this->unitRep="N/A";
			
		}
	}
	function __tostring(){
		return $this->id;
	}
	function exists(){
		return $this->exists;
	}
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}
	function quantity(){
		return $this->quantity;
	}
	function name(){
		return $this->name;
		
	}
	function unit(){
		return $this->unit;
		
	}
	function unitRep(){
		return $this->unitRep;
		
	}
	function jsonSerialize(){
		 return get_object_vars($this);
	}
} 