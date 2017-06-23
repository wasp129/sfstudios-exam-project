<?php
	require_once 'header.php';
	if (isset($_GET['title'])) {
		$title = $_GET['title'];
		$year = $_GET['year'];
	} 
?>

<script type='text/javascript'>
	$(function() {
		$.ajax({
			url: 'http://www.omdbapi.com/?t=<?php echo $title ?>&y=<?php echo $year; ?>&plot=full&apikey=744f282',
			dataType: 'json',
			success: function(data) {
				console.log(data);
				document.getElementsByClassName("movie_plot")[0].innerHTML = data.Plot;
				document.getElementsByClassName("movie_headline")[0].innerHTML = data.Title + ' ' + '(' + data.Year + ')';
				document.getElementsByClassName("movie_director")[0].innerHTML = data.Director;
				document.getElementsByClassName("movie_cast")[0].innerHTML = data.Actors;
				document.getElementsByClassName("movie_genre")[0].innerHTML = data.Genre;
				document.getElementsByClassName("movie_awards")[0].innerHTML = data.Awards;
				document.getElementsByClassName("movie_writer")[0].innerHTML = data.Writer;
				document.getElementsByClassName("movie_writer")[0].innerHTML = data.Writer;
				document.getElementsByClassName("movie_rating")[0].innerHTML = data.imdbRating + "/10";
				document.getElementsByClassName("movie_release")[0].innerHTML = data.Released;
			}
		});
	});
</script>

<?php
	$sql = "SELECT img FROM movie WHERE title = ?";
	$stmt = $db->prepare($sql);
	$stmt->bind_param('s', $title);
	$stmt->execute();
	$stmt->bind_result($img);
	if ($stmt->fetch()) {
		$img = $img;
	}
?>

<div class="container-fluid">
	<div class="row movie_details">
		<div class="col-md-4 col-sm-4 col-xs-6">
			<img class="movie_details_img img-responsive" src="<?php echo $img ?>">
		</div>
		<div class="col-md-8 col-sm-8">
			<h1 class="movie_headline"></h1>
			<img src="assets/img/imdb_logo.png"> <span class="movie_rating"></span>
			<p class="movie_plot"></p>
			<h5 class="movie_headline_small">Director: <span class="movie_director"></span></h5>
			<h5 class="movie_headline_small">Writer: <span class="movie_writer"></span></h5>
			<h5 class="movie_headline_small">Cast: <span class="movie_cast"></span></h5>
			<h5 class="movie_headline_small">Genre: <span class="movie_genre"></span></h5>
			<h5 class="movie_headline_small">Awards: <span class="movie_awards"></span></h5>
			<h5 class="movie_headline_small">Release date: <span class="movie_release"></span></h5>
		</div>
	</div>
</div>

<?php require_once 'footer.php' ?>
</html>