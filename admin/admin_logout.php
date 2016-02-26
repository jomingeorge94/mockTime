<?php
include '../core/session.php';

unset_password_check($user_data['user_id']);
header('Location: /mocktime/admin');


?>