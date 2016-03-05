<?php include '../core/session.php'; ?>

<?php admin_protect (); 

if (isset($_POST['deletecategoryfunction'])) {
	delete_category($_POST['deletecategoryfunction']);
	echo 200;
}

?>