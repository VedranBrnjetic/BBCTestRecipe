<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
require_once('simpletest/autorun.php');
require_once('../classes/recipe.php');

class TestOfRecipes extends UnitTestCase {
	
	function testDontBreakIfRecipeNotExist(){
		$recipe = new Recipe(rand(-1,5));
		
		
		$this->assertTrue(!empty($recipe->name()));
		$this->assertTrue(!empty($recipe->imageUrl()));
		
	}
	function testIngredientListExists(){
		$recipe = new Recipe(rand(-1,5));
		
		$this->assertTrue(!empty($recipe->ingredients()));
	}
	
	
	
	
	
}