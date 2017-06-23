<?php 
	session_start();
	if (!isset($_SESSION['isAdmin'])) {
		header('Location: login.php');
	};
	require_once 'header.php';
	if (isset($_GET['title'])) {
		$title = $_GET['title'];
	}
?>	

<div class="container-fluid">
	<div class="row gallery">
		<?php
			$sql = "SELECT press_img FROM press WHERE movie_title = ?";
					$stmt = $db->prepare($sql);
					$stmt->bind_param('s', $title);
					$stmt->execute();
					$stmt->bind_result($gallery_img);
					while($stmt->fetch()) {
						echo '<div style="height: 200px; overflow: hidden; margin-top: 20px;" class="col-md-4 col-sm-4 col-xs-12"><a href="' . $gallery_img .'" data-toggle="lightbox" data-gallery="example-gallery">
	    				<img src="' . $gallery_img .'" class="img-responsive">
						</a></div>';
	    			}
		?>
	</div>
</div>

<!-- Nedenstående snippet lånt fra http://ashleydw.github.io/lightbox/ -->
<script type="text/javascript">
	$(document).on('click', '[data-toggle="lightbox"]', function(event) {
	    event.preventDefault();
	    $(this).ekkoLightbox();
	});
</script>
<?php
	require_once 'footer.php';
?>
