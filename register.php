<!DOCTYPE html>
<html lang="en">
<?php 
    include 'core/session.php';
    redirect_logged_in();
    include 'includes/head.php';
    include 'includes/customcss.php';

        if(empty($_POST) === false){
            $fields_required = array('form-first-name', 'form-last-name', 'form-email', 'form-password', 'form-retype-password');
            foreach ($_POST as $key => $value) {
                //if there is an empty value in the fields required then this condition will be applied
                if (empty($value) && in_array($key, $fields_required) === true){
                    $errors[] = 'All fields are required';
                    //break out of the loop and continue with the execution 
                    break 1; 
                }
            }
            if(empty($errors) === true) {
                //checking if there is any record in the database with the same email address
                if(user_exists($_POST['form-email']) === true) {
                    $errors[] = 'Sorry, email address \'' . htmlentities($_POST['form-email']) . '\' is already registered.';
                } 
                //checking the password length 
                if (strlen($_POST['form-password']) < 8 && strlen($_POST['form-password']) > 32 ) {
                    $errors[] = 'Your password must be at least 8 characters';
                }
                //checking password and retype password matches with each other
                if ($_POST['form-password'] !== $_POST['form-retype-password']) {
                    $errors[] = 'Your passwords do not match';
                }
                //checking if there is any white space within the email address specified
                if (preg_match("/\\s/", $_POST['form-email']) == true){
                    $errors[] = 'Email must not contain any white spaces ';
                }
                //checking to see if the specified email address is valid or not
                if (filter_var($_POST['form-email'], FILTER_VALIDATE_EMAIL) === false) {
                    $errors[] = 'Valid email address is required ';
                }
            }
        }
?>
    <body>
		<?php include 'includes/navigation_modified.php';?> 

        <div class="top-content">
            <div class="inner-bg">
                <div class="container">
                    <?php 

                             //register the user if there are no errors and the form is submitted
                            if (empty($_POST) === false && empty($errors) === true) {
                                
                                $register_data = array(
                                    'first_name' => htmlspecialchars($_POST['form-first-name']),
                                    'last_name' => htmlspecialchars($_POST['form-last-name']),
                                    'email_address' => htmlspecialchars($_POST['form-email']),
                                    'password' => htmlspecialchars($_POST['form-password']), 
                                    'email_code' => md5($_POST['form-email'] + microtime())
                                );
                                //passes these data to the user_register function
                                user_register($register_data);
                                //redirecting the user back to index.php after sign up
                                echo '<div class="col-sm-6 form-box">
                                                <div class ="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert"> <i class="fa fa-times-circle-o"></i> </button>  ';    
                                                        
                                                 echo '  Successfully Registered !! <br /> Check your email to activate your account <br /> <a href="login.php">Log In</a>
                                                </div>
                                            </div> ';
                            } 
                            // output the errors on the screen if the above condition doesn't meet
                            else if (empty($errors) === false){
                                if(isset($errors) AND ! empty($errors)){
                                            echo '<div class="col-sm-6 form-box">
                                                <div class ="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert"> <i class="fa fa-times-circle-o"></i> </button>  ';    
                                                        foreach ($errors as $e){
                                                            echo $e . '<br />';
                                                        }
                                                 echo '  
                                                </div>
                                            </div> ';
                                }
                            }
                    ?>

                    <div class="row">
                        <div class="col-sm-6 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h2>Sign up now</h2>
                            		<p>Fill in the form below to set up your account:</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-pencil"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
			                    <form role="form" action="" method="post" class="registration-form">
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-first-name">First name</label>
			                        	<input type="text" name="form-first-name" placeholder="First name" class="form-first-name form-control" id="form-first-name"> 
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-last-name">Last name</label>
			                        	<input type="text" name="form-last-name" placeholder="Last name" class="form-last-name form-control" id="form-last-name">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-email">Email</label>
			                        	<input type="text" name="form-email" placeholder="Email" class="form-email form-control" id="form-email">
			                        </div>
                                    <div class="form-group">
			                        	<label class="sr-only" for="form-password">Password</label>
			                        	<input type="password" name="form-password" placeholder="Password" class="form-password form-control" id="form-password">
			                        </div>
                                    <div class="form-group">
			                        	<label class="sr-only" for="form-retypepassword">Re-Type Password</label>
			                        	<input type="password" name="form-retype-password" placeholder="Re-Type Password" class="form-retypepassword form-control" id="form-retypepassword">
		                                <button type="submit" class="btn signup">Sign Up</button>
                                        <p class="alread-have-account" ><a href="login.php">Already have an account? Sign In</a></p>
                                     </div>

			                    </form>
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