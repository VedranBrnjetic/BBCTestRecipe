<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
require_once('simpletest/autorun.php');
require_once('../classes/ingredient.php');

class TestOfIngredient extends UnitTestCase {
	
	function testIngredientExistence(){
		$ingredient = new Ingredient(7);
		
		$this->assertTrue($ingredient->exists());
		$this->assertTrue(!empty($ingredient->name()));
		$this->assertTrue(!empty($ingredient->unit()));
	}
	
	
	
	
	
}