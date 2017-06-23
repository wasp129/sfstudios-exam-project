<?php
	require_once 'header.php';

	if (isset($_GET['page'])) {
		$page = $_GET['page'];
		$page++;
		if (isset($_POST['load-more'])) {
			$currentpage = $page * 3;
		} else {
			$currentpage = 3;
		}
	}
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<h2 class="headline">News</h2>
		</div>
	</div>

	<?php
		$sql = "SELECT headline, subtitle, main_text, id FROM articles ORDER BY id DESC LIMIT ?";
		$stmt = $db->prepare($sql);
		$stmt->bind_param('i', $currentpage);
		$stmt->execute();
		$stmt->bind_result($headline, $subtitle, $main_text, $id);
	?>

	<?php while ($stmt->fetch()): ?>
		<div class="row">
			<div class="col-md-10 col-md-offset-1 article_preview">
				<h2 class="news_headline headline"><?php echo htmlentities($headline); ?> <span class="news_subtitle"><?php echo $subtitle; ?></span></h2>
				<p news_main_text><?php echo htmlentities(substr($main_text, 0, 1000))."..."; ?></p>
				<a class="news_read_more" href="article.php?id=<?php echo $id; ?>">Read more</a>
			</div>
		</div>
	<?php endwhile; ?>

	<div class="row">
		<div class="col-md-2 col-md-offset-5 load-more">
			<form method="post" action="news.php?page=<?php echo $page ?>">
				<input type="submit" name="load-more" value="Load more">
			</form>
		</div>
	</div>	
</div>

<?php
	require_once 'footer.php';
?>