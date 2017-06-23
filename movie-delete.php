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
	$sql = "SELECT img FROM movie WHERE id = ?";
	$stmt = $db->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->bind_result($img);
	if ($stmt->fetch()) {
		unlink($img);
	}
	$stmt->close();
?>

<?php
	$sql = "DELETE FROM movie WHERE id = ?";
	$stmt = $db->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	echo '<script type="text/javascript">
		window.location = "movies-admin.php";
	</script>';
?>


