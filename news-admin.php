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
 
			if (!isset($_POST['headline']) || $_POST['headline'] === '') {
				$ok = false;
				$error_msg_headline = 'Did you remember to add a headline?';
			} else {
				$headline = filter_var($_POST['headline'], FILTER_SANITIZE_STRING);
				$headline = $db->real_escape_string($headline);
			}

			if (!isset($_POST['subtitle']) || $_POST['subtitle'] === '') {
				$ok = false;
				$error_msg_subtitle = 'Did you remember to add a subtitle?';
			} else {
				$subtitle = filter_var($_POST['subtitle'], FILTER_SANITIZE_STRING);
				$subtitle = $db->real_escape_string($subtitle);
			}

			if (!isset($_POST['main_article']) || $_POST['main_article'] === '') {
				$ok = false;
				$error_msg_article = 'Did you remember to add content for the article?';
			} else {
				$main_article = filter_var($_POST['main_article'], FILTER_SANITIZE_STRING);
				$main_article = $db->real_escape_string($main_article);
			}

			if (!isset($_POST['article_role']) || $_POST['article_role'] === '') {
				$ok = false;
				$error_msg_articlerole = 'Did you remember to add a location for the article?';
			} else {
				$article_role = filter_var($_POST['article_role'], FILTER_SANITIZE_STRING);
				$article_role = $db->real_escape_string($article_role);
			}

			if (!is_uploaded_file($_FILES['img-hero']['tmp_name'])) {
				$ok = false;
				$error_msg_image1 = 'Did you remember to add a valid image?';
			} else {
				// Nedenstående fundet på https://www.w3schools.com/php/php_file_upload.asp
				$target_dir_hero = "assets/img/article/img_hero/";
				$target_file_hero = $target_dir_hero . basename($_FILES["img-hero"]["name"]);
				$uploadOk = 1;
				$imageFileType = pathinfo($target_file_hero,PATHINFO_EXTENSION);

					// Check if image file is a actual image or fake image
    				$check = getimagesize($_FILES["img-hero"]["tmp_name"]);

				    if($check !== false) {
				        $uploadOk = 1;
				    } else {
				        $notImage1 = "The uploaded file is not a valid image.";
				        $uploadOk = 0;
				        $ok = false;
				    }

				    // Check if file already exists
					if (file_exists($target_file_hero)) {
					    $imgDup1 = "The uploaded file already exists. Please add a new one or change the filename.";
					    $uploadOk = 0;
					    $ok = false;
					}

					// Check file size
					if ($_FILES["img-hero"]["size"] > 500000) {
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
					    $uploadError = "There was an error uploading your file. Please try again.";
					    $ok = false;
					// if everything is ok, try to upload file
					} else {
					    if (move_uploaded_file($_FILES["img-hero"]["tmp_name"], $target_file_hero)) {
					        $target_file_hero = $target_file_hero;
					    } else {
					        $uploadError2 = "There was an error uploading your file. Please try again.";
					        $ok = false;
					    }
					}
				}

			if (!is_uploaded_file($_FILES['img-big']['tmp_name'])) {
				$ok = false;
				$error_msg_image2 = 'Did you remember to add a valid image?';
			} else {
				// Nedenstående fundet på https://www.w3schools.com/php/php_file_upload.asp
				$target_dir_big = "assets/img/article/img_big/";
				$target_file_big = $target_dir_big . basename($_FILES["img-big"]["name"]);
				$uploadOk = 1;
				$imageFileType = pathinfo($target_file_big,PATHINFO_EXTENSION);

					// Check if image file is a actual image or fake image
    				$check = getimagesize($_FILES["img-big"]["tmp_name"]);

				    if($check !== false) {
				        $uploadOk = 1;
				    } else {
				        $notImage2 = "The uploaded file is not a valid image.";
				        $uploadOk = 0;
				        $ok = false;
				    }

				    // Check if file already exists
					if (file_exists($target_file_big)) {
					    $imgDup2 = "The uploaded file already exists. Please add a new one or change the filename.";
					    $uploadOk = 0;
					    $ok = false;
					}

					// Check file size
					if ($_FILES["img-big"]["size"] > 500000) {
					    $tooBig2 = "Maximun file size is 500KB";
					    $uploadOk = 0;
					    $ok = false;
					}

					// Allow certain file formats
					if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
					    $wrongFormat2 = "Only jpg, png or jpeg files are allowed.";
					    $uploadOk = 0;
					    $ok = false;
					}

					// Check if $uploadOk is set to 0 by an error
					if ($uploadOk == 0) {
					    $uploadError2 = "There was an error uploading your file. Please try again.";
					    $ok = false;
					// if everything is ok, try to upload file
					} else {
					    if (move_uploaded_file($_FILES["img-big"]["tmp_name"], $target_file_big)) {
					        $target_file_big = $target_file_big;
					    } else {
					        $uploadError22 = "There was an error uploading your file. Please try again.";
					        $ok = false;
					    }
					}
				}

				if (!is_uploaded_file($_FILES['img-small']['tmp_name'])) {
					$ok = false;
					$error_msg_image3 = 'Did you remember to add a valid image?';
				} else {
				// Nedenstående fundet på https://www.w3schools.com/php/php_file_upload.asp
				$target_dir_small = "assets/img/article/img_small/";
				$target_file_small = $target_dir_small . basename($_FILES["img-small"]["name"]);
				$uploadOk = 1;
				$imageFileType = pathinfo($target_file_small,PATHINFO_EXTENSION);

					// Check if image file is a actual image or fake image
    				$check = getimagesize($_FILES["img-small"]["tmp_name"]);

				    if($check !== false) {
				        $uploadOk = 1;
				    } else {
				        $notImage3 = "The uploaded file is not a valid image.";
				        $uploadOk = 0;
				        $ok = false;
				    }

				    // Check if file already exists
					if (file_exists($target_file_small)) {
					    $imgDup3 = "The uploaded file already exists. Please add a new one or change the filename.";
					    $uploadOk = 0;
					    $ok = false;
					}

					// Check file size
					if ($_FILES["img-small"]["size"] > 500000) {
					    $tooBig3 = "Maximun file size is 500KB";
					    $uploadOk = 0;
					    $ok = false;
					}

					// Allow certain file formats
					if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
					    $wrongFormat3 = "Only jpg, png or jpeg files are allowed.";
					    $uploadOk = 0;
					    $ok = false;
					}

					// Check if $uploadOk is set to 0 by an error
					if ($uploadOk == 0) {
					    $uploadError3 = "There was an error uploading your file. Please try again.";
					    $ok = false;
					// if everything is ok, try to upload file
					} else {
					    if (move_uploaded_file($_FILES["img-small"]["tmp_name"], $target_file_small)) {
					        $target_file_small = $target_file_small;
					    } else {
					        $uploadError23 = "There was an error uploading your file. Please try again.";
					        $ok = false;
					    }
					}
				}	

				if ($ok) {
					$sql = "INSERT INTO articles (headline, subtitle, main_text, article_role, img_hero, img_big, img_small) VALUES (?,?,?,?,?,?,?)";
					$stmt = $db->prepare($sql);
					$stmt->bind_param('sssisss', $headline, $subtitle, $main_article, $article_role, $target_file_hero, $target_file_big, $target_file_small);
					$stmt->execute();
					$success = "Article successfully added.";
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
        <li class="<?php echo $altactive; ?>"><a data-toggle="tab" href="#add">Add article</a>
        </li>
        <li class="<?php echo $active; ?>"><a data-toggle="tab" href="#edit">Edit article</a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="add" class="tab-pane fade in <?php echo $altactive; ?>">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="headline">Add article</h2>
                </div>
                <div class="col-md-12 new_movie_advise">
                   	<p>Please be thorough when adding new items. All headlines and subtitles should begin each word with a capital letter.</p>
                </div>
            </div>
            <div class="row contact">
                <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
                    <form method="post" action="news-admin.php" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                	<p>Headline should contain title, name, event or category followed by a ":". Example: Cannes 2017: </p>
                                    <input type="text" name="headline" placeholder="Headline:">
                                    <?php echo "<p class='error'>" . $error_msg_headline . "</p>"?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                	<p>Subtitle should contain a more in depth description. Example: See all the winners from this year's festival</p>
                                    <input type="text" name="subtitle" placeholder="Subtitle:">
                                    <?php echo "<p class='error'>" . $error_msg_subtitle . "</p>"?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea name="main_article" rows="10" placeholder="Article content:"></textarea>
                                    <?php echo "<p class='error'>" . $error_msg_article . "</p>"?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p>Select where the article should be displayed. Select "Featured top main" for the main position on the top of the front page, "Featured big" for the big position in the featured section, "Featured small" for the small position in the featured section, or "Not featured" to simply add it to the collection.</p>
                                    <select name="article_role">
                                        <option value="1">Featured top main</option>
                                        <option value="2">Featured big</option>
                                        <option value="3">Featured small</option>
                                        <option value="4">Not featured</option>
                                    </select>
                                    <?php echo "<p class='error'>" . $error_msg_articlerole . "</p>"?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p><span style="font-family: 'raleway-bold'">Featured top main image.</span> Please note: Image must be 2000px x 772px</p>
		                            <input type="file" name="img-hero">
		                            <?php echo "<p class='error'>" . $error_msg_image1 . "</p>"?>
		                            <?php echo "<p class='error'>" . $notImage1 . "</p>"?>
		                            <?php echo "<p class='error'>" . $tooBig1 . "</p>"?>
		                            <?php echo "<p class='error'>" . $imgDup1 . "</p>"?>
		                            <?php echo "<p class='error'>" . $wrongFormat1 . "</p>"?>
		                            <?php echo "<p class='error'>" . $uploadError . "</p>"?>
		                            <?php echo "<p class='error'>" . $uploadError2 . "</p>"?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p><span style="font-family: 'raleway-bold'">Featured big image.</span> Please note: Image must be 1870px x 559px</p>
		                            <input type="file" name="img-big">
		                            <?php echo "<p class='error'>" . $error_msg_image2 . "</p>"?>
		                            <?php echo "<p class='error'>" . $notImage2 . "</p>"?>
		                            <?php echo "<p class='error'>" . $tooBig2 . "</p>"?>
		                            <?php echo "<p class='error'>" . $imgDup2 . "</p>"?>
		                            <?php echo "<p class='error'>" . $wrongFormat2 . "</p>"?>
		                            <?php echo "<p class='error'>" . $uploadError2 . "</p>"?>
		                            <?php echo "<p class='error'>" . $uploadError22 . "</p>"?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p><span style="font-family: 'raleway-bold'">Featured small image.</span> Please note: Image must be 730px x 394px</p>
		                            <input type="file" name="img-small">
		                            <?php echo "<p class='error'>" . $error_msg_image3 . "</p>"?>
		                            <?php echo "<p class='error'>" . $notImage3 . "</p>"?>
		                            <?php echo "<p class='error'>" . $tooBig3 . "</p>"?>
		                            <?php echo "<p class='error'>" . $imgDup3 . "</p>"?>
		                            <?php echo "<p class='error'>" . $wrongFormat3 . "</p>"?>
		                            <?php echo "<p class='error'>" . $uploadError3 . "</p>"?>
		                            <?php echo "<p class='error'>" . $uploadError23 . "</p>"?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo $success; ?>
                                <div class="button_wrapper">
                                    <button type="submit" name="submit">Add article</button>
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
	        		<h2 class="headline">Edit articles</h2>
	        	</div>

	        	<div class="col-md-12">
	        		<table style="width: 100%;" border="1">
	        			<tr>
							<th><p>ID</p></th>
						    <th><p>Headline</p></th> 
						    <th><p>Subtitle</p></th>
						    <th><p>Action</p></th>
						</tr>
		        		<?php
		        			$sql = "SELECT id, headline, subtitle FROM articles";
							$stmt = $db->prepare($sql);
							$stmt->execute();
							$stmt->bind_result($id, $headline, $subtitle);
		        		?>

		        		<?php while ($stmt->fetch()): ?>
							<tr>
							    <td><?php echo htmlentities($id); ?></td>
							    <td><?php echo htmlentities($headline); ?></td>
							    <td><?php echo htmlentities($subtitle); ?></td>
							    <td><a href="news-edit.php?artId=<?php echo $id; ?>">Edit</a> / <a href="news-delete.php?id=<?php echo $id; ?>">Delete</a></td>
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