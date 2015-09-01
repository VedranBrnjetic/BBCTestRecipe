
$(document).ready(function(){
	/*Initial request - gets current user from app and displays the name */
	$.ajax({
		url: "classes/app.php",
		type: "POST",
		data: {userid: 1}	
		/*here is the data sent to chat server*/
	})
	.done(function(data){
		obj=jQuery.parseJSON(data);
		//$("#main").html('<h4>Hello, '+obj['currentUser']['name']+'!</h4>');
		var recipes=obj['recipes'];
		/* Load recipes into the oven */
		var recipesHtml='';
			jQuery.each(recipes,function(index,value){
				recipesHtml=recipesHtml+
						'<div class="col-md-4 col-sm-6">'+
                            '<div title="Cooking time:'+value['cookingTime']+'minutes" class="service-item">'+
                                '<span class="fa-stack fa-4x">'+
                                '<i class="fa fa-circle fa-stack-2x"></i>'+
                                '<i class="fa fa-cutlery fa-stack-1x text-primary"></i></span>'+
                                '<h4><strong>'+value['name']+'</strong></h4>'+
                                '<p>'+value['ingredients'][0]['name']+'</p>'+
                                '<p>'+value['ingredients'][1]['name']+'</p>'+
                                '<p>'+value['ingredients'][2]['name']+'</p>'+
                                '<a href="recipe.php?id='+value['id']+'" class="btn btn-light" data>View Details</a>'+
                            '</div>'+
                        '</div>';
			});
		$("#recipe-list").html(recipesHtml);
	});
	
	$('.search-panel .dropdown-menu').find('a').click(function(e) {
		e.preventDefault();
		var param = $(this).attr("href").replace("#","");
		var concept = $(this).text();
		$('.search-panel span#search_concept').text(concept);
		$('.input-group #search_param').val(param);
	});
	
	
	/*                     ######                  FILTERING   */
	
	var filterRecipes=function(){
		var mode=$("#search_param").val();
		var query=$("#search_query").val();
		$.ajax({
			url: "classes/app.php",
			type: "POST",
			data: {userid: 1,searchRecipes: mode,searchQuery: query}	
		/*here is the data sent to chat server*/
		})
		.done(function(data){
			obj=jQuery.parseJSON(data);
			
			var recipes=obj['filteredRecipes'];
			if(recipes.length<1){
				html='<h4><strong>Sorry, we currently have no recipes for you.</strong></h4>';
				$("#searchResults").html(html);
				return;
			}
//filteredRecipes
			var html='<div class="filtered-recipes" data-example-id="panel-without-body-with-table">'+
'    <div class="panel panel-default">'+
'      <!-- Default panel contents -->'+
'      <div class="panel-heading">Found recipes</div>'+
'      <!-- Table -->'+
'      <table class="table">'+
'        <thead>'+
'          <tr>'+
'            <th>Recipe</th>'+
'            <th>Cooking time</th>'+
'            <th>Main ingredients</th>'+
'          </tr>'+
'        </thead>'+
'        <tbody>';
//actual recipes
			jQuery.each(recipes,function(index,value){
				html=html+
				'          <tr>'+
'            <td><a href="recipe.php?id='+value['id']+'">'+value['name']+'</a></td>'+
'            <td>'+value['cookingTime']+'</td>'+
'            <td>'+value['ingredients'][0]['name']+', '+value['ingredients'][1]['name']+', '+value['ingredients'][2]['name']+'</td>'+
'          </tr>';
			})
//close tags
			html=html+
'          </tr>'+
'        </tbody>'+
'      </table>'+
'    </div>'+
'  </div>';
	$("#searchResults").html(html);
		})
	};
	//search function
	$( "#search_query" ).keydown(function( event ) { /* to work on pressing the enter key*/
		if ( event.which == 13 ) {
		event.preventDefault();
		if($("#search_query").val().length<2) return; //no search less than 3 characters
		filterRecipes();
		}
	});
	$(".input-group-btn").click(function(){
		if($("#search_query").val().length<2) return; //no search less than 3 characters
		filterRecipes();
		
	});
	//star recipes
	$("#toggle-star").mouseover(function(){
		if ($("#star-icon").hasClass("fa-star")){
			$("#star-icon").removeClass("fa-star");
			$("#star-icon").addClass("fa-star-o");
		}
		else {
			$("#star-icon").removeClass("fa-star-o");
			$("#star-icon").addClass("fa-star");
		}
	});
	$("#toggle-star").mouseout(function(){
		if ($("#star-icon").hasClass("fa-star")){
			$("#star-icon").removeClass("fa-star");
			$("#star-icon").addClass("fa-star-o");
		}
		else {
			$("#star-icon").removeClass("fa-star-o");
			$("#star-icon").addClass("fa-star");
		}
	});

	$("#toggle-star").click(function(){
		$.ajax({
			url: "classes/app.php",
			type: "POST",
			data: {action: 'starrecipe', userid: $("#main").attr("data-user"), recipeid: $("#main").attr("data-recipe")}	
		/*here is the data sent to chat server*/
		})
		.done(function(data){
			obj=jQuery.parseJSON(data);
			
			var recipes=obj['starredRecipes'];
			if(recipes.length<1){
				html="<p><strong>Sorry, you don't currently have any starred recipes, get started by starring recipes you like</strong></p>";
				$("#starred-recipes").html(html);
				return;
			}
//filteredRecipes
			var html='    <div class="panel panel-default">'+
'      <!-- Default panel contents -->'+
'      <div class="panel-heading">Found recipes</div>'+
'      <!-- Table -->'+
'      <table class="table">'+
'        <thead>'+
'          <tr>'+
'            <th>Recipe</th>'+
'            <th>Cooking time</th>'+
'          </tr>'+
'        </thead>'+
'        <tbody>';
//actual recipes
			jQuery.each(recipes,function(index,value){
				html=html+
				'          <tr>'+
'            <td><a href="recipe.php?id='+value['id']+'">'+value['name']+'</a></td>'+
'            <td>'+value['cookingTime']+'</td>'+
'          </tr>';
			})
//close tags
			html=html+
'          </tr>'+
'        </tbody>'+
'      </table>'+
'    </div>';
	$("#starred-recipes").html(html);
	document.location.reload();	
		});
	})
	
	
});


 