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
	$limit=" 10 ";
	if(!empty($query=$_POST['page'];)){$page=$_POST['page'];}
	else $page=1;
	$response['filteredRecipes']=$app->recipeList($mode,$query,$limit,$page);
}
if(!empty($_POST['action'])){
	$userId=$_POST['userid'];
	$recipeId=$_POST['recipeid'];
	
	$response['starredRecipes']=$app->starredRecipeList($userId,$recipeId);
}

echo json_encode($response);