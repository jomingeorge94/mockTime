<!DOCTYPE html>
<html lang="en">
<body class="email_activate_page">

	<?php   

		include 'core/session.php';
		include 'includes/head.php';

		redirect_logged_in();

		if(isset($_GET['success']) === true && empty($_GET['success']) === true) {

	?>		
		<div class="accountverified">
			<h1>Account Verified ...</h1>
			<strong><p>Your account has been verified and ready to <a href="login.php"> Sign In </a></p></strong>
		</div>

		<?php

		}
		else if (isset($_GET['email'], $_GET['email_code']) === true) {
			$email = trim($_GET['email']); // trim will remove any whitespace
			$email_code = trim($_GET['email_code']);

			//check if the email address exist
			if (user_exists($email) === false) {
				$errors[] = 'Something went wrong, we couldn\'t find that email address !';
			} else if (activate($email, $email_code) === false) {

				$errors[] = 'Account has been activated already, try Signing In !!!';
				redirect_logged_in();
			}

			if(empty($errors) === false) {
				?>
					<div class="somethingwentwrong">
					<h2>Oops...</h2>

				<?php
					echo '<strong>' . error_output($errors) . '</strong>';
					echo '</div> ';
					
			//redirecting the user to a success section of the page		
			} else {
				header('Location:activate.php?success');
				exit();
			}

		} else {
			header('Location: index.php');
			exit();
		}

		include 'includes/footer.php';    

		?> 

</body>
</html>