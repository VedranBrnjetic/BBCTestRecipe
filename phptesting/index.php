<?php
require_once('simpletest/autorun.php');

class AllTests extends TestSuite {
    function AllTests() {
        $this->TestSuite('All tests');
        $this->addFile('dbconnect_test.php');
		$this->addFile('user_test.php');
        $this->addFile('ingredient_test.php');
		$this->addFile('recipe_test.php');
		$this->addFile('starredRecipe_test.php');
		
        
    }
}
?>