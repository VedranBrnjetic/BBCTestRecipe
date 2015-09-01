<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
require_once('simpletest/autorun.php');
require_once('../classes/application.php');

class TestOfApplication extends UnitTestCase {
	function testDocumentReturn(){
		$app = new RecipeApp(1);
		$this->assertTrue(!empty($app->htmlDocument()));
	}
}