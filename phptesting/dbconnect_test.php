<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
require_once('simpletest/autorun.php');
require_once('../classes/dbconnect.php');

class TestOfDatabaseConnection extends UnitTestCase {
	private $connection;
	
	
	function testMySQLConnectionCreated(){
		$this->connection = new SQLconnection();
        $this->assertTrue($this->connection->established);
		$this->assertTrue(!empty($this->connection->pdo_con()));
		
	}
	
	function testMySQLQueryCanRun(){
		$sql="show tables;";
		$obj=$this->connection->pdo_query($sql);
		$this->assertTrue(!empty($obj));
	}
	function testMySQLParametrisedQueryCanRun(){
		//query params are organized so that the function knows how to build the where clause
		//it contains the condition column name, comparison operator and logical operator or "" for the last item
		
		$result_fields=array("name","id");
		$table="User";
		
		$name = new stdClass();
		$name->column="name";
		$name->compare="=";
		$name->logical="and";
		$name->value="Joe";
		
		$pass = new stdClass();
		$pass->column="pass";
		$pass->compare="=";
		$pass->logical="";
		$pass->value="Joe";
		
		$query_params=array($name,$pass);
		
		$obj=$this->connection->pdo_query_wparam($result_fields,$table,$query_params);
		$this->assertTrue(!empty($obj));
	}
	
	function testDatabaseInsertEntry(){
		$table="User";
		$fieldset=array("name","pass");
		$values=array();
		$name=new stdClass();
		$pass=new stdClass();
		$name->column="name";
		$name->value="John";
		$pass->column="pass";
		$pass->value="John";
		$row=array($name,$pass);
		array_push($values,$row);
		$result=$this->connection->pdo_insert($table,$fieldset,$values);
		
		$this->assertTrue($result);
	}
	function testDatabaseDeleteEntry(){
		$table="User";
		$conditions=array();
		$name=new stdClass();
		$pass=new stdClass();
		$name->column="name";
		$name->value="John";
		$name->compare="=";
		$name->logical="and";
		$pass->column="pass";
		$pass->value="John";
		$pass->compare="=";
		$pass->logical="";
		$conditions=array($name,$pass);
		
		$result=$this->connection->pdo_delete($table,$conditions);
		
		$this->assertTrue($result);
	}
	
}