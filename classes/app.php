<?php

if(!empty($_POST['userid']))$userid=$_POST['userid'];
else $userid=1;


include_once 'application.php';

$app=new RecipeApp($userid);

$response['currentUser']=$app->currentUser()->jsonSerialize();
$response['recipes']=$app->recipeList();
if(!empty($_POST['searchRecipes'])){
	$mode=$_POST['searchRecipes'];
	
	$query=$_POST['searchQuery'];
	$response['filteredRecipes']=$app->recipeList($mode,$query);
}
if(!empty($_POST['action'])){
	$userId=$_POST['userid'];
	$recipeId=$_POST['recipeid'];
	
	$response['starredRecipes']=$app->starredRecipeList($userId,$recipeId);
}

echo json_encode($response);