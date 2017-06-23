<?php
	require_once 'header.php';
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	}
?>
	<div class="container-fluid">
				<?php
					$sql = "SELECT headline, subtitle, main_text, img_hero, timestamp FROM articles WHERE id = ?";
					$stmt = $db->prepare($sql);
					$stmt->bind_param('i', $id);
					$stmt->execute();
					$stmt->bind_result($headline, $subtitle, $main_text, $img_hero, $timestamp);
					$date = new DateTime($timestamp);
				?>

				<?php if($stmt->fetch()): ?>
				<div class="row">
					<div class="col-md-12 article_hero">
						<div class="article_info_wrapper">
							<img class='img-responsive' src="<?php echo $img_hero; ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<h2 class='article_headline'><?php echo $headline; ?><span class="article_subtitle"><?php echo $subtitle; ?></span></h2>
						<p class="timestamp">Date: <?php echo $date->format('d-m-Y'); ?></p>
						<p class="main_text">
							<?php echo nl2br($main_text); ?>
						</p>
					</div>
				</div>	

				<?php endif; ?>	
	</div>
<?php
	require_once 'footer.php';
?>