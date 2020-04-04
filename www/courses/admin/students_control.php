<?php
require_once('../_config.php');
require_once('_security.php');

$redirect = '';

mysql_connect(HOSTNAME, USERNAME, PASSWORD);
mysql_select_db(DATABASE);

$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');

switch ($action) {
	case 'add':
		$email = $_POST['email'];
		$password = $_POST['password'];
		$code = $_POST['code'];
		$name = $_POST['name'];
		$timezone = $_POST['timezone'];
		$teacher_id = $_POST['teacher_id'];
		
		$query = sprintf("INSERT INTO students SET email = '%s', password = MD5('%s'), code = '%s', name = '%s', timezone = '%s', teacher_id = %u, is_active = 1",
			mysql_real_escape_string($email),
			mysql_real_escape_string($password),
			mysql_real_escape_string($code),
			mysql_real_escape_string($name),
			mysql_real_escape_string($timezone),
			mysql_real_escape_string($teacher_id)
		);
		$result = mysql_query($query) or die(mysql_error());
		
		$redirect = 'students.php';
		break;
	
	case 'update':
		$id = $_POST['id'];
		$email = $_POST['email'];
		$code = $_POST['code'];
		$name = $_POST['name'];
		$timezone = $_POST['timezone'];
		$teacher_id = $_POST['teacher_id'];
		
		$query = sprintf("UPDATE students SET email = '%s', code = '%s', name = '%s', timezone = '%s', teacher_id = %u WHERE id = %u",
			mysql_real_escape_string($email),
			mysql_real_escape_string($code),
			mysql_real_escape_string($name),
			mysql_real_escape_string($timezone),
			mysql_real_escape_string($teacher_id),
			mysql_real_escape_string($id)
		);
		$result = mysql_query($query) or die(mysql_error());
		
		$redirect = 'students.php';
		break;

	case 'delete':
		$id = $_GET['id'];
		
		$query = sprintf("UPDATE teachers_schedule SET student_id = NULL, lesson_id = NULL WHERE student_id = %u",
			mysql_real_escape_string($id)
		);
		$result = mysql_query($query) or die(mysql_error());
		
		$query = sprintf("DELETE FROM students WHERE id = %u",
			mysql_real_escape_string($id)
		);
		$result = mysql_query($query) or die(mysql_error());
		
		$redirect = 'students.php';
		break;
	
	case 'activate':
		$id = $_GET['id'];
		
		$query = sprintf("UPDATE students SET is_active = 1 WHERE id = %u",
			mysql_real_escape_string($id)
		);
		$result = mysql_query($query) or die(mysql_error());
		
		$redirect = 'students.php';
		break;
		
	case 'deactivate':
		$id = $_GET['id'];
		
		$query = sprintf("UPDATE students SET is_active = 0 WHERE id = %u",
			mysql_real_escape_string($id)
		);
		$result = mysql_query($query) or die(mysql_error());
		
		$redirect = 'students.php';
		break;
}

mysql_close();

header('Location: ' . $redirect);
?>