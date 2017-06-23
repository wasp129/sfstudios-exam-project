<?php
	session_start();
	if (!isset($_SESSION['isAdmin'])) {
		header('Location: login.php');
	};
	require_once 'header.php';
?>

	<?php
		$company = '';
		$c_fname = '';
		$c_lname = '';
		$c_number = '';
		$c_email = '';
		$c_password = '';
		$c_avatar = '';
		$isAdmin = 0;

		if (isset($_POST['submit'])) {
			$ok = true;

			if (!isset($_POST['company']) || $_POST['company'] === '') {
				$ok = false;
				$error_msg_company = 'Did you remember to add a company?';
			} else {
				$company = filter_var($_POST['company'], FILTER_SANITIZE_STRING);
				$company = $db->real_escape_string($company);
			}

			if (!isset($_POST['c_fname']) || $_POST['c_fname'] === '') {
				$ok = false;
				$error_msg_fname = 'Did you remember add a first name?';
			} else {
				$c_fname = filter_var($_POST['c_fname'], FILTER_SANITIZE_STRING);
				$c_fname = $db->real_escape_string($c_fname);
			}

			if (!isset($_POST['c_lname']) || $_POST['c_lname'] === '') {
				$ok = false;
				$error_msg_lname = 'Did you remember to add a last name?';
			} else {
				$c_lname = filter_var($_POST['c_lname'], FILTER_SANITIZE_STRING);
				$c_lname = $db->real_escape_string($c_lname);
			}

			if (!isset($_POST['c_number']) || $_POST['c_number'] === '') {
				$ok = false;
				$error_msg_number = 'Did you remember to add a number?';
			} else {
				$c_number = filter_var($_POST['c_number'], FILTER_SANITIZE_STRING);
				$c_number = $db->real_escape_string($c_number);
			}

			if (!isset($_POST['c_email']) || $_POST['c_email'] === '' || !filter_var($_POST['c_email'], FILTER_VALIDATE_EMAIL)) {
				$ok = false;
				$error_msg_email = 'Did you remember to add a valid email?';
			} else {
				$c_email = filter_var($_POST['c_email'], FILTER_SANITIZE_EMAIL);
				$c_email = $db->real_escape_string($c_email);
			}

			if (!isset($_POST['c_password']) || $_POST['c_password'] === '') {
				$ok = false;
				$error_msg_password = 'Did you remember to add a password?';
			} else {
				$c_password = $_POST['c_password'];
			}

			if (!is_uploaded_file($_FILES['c_avatar']['tmp_name'])) {
				$ok = false;
				$error_msg_image = 'Did you remember to add a valid image?';
			} else {
				// Nedenstående fundet på https://www.w3schools.com/php/php_file_upload.asp
				$target_dir = "assets/img/avatars/";
				$target_file = $target_dir . basename($_FILES["c_avatar"]["name"]);
				$uploadOk = 1;
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

					// Check if image file is a actual image or fake image
    				$check = getimagesize($_FILES["c_avatar"]["tmp_name"]);

				    if($check !== false) {
				        $uploadOk = 1;
				    } else {
				        $notImage = "The uploaded file is not a valid image.";
				        $uploadOk = 0;
				        $ok = false;
				    }

				    // Check if file already exists
					if (file_exists($target_file)) {
					    $imgDup = "The uploaded file already exists. Please add a new one or change the filename.";
					    $uploadOk = 0;
					    $ok = false;
					}

					// Check file size
					if ($_FILES["c_avatar"]["size"] > 500000) {
					    $tooBig = "Maximun file size is 500KB";
					    $uploadOk = 0;
					    $ok = false;
					}

					// Allow certain file formats
					if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
					    $wrongFormat = "Only jpg, png or jpeg files are allowed.";
					    $uploadOk = 0;
					    $ok = false;
					}

					// Check if $uploadOk is set to 0 by an error
					if ($uploadOk == 0) {
					    $uploadError = "There was an error uploading your file. Please try again.";
					// if everything is ok, try to upload file
					} else {
					    if (move_uploaded_file($_FILES["c_avatar"]["tmp_name"], $target_file)) {
					        $target_file = $target_file;
					    } else {
					        $uploadError2 = "There was an error uploading your file. Please try again.";
					    }
					}
			}

			if (!isset($_POST['isAdmin']) || $_POST['isAdmin'] === '') {
				$ok = false;
				$error_msg_admin = 'Something went wrong. Please try again.';
			} else {
				$isAdmin = filter_var($_POST['isAdmin'], FILTER_SANITIZE_NUMBER_INT);
			}

			if ($ok) {
				$hash = password_hash($c_password, PASSWORD_DEFAULT);
				$sql = "INSERT INTO users (company, c_fname, c_lname, c_number, c_email, c_password, c_avatar, is_admin) VALUES (?,?,?,?,?,?,?,?)";
				$stmt = $db->prepare($sql);
				$stmt->bind_param('sssssssi', $company, $c_fname, $c_lname, $c_number, $c_email, $hash, $target_file, $isAdmin);
				$stmt->execute();
				$success = "User successfully added.";
			}
		}

	?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h2 class="headline">Add new user</h2>
			</div>
		</div>
    <div class="row contact">
        <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
            <form method="post" action="signup.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" name="company" placeholder="Company name:">
                            <?php echo "<p class='error'>" . $error_msg_company . "</p>"?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6 left">
                        <div class="form-group">
                            <input type="text" name="c_fname" placeholder="First name:">
                            <?php echo "<p class='error'>" . $error_msg_fname . "</p>"?>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 right">
                        <div class="form-group">
                            <input type="text" name="c_lname" placeholder="Last name:">
                            <?php echo "<p class='error'>" . $error_msg_lname . "</p>"?>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 left">
                        <div class="form-group">
                            <input type="text" name="c_number" placeholder="Phone number:">
                            <?php echo "<p class='error'>" . $error_msg_number . "</p>"?>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 right">
                        <div class="form-group">
                            <input type="email" name="c_email" placeholder="Email:">
                            <?php echo "<p class='error'>" . $error_msg_email . "</p>"?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="password" name="c_password" placeholder="Password:">
                            <?php echo "<p class='error'>" . $error_msg_password . "</p>"?>
                            <br>
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col-md-6">
	                	<div class="form-group">
	                		<p>Please note: Image must be 200px x 200px</p>
	                		<input type="file" name="c_avatar" placeholder="Choose">
	                		<?php echo "<p class='error'>" . $error_msg_image . "</p>"?>
	                	</div>	
                	</div>
                	<div class="col-md-6">
		                <div class="form-group">
		                	<p>Select whether the user should have admin rights</p>
			                <select name="isAdmin">
			                    <option value="1">Admin</option>
			                    <option value="0">Client</option>
			                </select>
			                <?php echo "<p class='error'>" . $error_msg_admin . "</p>"?>
			            </div>    
		            </div> 
                </div>
                <br>
                <div class="row">
	                <div class="col-md-12">
	                	<?php echo $success; ?>
	                	<div class="button_wrapper">
							<button type="submit" name="submit">Add user</button>
						</div>
	                </div>	
                </div>
            </form>
        </div>
    </div>
</div>
<?php
	require_once 'footer.php';
?>