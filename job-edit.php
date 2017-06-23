<?php
	session_start();
	if (!isset($_SESSION['isAdmin'])) {
		header('Location: login.php');
	};
	require_once 'header.php';
	require_once 'admin_nav.php';
	if (isset($_GET['id'])) {
	 	$id = $_GET['id'];
	 }
	 $_SESSION['active'] = 'active'; 
?>

<?php
	$sql = "SELECT job_title, job_description, contact_email FROM jobs WHERE id = ?";
	$stmt = $db->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->bind_result($title, $desc, $email);
	if ($stmt->fetch()) {
		$title = $title;
		$desc = $desc;
		$email = $email;
	}
	$stmt->close();
?>

<?php
	if (isset($_POST['submit'])) {
			$ok = true;

			if (!isset($_POST['job_title']) || $_POST['job_title'] === '') {
				$ok = false;
				$error_msg_title = 'Did you remember to add a job title?';
			} else {
				$job_title = filter_var($_POST['job_title'], FILTER_SANITIZE_STRING);
				$c_email = $db->real_escape_string($job_title);
			}

			if (!isset($_POST['job_desc']) || $_POST['job_desc'] === '') {
				$ok = false;
				$error_msg_desc = 'Did you remember to add a job description?';
			} else {
				$job_desc = filter_var($_POST['job_desc'], FILTER_SANITIZE_STRING);
				$job_desc = $db->real_escape_string($job_desc);
			}

			if (!isset($_POST['contact_email']) || $_POST['contact_email'] === '' || !filter_var($_POST['contact_email'], FILTER_VALIDATE_EMAIL)) {
				$ok = false;
				$error_msg_email = 'Did you remember to add a valid email?';
			} else {
				$contact_email = filter_var($_POST['contact_email'], FILTER_SANITIZE_EMAIL);
				$contact_email = $db->real_escape_string($contact_email);
			}

			if ($ok) {
				$sql = "UPDATE jobs SET job_title = ?, job_description = ?, contact_email = ? WHERE id = ?";
				$stmt = $db->prepare($sql);
				$stmt->bind_param('sssi', $job_title, $job_desc, $contact_email, $id);
				$stmt->execute();
				echo "<script>window.location = 'jobs-admin.php'</script>";
			}
	}		
?>

<div class="container-fluid">
	<div class="row">
        <div class="col-md-12">
            <h2 class="headline">Edit job</h2>
        </div>
        <div class="col-md-12 new_movie_advise">
           	<p>Please be thorough when adding new items.</p>
        </div>
    </div>
    <div class="row contact">
                <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
                    <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" name="job_title" placeholder="Job title:" value="<?php echo $title; ?>">
                                    <?php echo "<p class='error'>" . $error_msg_title . "</p>"?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea name="job_desc" rows="10" placeholder="Job description:"><?php echo $desc; ?></textarea>
                                    <?php echo "<p class='error'>" . $error_msg_desc . "</p>"?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" name="contact_email" placeholder="Contact Email:" value="<?php echo $email; ?>">
                                    <?php echo "<p class='error'>" . $error_msg_email . "</p>"?>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo $success; ?>
                                <div class="button_wrapper">
                                    <button type="submit" name="submit">Update job</button>
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