<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
require_once('simpletest/autorun.php');
require_once('../classes/starredRecipe.php');

class TestOfStarredRecipes extends UnitTestCase {
	
	function testIfUserExists(){
		$user = new User(rand(-1,5));
		
		
		$this->assertTrue(!empty($user->id()));
		$this->assertTrue(!empty($user->name()));
		
	}
	function testIfRecipeExists(){
		$recipe = new Recipe(rand(-1,5));
		
		
		$this->assertTrue(!empty($recipe->name()));
		$this->assertTrue(!empty($recipe->imageUrl()));
		
	}
	function testIfObjectRetunsListOfRecipes(){
		$recipe = new Recipe(1);
		$user = new User(1);
		$starredRecipe=new StarredRecipe($user->id(),$recipe->id());
		$this->assertTrue(!empty($starredRecipe->recipes()));
		
	}
	
	
	
	
	
	
}