<!DOCTYPE html>
<html lang="en">
<?php 
    include 'core/session.php';
    include 'includes/head.php';

        //checks for what the user is submitting 
        if (empty($_POST) === false){
                    $fields_required = array('oldpassword', 'newpassword', 'newpasswordagain');
                    foreach ($_POST as $key => $value) {
                        //if there is an empty value in the fields required then this condition will be applied
                        if (empty($value) && in_array($key, $fields_required) === true){
                            $errors[] = 'All fields are required';
                            //break out of the loop and continue with the execution 
                            break 1; 
                        }
                    }
                    //checking if the current password user types is the correct one on the database
                    if(md5($_POST['oldpassword']) === $user_data['password']) {
                        //checking if the new password and confirm password are same
                        if(trim($_POST['newpassword']) !== trim($_POST['newpasswordagain'])) {
                            $errors[] = 'Your new passwords do not match';
                        } 
                        else if(strlen($_POST['newpassword']) <8) {
                            $errors[] = 'Your password must be at least 8 characters';
                        } 
                    } else {
                        $errors[] = 'Your current password is incorrect !';
                    }
        }

        //checking for whether if it is success or force
        if(isset($_GET['success']) === true && empty($_GET['success']) == true){
           
            echo '<div class="col-sm-6 form-box profilechange">
                    <div class ="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert"> <i class="fa fa-times-circle-o"></i> </button>  ';    
                             echo '<strong>Your password has been changed</strong>';
                            echo '  
                    </div>
                </div> ';
        } 
        else {

            //if it's force then this error message will be output on the screen 
            if (isset($_GET['force']) === true && empty($_GET['force']) === true){
                ?>
                <div class ="col-sm-6 form-box alert alert-info alert-dismissable profilechange">
                        <button type="button" class="close" data-dismiss="alert"> <i class="fa fa-times-circle-o"></i> </button> 
                            <strong><p>You must change your password now that you've requested.</p><strong>
                </div>
                <?php
            }
        }


    if (empty($_POST) === false && empty($errors) === true) {
            //change the password and then redirect the user to profile.php?success
            change_password($session_user_id, $_POST['newpassword']);
            header('Location: profile.php?success');

        //output errors on the screen
        } else if (empty($errors) === false){
            if(isset($errors) AND ! empty($errors)){
                        echo '<div class="col-sm-6 form-box profileerror">
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
        
        if (user_logged_in() === true){
             include 'includes/navigationloggedinmodified.php';
 
?>
<body>
    <div class="container profile">
        <div class="row">
            <div class="col-lg-12 text-left">
                <div class="panel panel-default manageprofile">
                    <div class="panel-heading"><span class="glyphicon glyphicon-edit"></span><strong class="profiletitle">Change Password</strong></div>
                        <div class="panel-body">
                            <form action="" method="POST">

                            <!-- <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 form-control-label">First Name: </label>
                                    <div class="col-sm-7">
                                        <input type="text" value ="<?php echo $user_data['first_name'];?>" class="form-control" id="inputEmail3" placeholder="First Name">
                                    </div>
                              </div>

                              <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 form-control-label">Last Name: </label>
                                    <div class="col-sm-7">
                                        <input type="text" value ="<?php echo $user_data['last_name'];?>" class="form-control" id="inputEmail3" placeholder="Last Name">
                                    </div>
                              </div>

                              <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 form-control-label">Email: </label>
                                    <div class="col-sm-7">
                                        <input type="email" value ="<?php echo $user_data['email_address'];?>" class="form-control" id="inputEmail3" placeholder="Email Address">
                                    </div>
                              </div> -->
                                  <div class="form-group row password">
                                    <label for="inputPassword3" class="col-sm-3 form-control-label">Current Password: </label>
                                        <div class="col-sm-7">
                                            <input type="password" class="form-control" name="oldpassword" placeholder="Current Password">
                                        </div>
                                  </div>
                                  <div class="form-group row password">
                                  <label for="inputPassword3" class="col-sm-3 form-control-label">New Password: </label>
                                        <div class="col-sm-7">
                                            <input type="password" class="form-control" name="newpassword" placeholder="New Password">
                                        </div>
                                  </div>
                                  <div class="form-group row password">
                                    <label for="inputPassword2" class="col-sm-3 form-control-label">Confirm Password: </label>
                                        <div class="col-sm-7">
                                            <input type="password" class="form-control" name="newpasswordagain" placeholder="Confirm Password">
                                        </div>
                                  </div>
                                  <div class="form-group row">
                                    <div class="col-sm-offset-3 col-sm-10">
                                      <button type="submit" class="btn btn-secondary">Submit</button>
                                    </div>
                                  </div>

                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
<?php
    }else{
        include 'includes/navigation_modified.php'; 
        header('Location: generic.php');
            exit();
        
    }
    include 'includes/footer.php';
?> 
</body>
</html>