<?php
	session_start();
	if (!isset($_SESSION['isAdmin'])) {
		header('Location: login.php');
	};
	require_once 'header.php';
	if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
		$id = $_GET['id'];
	} 
?>

<?php
	$sql = "SELECT img_hero, img_big, img_small FROM articles WHERE id = ?";
	$stmt = $db->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->bind_result($img_hero, $img_big, $img_small);
	if ($stmt->fetch()) {
		unlink($img_hero);
		unlink($img_big);
		unlink($img_small);
	}
	$stmt->close();
?>

<?php
	$sql = "DELETE FROM articles WHERE id = ?";
	$stmt = $db->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	echo '<script type="text/javascript">
		window.location = "news-admin.php";
	</script>';
?>


