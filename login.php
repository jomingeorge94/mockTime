<!DOCTYPE html>
<html lang="en">

<?php include 'core/session.php'; ?>

<?php redirect_logged_in(); ?>

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

	                    <div class="row">
	                        <div class="col-sm-6 form-box">
	                        	<div class="form-box">
		                        	<div class="form-top">
		                        		<div class="form-top-left">
		                        			<h2>Sign in </h2>
		                            		<p>Enter Email Address and password to log on:</p>
		                        		</div>
		                        		<div class="form-top-right">
		                        			<i class="fa fa-key"></i>
		                        		</div>
		                            </div>
		                            <div class="form-bottom">
					                    <form role="form" action="userlogin.php" method="post" class="login-form">
					                    	<div class="form-group">
					                    		<label class="sr-only" for="form-emailaddress">Email Address</label>
					                        	<input type="text" name="form-emailaddress" placeholder="Email Address" class="form-emailaddress form-control" id="form-emailaddress">
					                        </div>
					                        <div class="form-group">
					                        	<label class="sr-only" for="form-password">Password</label>
					                        	<input type="password" name="form-password" placeholder="Password" class="form-password form-control" id="form-password">
					                        	<button type="submit" class="btn signin">Sign in!</button>
					                        	<p class="forgot-password"><a href="forgot-password.php?mode=password">Forgot Password ?</a></p>
					                        </div>
					                        
					                    </form>

				                    </div>
			                    </div>
	                        </div>
	                    </div>
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