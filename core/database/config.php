<?php
$connect_error = 'Sorry for the inconvenience. Server will be up running shortly !!';

mysql_connect('localhost', 'root', 'password') or die($connect_error);
mysql_select_db('mock_exam_2016') or die($connect_error);

?>
