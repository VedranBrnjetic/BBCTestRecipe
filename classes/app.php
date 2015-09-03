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
//	echo $query;
	$limit=" 10 ";
	if(!empty($_POST['page'])){$page=$_POST['page'];}
	else $page=1;
	$response['filteredRecipes']=$app->recipeList($mode,$query,$limit,$page);
	$response['recipeCount']=$app->recipeCount();
}
if(!empty($_POST['action'])){
	$userId=$_POST['userid'];
	$recipeId=$_POST['recipeid'];
	if(!empty($_POST['page']))$page=$_POST['page'];
	else $page=1;
	$response['starredRecipes']=$app->starredRecipeList($userId,$recipeId,$page,true);
}

echo json_encode($response);
