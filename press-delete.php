<?php
	session_start();
	if (!isset($_SESSION['isAdmin'])) {
		header('Location: login.php');
	};
	require_once 'header.php';
	if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
		$id = $_GET['id'];
	} 
	$_SESSION['active'] = 'active';
?>

<?php
	$sql = "SELECT press_img FROM press WHERE press_id = ?";
	$stmt = $db->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->bind_result($press_img);
	if ($stmt->fetch()) {
		unlink($press_img);
	}
	$stmt->close();
?>

<?php
	$sql = "DELETE FROM press WHERE press_id = ?";
	$stmt = $db->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	echo '<script type="text/javascript">
		window.location = "press-admin.php";
	</script>';
?>


