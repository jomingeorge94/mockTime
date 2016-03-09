<?php include '../core/session.php'; ?>

<?php admin_protect (); 

if (isset($_POST['deleteexamfunction'])) {

	delete_exam($_POST['deleteexamfunction']);
	echo 200;
}

?>