<?php
include_once 'dbconnect.php';
include_once 'user.php';
include_once 'recipe.php';

class StarredRecipe extends User {
	private $recipes=array();
	private $isStarred=false;
	function __construct($userid=0,$recipeid=0) {
		//constructor - takes dbconnect.php and stores SQLconnection object as personal database link
		$this->con=new SQLconnection();
		$id=$userid;
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
			$this->pass=$obj[0]->pass;
			$this->isStarred=true;
		}
		else{
			$this->exists = true;
			$this->name="Sorry, this user doesn't exist or may have been removed";
		}
		$this->loadRecipes($this->id);
	}
	function __tostring(){
		return $this->id;
	}
	function loadRecipes($userId){
		$result_fields=array("recipe_id");
		$table="Starred";
		$eid = new stdClass();
		$eid->column="user_id";
		$eid->compare="=";
		$eid->logical="";
		$eid->value=$userId;
		$query_params=array($eid);
		$con1=new SQLconnection();
		$obj=$con1->pdo_query_wparam($result_fields,$table,$query_params);
		
		if(!empty($obj)){
			foreach($obj as $rec){
				$recipe=new Recipe($rec->recipe_id);
				array_push($this->recipes,$recipe);
			}
		}
		else{
			array_push($this->recipes,new Recipe(0));
		}
	}
	
	function recipes(){
		return $this->recipes;
	}
	
	function starRecipe($usr,$recipe_id){
		
		$con1=new SQLconnection();
		$user=new User($usr);
		$recipe=new Recipe($recipe_id);
		if($recipe->exists()){
			//$table="Starred";
			//$fieldset=array("user_id","recipe_id");
			//$values=array();
			
			//$user_id=new stdClass();
			//$user_id->column="user_id";
			//$user_id->value=$user->id();
			
			//$recipe_id1=new stdClass();
			//$recipe_id1->column="recipe_id";
			//$recipe_id1->value=$recipe->id();
			
			//$row=array($user_id,$recipe_id1);
			//array_push($values,$row);
			//print_r($row);
			try{
				if(!($usr= (int)$usr))return;
				if(!($recipe_id=(int)$recipe_id))return;

				$con1->pdo_query(" insert into Starred(user_id,recipe_id)values($usr,$recipe_id);");
			}
			catch(PDOException $Exception){
				print_r ($Exception);
				$res=$Exception;
				return $res;
			}
			
		}
		unset($this->recipes);
		$this->recipes=array();
		$this->loadRecipes($user->id());
	}
	function unstarRecipe($usr,$recipe_id){
		$con1=new SQLconnection();
		
		$user=new User($usr);
		$recipe=new Recipe($recipe_id);
		
		if($recipe->exists()){
		//$table="Starred";
		
		//$conditions=array();
		
		
		//$user_id=new stdClass();
		//$user_id->column="user_id";
		//$user_id->value=$user->id();
		//$user_id->compare="=";
		//$user_id->logical="and";
		
		//$recipe_id1=new stdClass();
		//$recipe_id1->column="recipe_id";
		//$recipe_id1->value=$recipe->id();
		//$recipe_id1->compare="=";
		//$recipe_id1->logical="";
		//$conditions=array($user_id,$recipe_id1);
		
			try{
				 if(!($usr= (int)$usr))return;
                 if(!($recipe_id=(int)$recipe_id))return;

                                $con1->pdo_query(" delete from Starred where user_id  = $usr and recipe_id=$recipe_id;");

				//$con1->pdo_delete($table,$conditions);
			}
			catch(PDOException $Exception){
				print_r ($Exception);
				$res=$Exception;
				return $res;
			}
			
		}
		unset($this->recipes);
		$this->recipes=array();
		$this->loadRecipes($user->id());
	}
}
