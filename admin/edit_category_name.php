<?php include '../core/session.php'; ?>

<?php admin_protect (); 

if (isset($_POST['edituservalue']) && isset($_POST['editcategory'])) {
	change_category_name($_POST['editcategory'], $_POST['edituservalue']); // show me this function.
	echo 200;
}

?>