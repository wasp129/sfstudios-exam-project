<!DOCTYPE html>
<html>
	<?php
		require_once 'header.php';
	?>
		<!-- Navigationsbar slut -->

		<!-- Slider start - fundet på https://www.w3schools.com/bootstrap/bootstrap_carousel.asp -->
		<div class="container-fluid">
			<div class="row slider">
				<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="15000">
				  <!-- Indicators -->
				  <ol class="carousel-indicators">
				   	<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				    <li data-target="#myCarousel" data-slide-to="1"></li>
				    <li data-target="#myCarousel" data-slide-to="2"></li>
				  </ol>
				  <div class="carousel-inner">

				  <?php
				  	$sql = "SELECT headline, subtitle, main_text, img_hero, id FROM articles WHERE article_role = 1 ORDER BY id DESC LIMIT 3";
				  	$stmt = $db->prepare($sql);
				  	$stmt->execute();
				  	$stmt->bind_result($headline, $subtitle, $main_text, $img_hero, $id);
				  	$active = 'active';
				  	while($stmt->fetch()) {
				  		$main_text_short = substr($main_text, 0, 404)."...";
				  		echo '<div class="item ' . $active . '">
				      <img src="' . $img_hero . '">
				      <div class="overlay"></div>
				      <div class="news_text_wrapper">
				      	<h2 class="slider_headline">' . $headline . '<span class="subtitle">' .' '. $subtitle . '</span></h2>
				      	<p class="news_text">' . $main_text_short . '</p>
				      	<a class="read_more" href="article.php?id=' . $id . '">Read more</a>
				      </div>
				    </div>';
				    $active = '';
				  	}
				  ?>
				  </div>

				  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
				    <span class="glyphicon glyphicon-chevron-left"></span>
				    <span class="sr-only">Previous</span>
				  </a>
				  <a class="right carousel-control" href="#myCarousel" data-slide="next">
				    <span class="glyphicon glyphicon-chevron-right"></span>
				    <span class="sr-only">Next</span>
				  </a>
				</div>
			</div>
			<!-- Slider slut -->
			<!-- Featured articles start -->
			<div class="row">
				<div class="col-md-12">
					<h2 class="headline">Featured articles</h2>
				</div>
			</div>

			<div class="row">
				<?php
				  	$sql = "SELECT headline, subtitle, img_big, id FROM articles WHERE article_role = 2 ORDER BY id DESC LIMIT 1";
				  	$stmt = $db->prepare($sql);
				  	$stmt->execute();
				  	$stmt->bind_result($headline, $subtitle, $img_big, $id);
				  	while($stmt->fetch()) {
				  		echo '<a href="article.php?id=' . $id . '"><div class="col-md-12">
					<img class="img-responsive" src="' . $img_big . '">
					<div class="news_main_text">
						<p><span class="headline_highlight">' . $headline . '</span><br>' . $subtitle . '</p>
					</div>
				</div></a>';
				  	}
				?>

				<?php
				  	$sql = "SELECT headline, subtitle, img_small, id FROM articles WHERE article_role = 3 ORDER BY id DESC LIMIT 2";
				  	$stmt = $db->prepare($sql);
				  	$stmt->execute();
				  	$stmt->bind_result($headline, $subtitle, $img_small, $id);
				?>
			
				<?php while ($stmt->fetch()): ?>
					<a href="article.php?id=<?php echo $id; ?>">
						<div class="col-md-6 col-sm-12 news_small">
							<img class="img-responsive" src="<?php echo $img_small; ?>">
							<div class="news_small_text">
								<p><span style="color: #df134c; font-family: 'raleway-bold'"><?php echo $headline; ?></span><br><?php echo $subtitle; ?></p>
							</div>
						</div>
					</a>
				<?php endwhile; ?>
			</div>
			<!-- Featured articles slut -->

			<!-- Sign-up ribbon start -->
			<?php
				if (isset($_POST['signup'])) {
					if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
						$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
						$email = $db->real_escape_string($email);

						$sql = "INSERT INTO newsletter (email) VALUES (?)";
						$stmt = $db->prepare($sql);
						$stmt->bind_param('s', $email);
						$stmt->execute();
						$success = "<p style='color: white;'>Thanks! We'll be in touch.</p>";
					} else {
						$fail = "<p style='color: white;'>Did you remember to add a valid email?</p>";
					}
				}
			?>
			<div class="row">
				<div class="col-md-12 sign_up_ribbon">
					<h2>Stay in the loop. <span style="color: #414141">Sign up for our newsletter.</span></h2>
					<form method="POST" action="index.php">
						<input class="email_input" type="email" name="email" placeholder="Email:"><br>
						<input type="submit" name="signup" value="Sign me up!">
						<?php echo $success; ?>
						<?php echo $fail; ?>
					</form>
				</div>
			</div>
			<!-- Sign-up ribbon slut -->

			<!-- In theaters now start -->
			<div class="row">
				<div class="col-md-12">
					<h2 class="headline">In theaters now</h2>
				</div>
			</div>
			<div class="row">
				<?php
					$sql = "SELECT title, year, img FROM movie WHERE in_theaters = 1 ORDER BY id DESC LIMIT 4";
					$stmt = $db->prepare($sql);
					$stmt->execute();
					$stmt->bind_result($title, $year, $img);
				?>

				<?php while ($stmt->fetch()): ?>
					<a href="movie-details.php?title=<?php echo $title; ?>&year=<?php echo $year; ?>">
						<div class="col-md-3 in_theater_wrapper col-sm-6">
							<img class="in_theater_movie center-block" src="<?php echo $img ?>">
							<p class="film_headline center-block"><?php echo $title ?></p>
							<p class="film_description center-block"></p>
						</div>
					</a>
				<?php endwhile?>	
				
			</div>
			<!-- In theaters now slut -->

			<!-- About short start -->
			<div class="row">
				<div class="col-md-12 about_short_hero">
					<img class="img-responsive" src="assets/img/about_short_hero.jpg">
					<div class="about_short_text">
						<h2>We're movie lovers. <span style="color: #df134c">Just like you.</span></h2>
						<p class="about_main_text">At SF Studios we believe that movies are a powerful tool, that allows us to understand hopes, aspirations, dreams and fears.<br><br> We’re more than 60 dedicated film-geeks who work every day, to deliver powerful stories to everyone.</p>
						<div class="learn_more_button">
							<p>Learn more about us</p>
						</div>
					</div>
				</div>
			</div>
			<!-- About short slut -->

			<!-- Get in touch start -->

			<?php
				if (isset($_POST['contact_submit'])) {
					$ok = true;

					if (!isset($_POST['contact_name'])) {
						$ok = false;
						$error_msg_name = "Did you remember to add a name?";
					} else {
						$contact_name = $_POST['contact_name'];
					}

					if (!isset($_POST['contact_email'])) {
						$ok = false;
						$error_msg_email = "Did you remember to add an email?";
					} else {
						$contact_email = $_POST['contact_email'];
					}

					if (!isset($_POST['contact_message'])) {
						$ok = false;
						$error_msg_message = "Did you remember to add a message?";
					} else {
						$contact_message = $_POST['contact_message'];
					}

					if ($ok) {
						$adminEmail = "andreasschultz@hotmail.com";
						mail($adminEmail, "Email", $contact_message, "From:" . $contact_email);
						$contact_success = "Thank you. We'll be in touch!";
					} else {
						$err = "Something went wrong. Try again.";
					}
				}
			?>
			<div class="row">
				<div class="col-md-12">
					<h2 class="headline">Get in touch</h2>
				</div>	
			</div>

			<div class="row contact">
				<div class="contact_headline">
					<h2>We'd love to hear from you. <span class="headline_bold">Fill out the form below.</span></h2>
				</div>
				<div class="col-md-10 col-md-offset-1">
					<form method="POST" action="index.php">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<input type="text" name="contact_name" placeholder="Type in your name:">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<input type="email" name="contact_email" placeholder="Type in your email:">
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<textarea name="contact_message" rows="10" placeholder="Type in your message:"></textarea>
							</div>
						</div>
						<div class="button_wrapper">
							<button type="submit" name="contact_submit">Send message</button>
						</div>
						<p><?php echo $error_msg_email; ?></p>
						<p><?php echo $error_msg_name; ?></p>
						<p><?php echo $error_msg_message; ?></p>
						<p><?php echo $err; ?></p>
						<p><?php echo $contact_success; ?></p>
					</form>
				</div>
			</div>
			<!-- Get in touch slut -->

			<?php
				require_once 'footer.php';
			?>
</html>