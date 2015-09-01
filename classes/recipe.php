<?php
include_once 'dbconnect.php';
include_once 'ingredient.php';
				//have to implement json for ajax calls
class Recipe implements JsonSerializable {
	
	private $id;
	private $name;
	private $cookingTime;
	private $imageUrl;
	private $ingredients=array();
	private $con;
	private $exists=false;
	
	function __construct($id=0) {
		//constructor - takes dbconnect.php and stores SQLconnection object as personal database link
		$this->id=$id;
		
		$this->con=new SQLconnection();
		
		$result_fields=array("name","cookingTime","imageUrl");
		
		$table="Recipe";
		
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
			$this->cookingTime=$obj[0]->cookingTime;
			$this->imageUrl=$obj[0]->imageUrl;
			
		}
		else{
			$this->exists = false;
			$this->name="Sorry, this recipe doesn't exist or may have been removed";
			$this->cookingTime="N/A";
			$this->imageUrl="N/A";
		}
		$this->loadIngredients($this->id);
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
	function cookingTime(){
		return $this->cookingTime;
		
	}
	function imageUrl(){
		return $this->imageUrl;
		
	}
	function ingredients(){
		return $this->ingredients;
		
	}
	
	function loadIngredients($id){
		$result_fields=array("ingredient_id","quantity");
		$table="RecipeIngredient";
		$eid = new stdClass();
		$eid->column="recipe_id";
		$eid->compare="=";
		$eid->logical="";
		$eid->value=$id;
		$query_params=array($eid);
		$con1=new SQLconnection();
		$obj=$con1->pdo_query_wparam($result_fields,$table,$query_params);
		
		if(!empty($obj)){
			foreach($obj as $ing){
				
				$ingredient=new Ingredient($ing->ingredient_id);
				$ingredient->setQuantity($ing->quantity);
				array_push($this->ingredients,$ingredient);
			}
		}
		else{
			array_push($this->ingredients,"No Ingredients available");
		}
	}
	function jsonSerialize(){
		 return get_object_vars($this);
	}
} 