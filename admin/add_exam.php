<?php include '../core/session.php'; ?>

<?php admin_protect (); 

if (isset($_POST['editexam']) && isset($_POST['editexamnameuservalue'])) {
	add_new_exam($_POST['editexam'], $_POST['editexamnameuservalue']); // show me this function.
	echo 200;
}

?>