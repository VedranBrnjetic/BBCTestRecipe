<?php
session_start();
include_once 'classes/dbconnect.php';
include_once 'classes/user.php';

if(!empty($_POST['user1']) && !empty($_POST['pass1'])){
	$result_fields=array("id");
	$name=$_POST['user1'];
	$pass=$_POST['pass1'];
	$con=new SQLconnection();
	$name = new stdClass();
	$name->column="name";
	$name->compare="=";
	$name->logical="and";
	$name->value=$name;
	$pass = new stdClass();
	$pass->column="pass";
	$pass->compare="=";
	$pass->logical="";
	$pass->value=$pass;
	$query_params=array($name,$pass);
	$obj=$con->pdo_query_wparam($result_fields,$table,$query_params);
			
	if(!empty ($obj->results[0])){
		$user=new User($obj->results[0]->id);
		session_regenerate_id();
		
	}
}
else{$user = new User(0);}