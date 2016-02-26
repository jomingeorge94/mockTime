<!DOCTYPE html>
<html lang="en">

<?php include 'core/session.php'; ?>

<?php include 'includes/head.php'; ?>


    



<?php   
    if (user_logged_in() === true){
         include 'includes/navigationloggedin.php'; 
    }else{
        include 'includes/navigation.php'; 
    }
?>   
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">    

    <!-- Intro Section -->
    <?php include 'includes/homescreen.php'; ?>

    <!-- About Section -->
    <?php include 'includes/aboutscreen.php'; ?>

    <!-- FAQ Section -->
    <?php include 'includes/faqscreen.php'; ?>

    <!-- Contact Section -->
    <?php include 'includes/contactscreen.php'; ?>


    <!-- Footer of the site -->
    <?php include 'includes/footer.php'; ?>    
    <!-- /.container -->

    <!-- Scrolling Nav JavaScript -->
    <script src="assets/js/jquery.easing.min.js"></script>
    <script src="assets/js/scrolling-nav.js"></script>


    <!-- Contact Form JavaScript -->
    <script src="assets/js/jqBootstrapValidation.js"></script>
    <script src="assets/js/contact_me.js"></script>

</body>

</html>