<?php include '../core/session.php'; ?>

<?php admin_protect (); 

if (isset($_POST['edituservalue']) && isset($_POST['editcategory'])) {
	add_new_category($_POST['editcategory'], $_POST['edituservalue']); // show me this function.
	echo 200;
}

?>