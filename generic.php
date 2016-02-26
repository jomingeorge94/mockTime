<!DOCTYPE html>
<html lang="en">

<?php include 'core/session.php'; ?>

<?php include 'includes/head.php'; ?>

<body>


<?php   
    if (user_logged_in() === true){
         include 'includes/navigationloggedin.php'; 
    }else{
        include 'includes/navigation_modified.php'; 
    }

?>   
    <!-- Page Content -->
    <div class="container generic">

        <div class="row">
            <div class="col-lg-12 text-left">
                <h1>OOps !! Something went wrong. </h1>
                <p class="lead">You need to be logged into the website to access that page</p>
                <p class="lead">Please Register or Log in</p>
            </div>
        </div>

    </div>

    <!-- Footer of the site -->
    <?php include 'includes/footer.php'; ?>    
    <!-- /.container -->

</body>

</html>