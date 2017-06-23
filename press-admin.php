<?php
session_start();
if (!isset($_SESSION['isAdmin'])) {
		header('Location: login.php');
	};
	require_once 'header.php';
	include 'admin_nav.php';
?>
<?php
	if (isset($_POST['submit'])) {
			$ok = true;

			if (!is_uploaded_file($_FILES['press_img']['tmp_name'])) {
				$ok = false;
				$error_msg_image = 'Did you remember to add a valid image?';
			} else {
				// Nedenstående fundet på https://www.w3schools.com/php/php_file_upload.asp
				$target_dir = "assets/img/press/";
				$target_file = $target_dir . basename($_FILES["press_img"]["name"]);
				$uploadOk = 1;
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

					// Check if image file is a actual image or fake image
    				$check = getimagesize($_FILES["press_img"]["tmp_name"]);

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
					if ($_FILES["press_img"]["size"] > 500000) {
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
					    if (move_uploaded_file($_FILES["press_img"]["tmp_name"], $target_file)) {
					        $target_file = $target_file;
					    } else {
					        $uploadError2 = "There was an error uploading your file. Please try again.";
					    }
					}
				}

				if (!isset($_POST['movie_id']) || $_POST['movie_id'] === '') {
					$ok = false;
					$error_msg_title = 'Something went wrong. Please try again.';
				} else {
					$movie_id = filter_var($_POST['movie_id'], FILTER_SANITIZE_NUMBER_INT);
				}

				if ($ok) {
					$sql = "INSERT INTO press (movie_id, press_img) VALUES (?,?)";
					$stmt = $db->prepare($sql);
					$stmt->bind_param('is', $movie_id, $target_file);
					$stmt->execute();
					$success = "Press material successfully added.";
					$stmt->close();
				}
	}		
?>

<?php
	if (isset($_SESSION['active'])) {
		$active = $_SESSION['active'];
		unset($_SESSION['active']);
	} else {
		$altactive = "active";
	}
?>

<div class="container-fluid">
    <ul class="nav nav-tabs nav-justified">
        <li class="<?php echo $altactive; ?>"><a data-toggle="tab" href="#add">Add press material</a>
        </li>
        <li class="<?php echo $active; ?>"><a data-toggle="tab" href="#edit">Edit press material</a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="add" class="tab-pane fade in <?php echo $altactive; ?>">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="headline">Add press material</h2>
                </div>
            </div>
            <div class="row contact">
                <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
                    <form method="post" action="press-admin.php" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p>Add image for upload</p>
                                    <input type="file" name="press_img">
                                    <?php echo "<p class='error'>" . $error_msg_image . "</p>" ?>
                                    <?php echo "<p class='error'>" . $notImage . "</p>" ?>
                                    <?php echo "<p class='error'>" . $imageDup . "</p>" ?>
                                    <?php echo "<p class='error'>" . $tooBig . "</p>" ?>
                                    <?php echo "<p class='error'>" . $wrongFormat . "</p>" ?>
                                    <?php echo "<p class='error'>" . $uploadError . "</p>" ?>
                                    <?php echo "<p class='error'>" . $uploadError2 . "</p>" ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p>Select corresponding movie</p>
                                    <select name="movie_id">
	                                    <?php
	                                    	$sql = "SELECT id, title FROM movie";
											$stmt = $db->prepare($sql);
											$stmt->execute();
											$stmt->bind_result($movid, $movie_title);
											while ($stmt->fetch()) {
												echo '<option value="' . $movid . '">' . $movie_title . '</option>';
											}
											$stmt->close();
	                                    ?>
                                    </select>
                                    <?php echo "<p class='error'>" . $error_msg_title . "</p>"?>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo $success; ?>
                                <div class="button_wrapper">
                                    <button type="submit" name="submit">Add press material</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

	    <div id="edit" class="tab-pane fade in <?php echo $active; ?>">
	        <div class="row edit_movies">
	        	<div class="col-md-12">
	        		<h2 class="headline">Edit press material</h2>
	        	</div>

	        	<div class="col-md-12">
	        		<table style="width: 100%;" border="1">
	        			<tr>
							<th><p>Press ID</p></th>
						    <th><p>Movie ID</p></th> 
						    <th><p>Image directory</p></th>
						    <th><p>Action</p></th>
						</tr>
		        		<?php
		        			$sql = "SELECT press_id, movie_id, press_img FROM press";
							$stmt = $db->prepare($sql);
							$stmt->execute();
							$stmt->bind_result($press_id, $id, $press_img);
		        		?>

		        		<?php while ($stmt->fetch()): ?>
							<tr>
							    <td><?php echo $press_id; ?></td>
							    <td><?php echo $id; ?></td>
							    <td><?php echo $press_img; ?></td>
							    <td><a href="press-delete.php?id=<?php echo $press_id; ?>">Delete</a></td>
							</tr>
		        		<?php endwhile; ?>
	        		</table>	
	        	</div>
	        </div>
	    </div>
	</div>
</div>

<?php 
	require_once 'footer.php'; 
?>