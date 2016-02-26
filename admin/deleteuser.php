<?php include '../core/session.php'; ?>

<?php admin_protect (); 

if (isset($_POST['deletefunction'])) {
	delete_user($_POST['deletefunction']);
	echo 200;
}

?>