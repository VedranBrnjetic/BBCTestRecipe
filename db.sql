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
	name nvarchar(250) not null,
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
	
insert into User(name,pass)values('Joe','Joe');

insert into Recipe(name,cookingTime,imageUrl)values
('Lemon Chicken',30,'lemon_chicken.jpg'),
('Beef Stroganoff',30,'beef_stroganoff.jpg'),
('Caesar Salad',25,'caesar_salad.jpg'); 

insert into Ingredient(name,unit,unitRep) values
('Chicken Breasts','piece','x'),
('Thyme','table spoon','tsp'),
('Lemon','piece','x'),
('Beef','gram','g'),
('Mustard','gram','g'),
('Mushrooms','gram','g'),
('Lettuce','piece','x'),
('Croutons','gram','g');

update Ingredient set name='Chicken Breasts' where id=1;
update Ingredient set name='Thyme' where id=2;
update Ingredient set name='Lemon' where id=3;
update Ingredient set name='Beef' where id=5;
update Ingredient set name='Mustard' where id=6;
update Ingredient set name='Mushrooms' where id=7;
update Ingredient set name='Lettuce' where id=8;
update Ingredient set name='Croutons' where id=9;