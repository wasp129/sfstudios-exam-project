<?php
	session_start();
	if (!isset($_SESSION['isAdmin'])) {
		header('Location: login.php');
	};
	require_once 'header.php';
	if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
		$id = $_GET['id'];
		$_SESSION['active'] = 'active';
	} 
?>

<?php
	$sql = "DELETE FROM jobs WHERE id = ?";
	$stmt = $db->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	echo '<script type="text/javascript">
		window.location = "jobs-admin.php";
	</script>';
?>