<!DOCTYPE html>
<html lang="en">

<?php include 'core/session.php'; ?>

<?php redirect_logged_in(); ?>

<?php

if(isset($_GET['success']) === true && empty($_GET['success']) === true) {
	?>
		<!-- <p>Thanks, we've emailed you !!!</p> -->
		<div class="col-sm-6 form-box passwordresetsent">
            <div class ="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert"> <i class="fa fa-times-circle-o"></i> </button>      
            <strong> Password Resent Link Sent !! </strong> <br /> Check your email to change your password <br /> <a href="login.php">Log In</a>
            </div>
        </div>
	<?php

} else {

	$mode_allowed = array('password');

	       if (isset($_GET['mode']) === true && in_array($_GET['mode'], $mode_allowed) === true) {

	       	if (isset($_POST['form-emailaddress']) === true && empty($_POST['form-emailaddress']) === false) {

	       		if (user_exists($_POST['form-emailaddress']) === true && freeze_account($_POST['form-emailaddress']) === true) {
	       			recover($_GET['mode'], $_POST['form-emailaddress']);
	       			header('Location: forgot-password.php?success');
	       			exit();

	       		} else {
	       			echo '<div class="col-sm-6 form-box forgotpassword">
            <div class ="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert"> <i class="fa fa-times-circle-o"></i> </button>      
            <strong> Oops Something went wrong !! </strong> <br /> * We couldn\'t find that email address on our system <a href="register.php">Sign Up</a> <br /> or <br /> 
            * Your account is temporarily locked out, Contact <a href="index.php#contact"> System Administrator </a>
            </div>
        </div>';
	       		}

	       	}

	       echo'	<div class="row">
	                        <div class="col-sm-6 form-box forgotpassword">
	                        	<div class="form-box">


		                        	<div class="form-top">
		                        		<div class="form-top-left">
		                        			<h2>Forgotten Password </h2>
		                            		<p>Type your email address below to change your password:</p>
		                        		</div>
		                        		<div class="form-top-right">
		                        			<i class="fa fa-unlock"></i>
		                        		</div>
		                            </div>
		                            <div class="form-bottom">
					                    
					                    <form role="form" action="" method="post" class="login-form">
					                    	<div class="form-group">
					                    		<label class="sr-only" for="form-emailaddress">Email Address</label>
					                        	<input type="text" name="form-emailaddress" placeholder="Email Address" class="form-emailaddress form-control" id="form-emailaddress">
					                        	<button type="submit" class="btn signin">Recover Password</button>
					                        </div>					                        
					                    </form>

				                    </div>
			                    </div>
	                        </div>
	                    </div>';

	            
	       } else {
	       		header('Location: index.php');
	       		exit();
	       }
}
?>

<?php include 'includes/head.php'; ?>

<?php include 'includes/customcss.php'; ?>

	<body>

		<!-- Top menu -->
		<?php include 'includes/navigation_modified.php'; ?>    

        <!-- Top content -->
	        <div class="top-content">
	            <div class="inner-bg">
	                <div class="container">
            		
	            		<?php if(isset($_SESSION['error']) AND ! empty($_SESSION['error'])): ?>
							<div class="col-sm-6 form-box">
	        					<div class ="alert alert-danger alert-dismissable">
	            					<button type="button" class="close" data-dismiss="alert"> <i class="fa fa-times-circle-o"></i> </button>  

	           						<?php
						                foreach ($_SESSION['error'] as $e){
						                    echo $e;
						                }
						                unset($_SESSION['error']);
						           	?>   
	        					</div>
							</div> 
						<?php endif; ?>

	                    
	                </div>
	            </div>
	        </div>

	    <!-- Footer of the site -->
	    <?php include 'includes/footer.php'; ?>    

        <!-- Javascript -->
        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/retina-1.1.0.min.js"></script>
        <script src="assets/js/scripts.js"></script>
        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>