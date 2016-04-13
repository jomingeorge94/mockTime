<!DOCTYPE html>
<html lang="en">
<?php 
ob_start();
    include 'core/session.php';
    include 'includes/head.php';

    if (user_logged_in() === true){
        updateLastSeenUser($_SESSION['user_id']);
        include 'includes/navigationloggedinmodified.php';
?>

    <?php 

                //checking if the user has actually chosen an image
                    if(empty($_FILES['profile']['name']) === false)  {
                        //allowed image formats
                        $allowed = array('jpg', 'png', 'jpeg', 'gif'); 
                        //name of the file the user has chosen
                        $file_name = $_FILES['profile']['name'];
                        //this is where the file will be saved temporarily
                        $file_temp = $_FILES['profile']['tmp_name'];
                        //file size of the chosen image
                        $file_size = $_FILES['profile']['size'];
                        //setting maximum file size
                        $max_file_size = 2000000;
                        //exploding the file
                        $file_explode = strtolower(end(explode('.', $file_name)));

                            //checking if the file type is in the allowed array 
                            if (in_array($file_explode, $allowed) === true) {
                                //checking to see if the file size is less than the maximum file size limit, if it is go ahead with chaging the picture and redirect user back to the current page
                                if($file_size < $max_file_size){ 
                                    change_profile_image($session_user_id, $file_temp, $file_explode); 
                                } else {
                                    //error will be displayed    
                                    $errors[] = '<strong> File Size Limit Exceeded </strong> <br /> File size should be no more than 2 MB';
                                }
                            //error showing what image formats are allowed    
                            } 
                            else {
                                $errors[] = '      
                                    <strong> Image Format </strong> <br /> Incorrect Image Format, only allow: jpg, png, jpeg and gif';
                            }
                    }
                    //check to ensure that the email address is always selected within the post and that it cannot be changeable
                    $fields_required = array('form-email-address');
                    foreach ($_POST as $key => $value) {
                        //if there is an empty value in the fields required then this condition will be applied
                        if (empty($value) && in_array($key, $fields_required) === true){
                            $errors[] = 'Field marked with an asterisk is required';
                            //break out of the loop and continue with the execution 
                            break 1; 

                        }
                    }
                    //if the post is submitted and there is no errors within the error array then update user details on the database
                    if (empty($_POST) === false && empty($errors) === true) {
                        //update user details
                        $update_data = array (
                            'first_name' => htmlspecialchars($_POST['form-first-name']),
                            'last_name' => htmlspecialchars($_POST['form-last-name'])
                        );
                        //updating details on the database
                        update_user($update_data);
                        //refreshing the page to show the latest details of the user
                        header('Location: userprofile.php');
                        exit();
                    //if there is any errors display to the user    
                    } else {
                        // output the errors
                        foreach($errors as $errors){
                          echo '<div class="col-sm-6 form-box">
                                <div class ="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert"> <i class="fa fa-times-circle-o"></i> </button>      
                                ' . $errors  . '
                                </div>
                                </div>';  
                        } 
                    }

    ?>

    <body>

        <div class="container profile">
            <div class="row">
                <div class="col-lg-12 text-left">
                    <div class="panel panel-default manageprofile">
                        <div class="panel-heading"><span class="glyphicon glyphicon-edit"></span><strong class="profiletitle">User Profile</strong></div>
                            <div class="panel-body">
                                <form action="" method="post" enctype="multipart/form-data">

                                <div class="form-group row">
                                    <div class="profile-pic">
                                        <?php
                                            //if the profile picture is not empty then output the picture 
                                            if (empty($user_data['profile_picture']) === false) {
                                                echo '<img src="', $user_data['profile_picture'], '" alt="', $user_data['first_name'], '\'s Profile Picture" /> ';
                                               
                                            } else {
                                                echo '<img src="images/standard.png" alt="" /> ';
                                            }
                                        ?>
                                    </div>
                                    <div class="fileupload">
                                        <span class="btn btn-default btn-file">
                                            Change Picture <input type="file" clas ="file" name="profile">

                                        </span>
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 form-control-label">First Name: </label>
                                        <div class="col-sm-7">
                                            <input type="text" value ="<?php echo $user_data['first_name'];?>" name ="form-first-name" class="form-control" id="inputEmail3" placeholder="First Name">
                                        </div>
                                  </div>

                                  <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 form-control-label">Last Name: </label>
                                        <div class="col-sm-7">
                                            <input type="text" value ="<?php echo $user_data['last_name'];?>" name = "form-last-name" class="form-control" id="inputEmail3" placeholder="Last Name">
                                        </div>
                                  </div>

                                  <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 form-control-label">* Email: </label>
                                        <div class="col-sm-7">
                                            <input type="email" value ="<?php echo $user_data['email_address'];?>" class="form-control" name="form-email-address" id="inputEmail3" placeholder="Email Address" readonly>
                                        </div>
                                  </div>
                                      
                                      <div class="form-group row">
                                        <div class="col-sm-offset-3 col-sm-10">
                                          <button type="submit" class="btn btn-secondary">Update</button>
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