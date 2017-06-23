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

			if (!isset($_POST['title']) || $_POST['title'] === '') {
				$ok = false;
				$error_msg_title = 'Did you remember to add a title?';
			} else {
				$title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
				$title = $db->real_escape_string($title);
			}

			if (!isset($_POST['year']) || $_POST['year'] === '' || !filter_var($_POST['year'], FILTER_VALIDATE_INT)) {
				$ok = false;
				$error_msg_year = 'Did you remember to add a valid year?';
			} else {
				$year = filter_var($_POST['year'], FILTER_SANITIZE_NUMBER_INT);
			}

			if (!is_uploaded_file($_FILES['img']['tmp_name'])) {
				$ok = false;
				$error_msg_image = 'Did you remember to add a valid image?';
			} else {
				// Nedenstående fundet på https://www.w3schools.com/php/php_file_upload.asp
				$target_dir = "assets/img/movies/";
				$target_file = $target_dir . basename($_FILES["img"]["name"]);
				$uploadOk = 1;
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

					// Check if image file is a actual image or fake image
    				$check = getimagesize($_FILES["img"]["tmp_name"]);

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
					if ($_FILES["img"]["size"] > 500000) {
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
					    if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
					        $target_file = $target_file;
					    } else {
					        $uploadError2 = "There was an error uploading your file. Please try again.";
					    }
					}
				}

				if (!isset($_POST['in_theaters']) || $_POST['in_theaters'] === '') {
					$ok = false;
					$error_msg_theater = 'Something went wrong. Please try again.';
				} else {
					$in_theaters = filter_var($_POST['in_theaters'], FILTER_SANITIZE_NUMBER_INT);
				}

				if ($ok) {
				$sql = "INSERT INTO movie (title, year, in_theaters, img) VALUES (?,?,?,?)";
				$stmt = $db->prepare($sql);
				$stmt->bind_param('siis', $title, $year, $in_theaters, $target_file);
				$stmt->execute();
				$success = "Movie successfully added.";
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
        <li class="<?php echo $altactive; ?>"><a data-toggle="tab" href="#add">Add new movie</a>
        </li>
        <li class="<?php echo $active; ?>"><a data-toggle="tab" href="#edit">Edit movies</a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="add" class="tab-pane fade in <?php echo $altactive; ?>">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="headline">Add new movie</h2>
                </div>
                <div class="col-md-12 new_movie_advise">
                   	<p>Please be thorough when adding new items, as wrongful information can ruin the movie-details page.</p>
                </div>
            </div>
            <div class="row contact">
                <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
                    <form method="post" action="movies-admin.php" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" name="title" placeholder="Movie title:">
                                    <?php echo "<p class='error'>" . $error_msg_title . "</p>"?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" name="year" placeholder="Year:">
                                    <?php echo "<p class='error'>" . $error_msg_year . "</p>"?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p>Please note: Image must be 500px x 750px</p>
                                    <input type="file" name="img">
                                    <?php echo "<p class='error'>" . $error_msg_image . "</p>"?>
                                    <?php echo "<p class='error'>" . $notImage . "</p>"?>
                                    <?php echo "<p class='error'>" . $imageDup . "</p>"?>
                                    <?php echo "<p class='error'>" . $tooBig . "</p>"?>
                                    <?php echo "<p class='error'>" . $wrongFormat . "</p>"?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p>Select whether the film is currently in theaters</p>
                                    <select name="in_theaters">
                                        <option value="1">In theaters</option>
                                        <option value="0">Not in theaters</option>
                                    </select>
                                    <?php echo "<p class='error'>" . $error_msg_theater . "</p>"?>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo $success; ?>
                                <div class="button_wrapper">
                                    <button type="submit" name="submit">Add movie</button>
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
	        		<h2 class="headline">Edit movies</h2>
	        	</div>

	        	<div class="col-md-12">
	        		<table style="width: 100%;" border="1">
	        			<tr>
							<th><p>ID</p></th>
						    <th><p>Title</p></th> 
						    <th><p>Year</p></th>
						    <th><p>In theaters Y/N</p></th>
						    <th><p>Image directory</p></th>
						    <th><p>Action</p></th>
						</tr>
		        		<?php
		        			$sql = "SELECT * FROM movie";
							$stmt = $db->prepare($sql);
							$stmt->execute();
							$stmt->bind_result($id, $title, $year, $in_theaters, $img);
		        		?>

		        		<?php while ($stmt->fetch()): ?>
							<tr>
							    <td><?php echo htmlentities($id); ?></td>
							    <td><?php echo htmlentities($title); ?></td>
							    <td><?php echo htmlentities($year); ?></td>
							    <td><?php echo htmlentities($in_theaters); ?></td>
							    <td><?php echo htmlentities($img); ?></td>
							    <td><a href="movie-edit.php?movId=<?php echo $id; ?>">Edit</a> / <a href="movie-delete.php?id=<?php echo $id; ?>">Delete</a></td>
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