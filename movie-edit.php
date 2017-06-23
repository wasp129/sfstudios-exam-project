<?php
	session_start();
	if (!isset($_SESSION['isAdmin'])) {
		header('Location: login.php');
	};
	require_once 'header.php';
	if (isset($_GET['movId'])) {
		$movId = $_GET['movId'];
	}
	$_SESSION['active'] = "active";  
?>

<?php
	$sql = "SELECT title, year, in_theaters, img FROM movie WHERE id = ?";
	$stmt = $db->prepare($sql);
	$stmt->bind_param('i', $movId);
	$stmt->execute();
	$stmt->bind_result($movTitle, $movYear, $movIntheaters, $movImg);
	if ($stmt->fetch()) {
		$movTitle = $movTitle;
		$movYear = $movYear;
		$movIntheaters = $movIntheaters;
		$movImg = $movImg;
	}
	$stmt->close();
?>

<?php
	if (isset($_POST['submit'])) {
			$ok = true;
 
			if (!isset($_POST['title']) || $_POST['title'] === '') {
				$ok = false;
				$error_msg_headline = 'Did you remember to add a headline?';
			} else {
				$title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
				$title = $db->real_escape_string($title);
			}

			if (!isset($_POST['year']) || $_POST['year'] === '') {
				$ok = false;
				$error_msg_articlerole = 'Did you remember to add a location for the article?';
			} else {
				$year = filter_var($_POST['year'], FILTER_SANITIZE_NUMBER_INT);
			}

			if (!is_uploaded_file($_FILES['img']['tmp_name'])) {
				$target_file = $movImg;
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
				        $notImage1 = "The uploaded file is not a valid image.";
				        $uploadOk = 0;
				        $ok = false;
				    }

					// Check file size
					if ($_FILES["img"]["size"] > 500000) {
					    $tooBig1 = "Maximun file size is 500KB";
					    $uploadOk = 0;
					    $ok = false;
					}

					// Allow certain file formats
					if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
					    $wrongFormat1 = "Only jpg, png or jpeg files are allowed.";
					    $uploadOk = 0;
					    $ok = false;
					}

					// Check if $uploadOk is set to 0 by an error
					if ($uploadOk == 0) {
					    $uploadError1 = "There was an error uploading your file. Please try again.";
					    $ok = false;
					// if everything is ok, try to upload file
					} else {
					    if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
					        $target_file = $target_file;
					    } else {
					        $uploadError12 = "There was an error uploading your file. Please try again.";
					        $ok = false;
					    }
					}
				}

				if (!isset($_POST['in_theaters']) || $_POST['in_theaters'] === '') {
				$ok = false;
				$error_msg_articlerole = 'Did you remember to add a location for the article?';
				} else {
					$in_theaters = filter_var($_POST['in_theaters'], FILTER_SANITIZE_NUMBER_INT);
				}

				if ($ok) {
					$sql = "UPDATE movie SET title = ?, year = ?, in_theaters = ?, img = ? WHERE id = ?";
					$stmt = $db->prepare($sql);
					$stmt->bind_param('siisi', $title, $year, $in_theaters, $target_file, $movId);
					$stmt->execute();
					echo "<script>window.location = 'movies-admin.php'</script>";
				}
	}		
?>

<div class="container-fluid">
    <div class="row">
                <div class="col-md-12">
                    <h2 class="headline">Edit <?php echo "'" . $movTitle . "'"; ?></h2>
                </div>
            </div>
            <div class="row contact">
                <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
                    <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" name="title" placeholder="Movie title:" value="<?php echo $movTitle; ?>">
                                    <?php echo "<p class='error'>" . $error_msg_title . "</p>"?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" name="year" placeholder="Year:" value="<?php echo $movYear; ?>">
                                    <?php echo "<p class='error'>" . $error_msg_year . "</p>"?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p>Please note: Image must be 500px x 750px</p>
                                    <input type="file" name="img">
                                    <?php echo "<p class='error'>" . $notImage . "</p>"?>
                                    <?php echo "<p class='error'>" . $imageDup . "</p>"?>
                                    <?php echo "<p class='error'>" . $tooBig . "</p>"?>
                                    <?php echo "<p class='error'>" . $wrongFormat . "</p>"?>
                                    <?php echo "<p class='error'>" . $uploadError . "</p>"?>
                                    <?php echo "<p class='error'>" . $uploadError2 . "</p>"?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p>Select whether the film is currently in theaters</p>
                                    <select name="in_theaters">
                                        <option value="1" <?php if ($movIntheaters == 1) {
                                        	echo "selected";
                                        } ?>>In theaters</option>
                                        <option value="0"<?php if ($movIntheaters == 0) {
                                        	echo "selected";
                                        } ?>>Not in theaters</option>
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
                                    <button type="submit" name="submit">Update information</button>
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