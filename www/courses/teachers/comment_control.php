<?php
require_once('../_config.php');
require_once('_security.php');

$redirect = '';

mysql_connect(HOSTNAME, USERNAME, PASSWORD);
mysql_select_db(DATABASE);

$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');

switch ($action) {
	case 'add':
		$id = $_POST['id'];
		
		$query = sprintf("SELECT teacher_comment FROM teachers_schedules WHERE id = %u AND teacher_id = %u",
			mysql_real_escape_string($id),
			mysql_real_escape_string($_SESSION['teacher']['id'])
		);
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_assoc($result);
		mysql_free_result($result);
		
		$teacher_comment = $row['teacher_comment'];
		
		if (is_null($teacher_comment)) {
			$query = sprintf("UPDATE teachers_schedules SET teacher_comment = '%s', teacher_comment_datetime = '%s', teacher_name = '%s', student_attendance = %u WHERE id = %u AND teacher_id = %u",
				mysql_real_escape_string($_POST['teacher_comment']),
				mysql_real_escape_string(gmdate('Y-m-d H:i:s')),
				mysql_real_escape_string($_POST['teacher_name']),
				mysql_real_escape_string($_POST['student_attendance']),
				mysql_real_escape_string($id),
				mysql_real_escape_string($_SESSION['teacher']['id'])
			);
			$result = mysql_query($query) or die(mysql_error());
		}
	
		$redirect = 'teacher.php';
		
		break;
}

mysql_close();

header('Location: ' . $redirect);
?>