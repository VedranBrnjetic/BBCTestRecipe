<?php
include '../classes/starredRecipe.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
$star=new StarredRecipe(1);
print_r $star;