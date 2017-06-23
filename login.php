<?php
	require_once 'header.php';
	if (isset($_SESSION['isAdmin'])) {
		echo "<script>window.location = 'index.php'</script>";
	}
?>	

<?php 
	if (isset($_POST['submit'])) {
		$ok = true;

		if (!isset($_POST['c_email']) || $_POST['c_email'] === '' || !filter_var($_POST['c_email'], FILTER_VALIDATE_EMAIL)) {
			$ok = false;
			$error_msg = 'Please add a valid email';
		} else {
			$email = filter_input(INPUT_POST, 'c_email', FILTER_SANITIZE_STRING);
			$email = $db->real_escape_string($email);
		};

		if (!isset($_POST['c_password']) || $_POST['c_password'] === '') {
			$ok = false;
			$error_msg2 = 'Please add a valid password';
		} else {
			$pwd = filter_input(INPUT_POST, 'c_password', FILTER_SANITIZE_STRING);
			$pwd = $db->real_escape_string($pwd);
		};
	};

	if ($ok) {
		$sql = "SELECT c_email, c_password, is_admin, c_avatar FROM users WHERE c_email = ?";
		$stmt = $db->prepare($sql);
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->bind_result($c_email, $c_password, $is_admin, $c_avatar);

		if($stmt->fetch()){	
        	if(password_verify($pwd,$c_password)){
        		session_start();
        		$_SESSION['isAdmin'] = $is_admin;
        		$_SESSION['c_avatar'] = $c_avatar;
        		if (isset($_SESSION['backurl'])) {
        			$redirect = $_SESSION['backurl'];
        			echo "<script>window.location = '".$redirect."'</script>";
        		} else {
        			echo "<script>window.location = 'index.php'</script>";
        		}
        		
        	} else {
        		$loginfail = 'Wrong password. Please try again.';
        	};	
    	};

	};

?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h2 class="headline">Log in</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 login_instructions">
				<p>For brand-safety reasons, some pages require you to be logged in. Please type in your credentials below. Contact a system administrator or Sf-Studios directly to get access.</p>
			</div>
		</div>
		<div class="row">
			<div class="login_form col-md-12">
				<form method="post" action="login.php">
					<input type="email" name="c_email" placeholder="Email"><br>
					<input type="password" name="c_password" placeholder="Password:"><br>
					<input type="submit" name="submit" value="Login">
				</form>
				<?php echo "<p class='fail_message'>" . $loginfail ."</p>"?>
				<?php echo "<p class='email_error'>" . $error_msg ."</p>"?>
				<?php echo "<p class='password_error'>" . $error_msg2 ."</p>"?>
			</div>
		</div>	
	</div>	
<?php
	require_once 'footer.php'
?>