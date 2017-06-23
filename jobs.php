<?php
	require_once 'header.php';
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<h2 class="headline">Jobs</h2>
		</div>
	</div>

	<?php
		$sql = "SELECT job_title, job_description, contact_email FROM jobs ORDER BY id";
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$stmt->bind_result($job_title, $job_description, $contact_email);
	?>

	<?php while ($stmt->fetch()): ?>
		<div class="row">
			<div class="col-md-10 col-md-offset-1 article_preview">
				<h2 class="headline"><?php echo htmlentities($job_title); ?></h2>
				<p news_main_text><?php echo htmlentities($job_description); ?></p>
				<a class="news_read_more" href="mailto:<?php echo htmlentities($contact_email); ?>">Apply now</a>
			</div>
		</div>
	<?php endwhile; ?>
</div>

<?php
	require_once 'footer.php';
?>