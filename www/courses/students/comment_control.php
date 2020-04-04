<?php
require_once('../_config.php');
require_once('_security.php');

$redirect = '';

mysql_connect(HOSTNAME, USERNAME, PASSWORD);
mysql_select_db(DATABASE);

$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');

switch ($action) {
	case 'add':
		if ($_SESSION['student']['is_active'] != 0) {
			$id = $_POST['id'];
			
			$query = sprintf("SELECT student_comment FROM teachers_schedules WHERE id = %u AND teacher_id = %u",
				mysql_real_escape_string($id),
				mysql_real_escape_string($_SESSION['student']['teacher_id'])
			);
			$result = mysql_query($query) or die(mysql_error());
			$row = mysql_fetch_assoc($result);
			mysql_free_result($result);
			
			$student_comment = $row['student_comment'];
			
			if (is_null($student_comment)) {
				$query = sprintf("UPDATE teachers_schedules SET student_comment = '%s', student_comment_datetime = '%s', student_stars = %u WHERE id = %u AND teacher_id = %u",
					mysql_real_escape_string($_POST['student_comment']),
					mysql_real_escape_string(gmdate('Y-m-d H:i:s')),
					mysql_real_escape_string($_POST['student_stars']),
					mysql_real_escape_string($id),
					mysql_real_escape_string($_SESSION['student']['teacher_id'])
				);
				$result = mysql_query($query) or die(mysql_error());
			}
		}
		
		$redirect = 'student.php';
		
		break;
}

mysql_close();

header('Location: ' . $redirect);
?>