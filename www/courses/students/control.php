<?php
require_once('../_config.php');
session_start();

$redirect = '';

mysql_connect(HOSTNAME, USERNAME, PASSWORD);
mysql_select_db(DATABASE);

$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');

switch ($action) {
	case 'login':
		$email = $_POST['email'];
		$password = $_POST['password'];
		$uri = $_POST['uri'];
		
		$query = sprintf("SELECT id, email, name, timezone, teacher_id, is_active FROM students WHERE email = '%s' AND password = MD5('%s')",
			mysql_real_escape_string($email),
			mysql_real_escape_string($password)
		);
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_assoc($result);
		mysql_free_result($result);
		
		if ($row) {
			$_SESSION['student'] = array();
			$_SESSION['student']['logged_in'] = TRUE;
			$_SESSION['student'] = array_merge($_SESSION['student'], $row);
			
			if ($uri == '') {
				$redirect = 'online.php';
			} else {
				$redirect = $uri;
			}
		} else {
			session_unset();
			if ($uri == '') {
				$redirect = 'index.php?msg=login';
			} else {
				$redirect = 'index.php?msg=login&uri=' . urlencode($uri);
			}
		}
		
		break;
		
	case 'logout':
		session_unset();
		$redirect = 'index.php';
		
		break;
}

mysql_close();

header('Location: ' . $redirect);
?>