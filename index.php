<?php
	//login script
	include 'classes/login.php';
	//include_once 'classes/starredRecipe.php';

	$title="BBC Test | Recipe Home";
	$metaTitle="Home";
	$metaKeywords="Recipe,BBC,stuff";
	$metaDescription="Recipe";
	
	
	include 'parts/htmlHead.php';
	
?>

<body>
	<main id="main" data-user="<?php echo $user->id(); ?>"></main>
    <!-- Navigation -->
    <a id="menu-toggle" href="#" class="btn btn-dark btn-lg toggle"><i class="fa fa-bars"></i></a>
    <nav id="sidebar-wrapper">
		
        <ul class="sidebar-nav">
            <a id="menu-close" href="#" class="btn btn-light btn-lg pull-right toggle"><i class="fa fa-times"></i></a>
            <li class="sidebar-brand">
                <a href="#top"  onclick = $("#menu-close").click(); >myBBC Recipes</a>
            </li>
            <li>
                <a href="#top" onclick = $("#menu-close").click(); >Home</a>
            </li>
            <li>
                <a href="#about" onclick = $("#menu-close").click(); >Recipes</a>
            </li>
            
        </ul>
    </nav>

    <!-- Header -->
    <header id="top" class="header">
        <div class="text-vertical-center">
           <div class="headings col-lg-6 col-lg-push-3 col-md-8 col-md-push-2 col-sm-12"> 
			<h1>BBC Recipe</h1>
            <h2>BBC Recipe book by Vedran Brnjetic</h2>
            <br>
            <a href="#about" class="btn btn-dark btn-lg">Find Out More</a>
		  </div>
        </div>
    </header>

    <!-- About -->
    <section id="about" class="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Welcome to our Recipe book, we are sure you are hungry for more</h2>
                    <p class="lead">Start browsing our recipes today!</p>
					<div class="row">
						<div class="col-lg-6 col-lg-push-3 col-md-8 col-md-push-2 col-sm-12">
							<div id="searchRecipes">
							  <div class="search-container col-lg-12">
								
									<div class="row">    
										<div class="col-xs-8 col-xs-push-2">
											<div class="input-group">
												<div class="input-group-btn search-panel">
													<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
														<span id="search_concept">Recipe name</span> <span class="caret"></span>
													</button>
													<ul class="dropdown-menu" role="menu">
													  <li><a href="#1">Recipe name</a></li>
													  <li><a href="#2">Ingredient name</a></li>
													  <li><a href="#3">Cooking time</a></li>
													</ul>
												</div>
												
													<input type="hidden" name="searchRecipes" value="1" id="search_param">         
													<input type="text" class="form-control" id="search_query" name="searchQuery" placeholder="Search term...">
													<span class="input-group-btn">
														<button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
													</span>
												
												
											</div>
										</div>
									</div>
									<div class="row" id="searchResults"></div>
									
								
							  </div>
							</div>
						</div>
					</div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>

    <!-- Recipes -->
    <!-- The circle icons use Font Awesome's stacked icon classes. For more information, visit http://fontawesome.io/examples/ -->
    <section id="services" class="services bg-primary">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-10 col-lg-offset-1">
                    <h2>Our featured recipes</h2>
                    <hr class="small">
																				<?php //RECIPE LIST?>                    
					<div id="recipe-list" class="row">
                       
                    </div>
                    <!-- /.row (nested) -->
					
                </div>
                <!-- /.col-lg-10 -->
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
