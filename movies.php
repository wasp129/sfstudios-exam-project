<!DOCTYPE html>
<html>
	<?php 
		require_once 'header.php';
	?>
	<form class="movie_search" action="movies.php" method="POST">
		<input type="text" name="moviesearch" placeholder="Search for movies and tv-shows" autocomplete="off">
	</form>

	<div class="container-fluid">
		<div class="row search_results">

	<?php	 
		if (isset($_POST['moviesearch'])) {
			$ok = true;
			if (!isset($_POST['moviesearch'])) {
				$ok = false;
				echo "Please enter a valid search query";
			} else {
				$movie_title = "%{$_POST['moviesearch']}%";
			}

			if ($ok) {
				$sql = "SELECT title, year, img FROM movie WHERE title LIKE ? ORDER BY id DESC LIMIT 8";
				$stmt = $db->prepare($sql);
				$stmt->bind_param('s', $movie_title);
				$stmt->execute();
				$stmt->bind_result($title, $year, $img);
				while($stmt->fetch()) {
					echo "<div class='col-sm-4 col-xs-12 col-md-3'>
						<a href='movie-details.php?title=" . htmlentities($title) . "&year=" . htmlentities($year) . "'>
							<img class='img-responsive center-block' src='" . $img . "'>
							<p class='movie_title center-block'>" .htmlentities($title). "</p>
						</a>
					</div>";
    			}
			}
		} else {
			$sql = "SELECT title, year, img FROM movie ORDER BY id DESC LIMIT 8";
				$stmt = $db->prepare($sql);
				$stmt->execute();
				$stmt->bind_result($title, $year, $img);
				while($stmt->fetch()) {
					echo "<div class='col-sm-4 col-xs-12 col-md-3'>
						<a href='movie-details.php?title=" . htmlentities($title) . "&year=" . htmlentities($year) . "'>
							<img class='img-responsive center-block' src='" . $img . "'>
							<p class='movie_title center-block'>" .htmlentities($title). "</p>
						</a>
					</div>";
    			}

		}
		?>	 
				
			</div>
		</div>
		
		<?php  
			require_once 'footer.php';
		?>
</html>