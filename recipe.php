<?php
	//login script
	include 'classes/login.php';
	include_once 'classes/recipe.php';
	include_once 'classes/starredRecipe.php';
	$title="BBC Test | Recipe";
	$metaTitle="Recipe";
	$metaKeywords="Recipe";
	$metaDescription="Recipe";
	if(!empty($_GET['id']))$recipeId=$_GET['id'];
	else $recipeId=0;

	$recipe=new Recipe($recipeId);
	
	include_once 'parts/htmlHead.php';
	//let's login Joe
	$user = new User(1);
	$starredRecipe=new StarredRecipe($user->id());
	$star="fa-star-o";
	foreach($starredRecipe->recipes() as $recipe1) {
		if ($recipe->id()==$recipe1->id()){
			$star="fa-star";
		}
	}
	
	
?>
<body>
	<main id="main" data-user="<?php echo $user->id(); ?>" data-recipe="<?php echo $recipe->id(); ?>"></main>
    <!-- Navigation -->
    <a id="menu-toggle" href="#" class="btn btn-dark btn-lg toggle"><i class="fa fa-bars"></i></a>
    <nav id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <a id="menu-close" href="#" class="btn btn-light btn-lg pull-right toggle"><i class="fa fa-times"></i></a>
            <li class="sidebar-brand">
                <a href="/bbctest/"  onclick = $("#menu-close").click(); >myBBC Recipes</a>
            </li>
            
            
        </ul>
    </nav>
	
	 <!-- Recipe -->
    <!-- The circle icons use Font Awesome's stacked icon classes. For more information, visit http://fontawesome.io/examples/ -->
    

	
	<section id="services" role="main" class="services">
        <div class="container">
            <div class="row text-center">
                <div id="starredRecipes" class="col-xs-12 col-sm-12 col-md-2">
					
					<div class="starred-recipes" data-example-id="panel-without-body-with-table">
						<div class="panel panel-default">
						  <!-- Default panel contents -->
						  <div class="panel-heading">Your starred recipes</div>

						  <!-- Table -->
						  <?php if($starredRecipe->recipes()[0]->id()!=0){ ?>
						  <table class="table">
							<thead>
							  <tr>
								<th>Recipe</th>
								<th>Cooking time</th>							
							  </tr>
							</thead>
							<tbody>
						<?php foreach($starredRecipe->recipes() as $recipe1) {?>
							<tr>
								<td><a href="recipe.php?id=<?php echo $recipe1->id(); ?>"><?php echo $recipe1->name(); ?></a></td> 
								<td><?php echo $recipe1->cookingTime();?></td>
							</tr>
						<?php ;} ?>
							 </tbody>
						  </table>
						  <?php ;}
							else{ echo  "<p>Sorry, you don't currently have any starred recipes, get started by starring recipes you like</p>";}
						  ?>
					</div>
				  </div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-8">
				  <div class="thumbnail">
				  <?php if($recipe->exists()){?>
					<img id="recipe-photo" src="<?php echo "images/recipes/". $recipe->imageUrl(); ?>" title="<?php echo $recipe->name(); ?> photo" alt="<?php echo $recipe->name(); ?> photo">
				  <?php ;} ?>	
					  <div class="caption">
						<h1><?php echo $recipe->name(); ?></h1>
						<?php if($recipe->exists()){?>
						<hr/>
						<a id="toggle-star" href="#"><i id="star-icon" class="fa <?php echo $star;?> fa-2x text-primary"></i></p></a>
						<h3>Preparation time: <?php echo $recipe->cookingTime(); ?> minutes.</h3>
						<h3> Ingredients</h3>
						<?php foreach($recipe->ingredients() as $ingredient){ ?>
							<h4><?php echo  $ingredient->quantity() . " " .$ingredient->unitRep(). " " .  $ingredient->name() ?></h4>
						<?php };} ?>
						<p><a href="/bbctest/" class="btn btn-info btn-xs" role="button">Back to homepage</a></p>
						
					</div>
				  </div>
				</div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>

	
	
	
	
	
	
	
	<!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1 text-center">
                    <h4><strong>BBC Recipe</strong>
                    </h4>
                    <p>53A Plashet Road<br>London, E13 0QA</p>
                    <ul class="list-unstyled">
                        <li><i class="fa fa-phone fa-fw"></i> +44 7928 076 812</li>
                        <li><i class="fa fa-envelope-o fa-fw"></i>  <a href="mailto:vedran.brnjetic@gmail.com">vedran.brnjetic@gmail.com</a>
                        </li>
                    </ul>
                    <br>
                    <ul class="list-inline">
                        <li>
                            <a href="http://facebook.com/drvce"><i class="fa fa-facebook fa-fw fa-3x"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-linkedin fa-fw fa-3x"></i></a>
                        </li>
                    </ul>
                    <hr class="small">
                    <p class="text-muted">Copyright &copy; Vedran Brnjetic 2015, All images are under creative commons license and therefore free to use and reuse without attribution</p>
                </div>
            </div>
        </div>
    </footer>
	
	
	 <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/app.js"></script>

    <!-- Custom Theme JavaScript -->
    <script>
    // Closes the sidebar menu
    $("#menu-close").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });

    // Opens the sidebar menu
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });

    // Scrolls to the selected menu item on the page
    $(function() {
        $('a[href*=#]:not([href=#])').click(function() {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {

                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                    return false;
                }
            }
        });
    });
    </script>

</body>

</html>