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

			if (!isset($_POST['job_title']) || $_POST['job_title'] === '') {
				$ok = false;
				$error_msg_title = 'Did you remember to add a job title?';
			} else {
				$job_title = filter_var($_POST['job_title'], FILTER_SANITIZE_STRING);
				$job_title = $db->real_escape_string($job_title);
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
				$error_msg_email = 'Did you remember to add a valid contact email?';
			} else {
				$contact_email = filter_var($_POST['contact_email'], FILTER_SANITIZE_EMAIL);
				$contact_email = $db->real_escape_string($contact_email);
			}

			if ($ok) {
				$sql = "INSERT INTO jobs (job_title, job_description, contact_email) VALUES (?,?,?)";
				$stmt = $db->prepare($sql);
				$stmt->bind_param('sss', $job_title, $job_desc, $contact_email);
				$stmt->execute();
				$success = "Job successfully added.";
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
        <li class="<?php echo $altactive; ?>"><a data-toggle="tab" href="#add">Add new job</a>
        </li>
        <li class="<?php echo $active; ?>"><a data-toggle="tab" href="#edit">Edit jobs</a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="add" class="tab-pane fade in <?php echo $altactive; ?>">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="headline">Add new job</h2>
                </div>
                <div class="col-md-12 new_movie_advise">
                   	<p>Please be thorough when adding new items.</p>
                </div>
            </div>
            <div class="row contact">
                <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
                    <form method="post" action="jobs-admin.php" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" name="job_title" placeholder="Job title:">
                                    <?php echo "<p class='error'>" . $error_msg_title . "</p>"?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea name="job_desc" rows="10" placeholder="Job description:"></textarea>
                                    <?php echo "<p class='error'>" . $error_msg_desc . "</p>"?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" name="contact_email" placeholder="Contact Email:">
                                    <?php echo "<p class='error'>" . $error_msg_email . "</p>"?>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo $success; ?>
                                <div class="button_wrapper">
                                    <button type="submit" name="submit">Add job</button>
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
	        		<h2 class="headline">Edit jobs</h2>
	        	</div>

	        	<div class="col-md-12">
	        		<table style="width: 100%;" border="1">
	        			<tr>
							<th><p>Job title</p></th>
						    <th><p>Contact email</p></th> 
						    <th><p>Action</p></th>
						</tr>
		        		<?php
		        			$sql = "SELECT id, job_title, contact_email FROM jobs";
							$stmt = $db->prepare($sql);
							$stmt->execute();
							$stmt->bind_result($id, $job_title, $contact_email);
		        		?>

		        		<?php while ($stmt->fetch()): ?>
							<tr>
							    <td><?php echo $job_title; ?></td>
							    <td><?php echo $contact_email; ?></td>
							    <td><a href="job-edit.php?id=<?php echo $id; ?>">Edit</a> / <a href="job-delete.php?id=<?php echo $id; ?>">Delete</a></td>
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