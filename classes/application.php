<?php
//database access
include_once realpath( dirname(__FILE__) ) . '/dbconnect.php';
//User class
include_once 'user.php';
//Ingredient class
include_once 'ingredient.php';
//Recipe class
include_once 'recipe.php';
//StarredRecipe class
include_once 'starredRecipe.php';


class RecipeApp{
	private $currentUser;
	private $htmlHead;
	private $htmlDocumentHeader;
	private $htmlDocumentMain;
	private $htmlDocumentFooter;
	private $htmlDocumentCssFiles;
	private $htmlDocumentJsFiles;
	private $recipes=array();
	private $starredRecipes=array();
	
	function __construct($user_id=1){
		$user=new User($user_id);
		if($user->exists())	$this->currentUser=$user;
		
		
	}
	
	function currentUser(){
		return $this->currentUser;
	}
	function loadRecipeList($var){
		//clear current list
		unset($this->recipes);
		//reinitialize list
		$this->recipes=array();
		$result_fields=$var->result_fields;
		$table=$var->table;
		
		$query_params=array($var);
		$con1=new SQLconnection();
		$obj=$con1->pdo_query_wparam($result_fields,$table,$query_params);
		//if there are results
		if(!empty($obj)){
			
			
			foreach($obj as $rec){
				//add raw recipes into list
				$recipe=new Recipe($rec->id);
				
				array_push($this->recipes,$recipe);
			}
				//remove duplicates from the list
				$temp_uids=array();
				$unique_results = array();
				
				foreach($this->recipes as $recipe)
				{  if(!in_array($recipe->id(),$temp_uids))
				   { $temp_uids[]=$recipe->id();
					  $unique_results[]=$recipe;
				   }
				}
				$temp = array();
				foreach($unique_results as $recipe){
					$temp[] = $recipe->jsonSerialize();
				}
				$this->recipes = $temp;
				unset($temp_uids, $unique_results);  
				//prepare the recipes for cooking (jsonSerialize)
				
				
		}
	}
	function recipeList($searchMode=0,$value=""){
		
		//searchMode 0 default=> load all, 1=>recipe name,2=>ingredient name,3=>cooking time
		if($searchMode>0){
			$tables=array(
			"1"=>array(
				"table"=>"Recipe",
				"column"=>"name",
				"result"=>array("id")),
			"2"=>array(
				"table"=>"Ingredient a inner join RecipeIngredient b on a.id=b.ingredient_id",
				"column"=>"name",
				"result"=>array("recipe_id as id")),
			"3"=>array(
				"table"=>"Recipe",
				"column"=>"cookingTime",
				"result"=>array("id")));
			$obj=new stdClass();
			$obj->table=$tables[$searchMode]["table"];
			$obj->column=$tables[$searchMode]["column"];
			$obj->compare="like";
			$obj->logical="";
			$obj->value="%".$value."%";
			if($searchMode==3){$obj->compare="<=";$obj->value=$value;}
			$obj->result_fields=$tables[$searchMode]["result"];
			
		}
		else{
			$obj = new stdClass();
			$obj->column="id";
			$obj->compare=">";
			$obj->logical="";
			$obj->value=0;
			$obj->table="Recipe";
			$obj->result_fields=array("id");
		}
		//print_r($obj);
		$this->loadRecipeList($obj);
		//$this->recipes=array_unique($this->recipes,SORT_REGULAR);
		
		
		
		return $this->recipes;
	}
	
	function starredRecipeList($userId,$recipeId){
		$recipe=new Recipe($recipeId);
		$user=new User($userId);
		$starredRecipe = new StarredRecipe($userId);
		$isStarred=false;
			foreach ($starredRecipe->recipes() as $recipe1){
				if ($recipe->id()==$recipe1->id()){
				$isStarred=true;
			}
		if($isStarred){
			$starredRecipe->unstarRecipe($userId,$recipeId);
		}
		else 
			{
				
				$starredRecipe->starRecipe($userId,$recipeId);
			}
		}
		return $starredRecipe->recipes();
	}
	
}