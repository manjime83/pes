<?php
require_once('../config.php');

$redirect = '';

mysql_connect(HOSTNAME, USERNAME, PASSWORD);
mysql_select_db(DATABASE);

$action = $_POST['action'];

switch ($action) {
	case "login":
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		$query = sprintf("SELECT * FROM students WHERE email = '%s' LIMIT 1", mysql_real_escape_string($email));
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_assoc($result);
		mysql_free_result($result);
		
		if ($row) {
			
		} else {
			$location = 'index.php';
		}
		
		break;
}

mysql_close();

header('Location: ' . $redirect);
?>