<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
require_once('simpletest/autorun.php');
require_once('../classes/user.php');

class TestOfUsers extends UnitTestCase {
	
	function testUserExistence(){
		$user = new User(2);
		
		$this->assertTrue($user->exists());
		$this->assertTrue(!empty($user->name()));
		$this->assertTrue(!empty($user->pass()));
	}
	
	
	
	
	
}