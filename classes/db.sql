drop database if exists bbctest;
create database bbctest;

use bbctest;
drop table if exists User;
create table User(
	id int not null primary key auto_increment,
	name nvarchar(50) not null,
	pass nvarchar(32)
);

drop table if exists Recipe;
create table Recipe(
	id int not null primary key auto_increment,
	name int not null,
	cookingTime int not null,
	imageUrl nvarchar(200) null
);

drop table if exists Ingredient;
create table Ingredient(
	id int not null primary key auto_increment,
	name int not null,
	unit nvarchar(20) not null,
	unitRep nvarchar(20) not null
);
	
drop table if exists Starred;
create table Starred(
	user_id int not null,
	recipe_id int not null
);

alter table Starred add 
	foreign key(user_id)
	references  User(id);
	
alter table Starred add 
	foreign key(recipe_id)
	references  Recipe(id);
	
drop table if exists RecipeIngredient;
create table RecipeIngredient(
	recipe_id int not null,
	ingredient_id int not null,
	quantity int not null
);

alter table RecipeIngredient add 
	foreign key(recipe_id)
	references  Recipe(id);
	
alter table RecipeIngredient add 
	foreign key(ingredient_id)
	references  Ingredient(id);
	
	