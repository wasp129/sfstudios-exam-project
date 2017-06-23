<?php
	session_start();
	require_once 'db_con.php';
	$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
		<?php

			if ($current_page == 'index.php') {
				echo "SF-Studios - Film distribution, movies, news";
			};

			if ($current_page == 'news.php') {
				echo "SF-Studios - Latest movie news";
			};

			if ($current_page == 'movies.php') {
				echo "SF-Studios - Find details about SF movies";
			};

			if ($current_page == 'movie-details.php') {
				if (isset($_GET['title'])) {
					echo "SF-Studios - " . $_GET['title'];
				}
			}

			if ($current_page == 'about.php') {
				echo "SF-Studios - About us";
			};

			if ($current_page == 'jobs.php') {
				echo "SF-Studios - Available jobs";
			};
			
		?>
			
		</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="
		<?php

			if ($current_page == 'index.php') {
				echo "SF Studios is a Danish film distribution and production company. We also deliver daily film news and events.";
			};

			if ($current_page == 'news.php') {
				echo "Find all the latest news about films, actors, directors and entertainment, straight from Hollywood";
			};

			if ($current_page == 'movies.php') {
				echo "Find all the latest information about your favorite films.";
			};

			if ($current_page == 'movie-details.php') {
				if (isset($_GET['title'])) {
					echo "Find information about " . $_GET['title'];
				}
			}

			if ($current_page == 'about.php') {
				echo "SF Studios was founded in 1917 in Sweden, and have since delivered high quality entertainment to the scandinavian people";
			};

			if ($current_page == 'jobs.php') {
				echo "Find all the job postings we currently have available";
			};
			
		?>

		">
		<script type="text/javascript" src="libs/jquery/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="libs/bootstrap/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="libs/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/fonts/font-awesome/css/font-awesome.min.css">
		<!-- Ekko-lightbox lånt fra http://ashleydw.github.io/lightbox/#videos-gallery -->
		<script type="text/javascript" src="assets/plugins/lightbox-master/dist/ekko-lightbox.min.js"></script>
		<link rel="stylesheet" href="assets/plugins/lightbox-master/dist/ekko-lightbox.min.css">
		<link rel="stylesheet" href="assets/css/stylesheet.css">
	</head>
	<body>
		<!-- Navigationsbar start -->
		<nav class="nav-bar">
			<a href="index.php"><img class="logo" src="assets/img/logo.png"></a>
			<a class="nav-link <?php if ($current_page == 'index.php') { echo "active";} ?>" href="index.php">Home</a>
			<a class="nav-link <?php if ($current_page == 'news.php') { echo "active";} ?>" href="news.php?page=1">News</a>
			<a class="nav-link <?php if ($current_page == 'movies.php' || $current_page == 'movie-details.php' || $current_page == 'movies-admin.php' || $current_page == 'movie-edit.php') { echo "active";} ?>" href="movies.php">Our films</a>
			<a class="nav-link  <?php if ($current_page == 'about.php') { echo "active";} ?>" href="about.php">About us</a>
			<a class="nav-link <?php if ($current_page == 'jobs.php') { echo "active";} ?>" href="jobs.php">Jobs</a>
			<a class="nav-link <?php if ($current_page == 'press.php' || $current_page == 'press-material.php' ) { echo "active";} ?>" href="press.php">Press</a>
			<div class="top-icons">
				<div class="search">
					<i class="fa fa-search fa-2x" aria-hidden="true"></i>
				</div>
				<div class="user">
					<?php
						if (isset($_SESSION['isAdmin']) || isset($_SESSION['c_avatar'])) {
							echo '<img class="avatar" src="' . $_SESSION['c_avatar'] . '">';
						} else {
							echo '<i class="fa fa-user-circle-o fa-2x" aria-hidden="true"></i>';
						}
					?>		
				</div>
			</div>

			<div class="burger-menu">
				<div class="bar-top"></div>
				<div class="bar-mid"></div>
				<div class="bar-bottom"></div>
			</div>

			<div class="search_bar_main">
				<form action="movies.php" method="POST">
					<input name="moviesearch" type="text" placeholder="Search for movies, tv-series and more">
				</form>	
			</div>
		</nav>

		<div class="user_dropdown">
			<ul>
				<?php  
					if (!isset($_SESSION['isAdmin'])) {
						echo '<li class="login"><a href="login.php">Log in</a></li>';
					} else {
						if ($_SESSION['isAdmin'] = 1) {

							echo '<li class="logout"><a href="logout.php">Log out</a></li><li class="adduser"><a href="signup.php">Add new user</a></li><li class="content-management"><a href="movies-admin.php">Content-management</a></li>';
						}

						if ($_SESSION['isAdmin'] = 0) {
							echo '<li class="logout"><a href="logout.php">Log out</a></li>';
						}
					}
				?>
			</ul>
		</div>

		<div class="side-menu">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="news.php?page=1">News</a></li>
				<li><a href="movies.php">Our films</a></li>
				<li><a href="#">About us</a></li>
				<li><a href="#">Jobs</a></li>
				<li><a href="press.php">Press</a></li>
				<?php  
					if (!isset($_SESSION['isAdmin'])) {
						echo '<li class="login"><a href="login.php">Log in</a></li>';
					} else {
						if ($_SESSION['isAdmin'] = 1) {
							echo '<li class="logout"><a href="logout.php">Log out</a></li><li class="adduser"><a href="signup.php">Add new user</a></li>';
						}

						if ($_SESSION['isAdmin'] = 0) {
							echo '<li class="logout"><a href="logout.php">Log out</a></li>';
						}
					}
				?>
			</ul>	
		</div>