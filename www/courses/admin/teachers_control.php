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
		$nickname = $_POST['nickname'];
		
		$query = sprintf("INSERT INTO teachers SET email = '%s', password = MD5('%s'), code = '%s', name = '%s', timezone = '%s', nickname = '%s'",
			mysql_real_escape_string($email),
			mysql_real_escape_string($password),
			mysql_real_escape_string($code),
			mysql_real_escape_string($name),
			mysql_real_escape_string($timezone),
			mysql_real_escape_string($nickname)
		);
		$result = mysql_query($query) or die(mysql_error());
		
		$redirect = 'teachers.php';
		break;
	
	case 'update':
		$id = $_POST['id'];
		$email = $_POST['email'];
		$code = $_POST['code'];
		$name = $_POST['name'];
		$timezone = $_POST['timezone'];
		$nickname = $_POST['nickname'];
		
		$query = sprintf("UPDATE teachers SET email = '%s', code = '%s', name = '%s', timezone = '%s', nickname = '%s' WHERE id = %u",
			mysql_real_escape_string($email),
			mysql_real_escape_string($code),
			mysql_real_escape_string($name),
			mysql_real_escape_string($timezone),
			mysql_real_escape_string($nickname),
			mysql_real_escape_string($id)
		);
		$result = mysql_query($query) or die(mysql_error());
		
		$redirect = 'teachers.php';
		break;
		
	case 'add_teacher_schedule':
		$id = $_POST['id'];
		$date = $_POST['date'];
		$time = $_POST['time'];
		
		$datetime = strtotime($date . ' ' . $time);
		$datetime_offset = 60 * 60;
		$datetime1 = $datetime - $datetime_offset;
		$datetime2 = $datetime + $datetime_offset;
		
		$query = sprintf("SELECT COUNT(*) AS teachers_schedules_count FROM teachers_schedules WHERE teacher_id = %u AND '%s' < datetime AND datetime < '%s'",
			mysql_real_escape_string($id),
			mysql_real_escape_string(gmdate('Y-m-d H:i', $datetime1)),
			mysql_real_escape_string(gmdate('Y-m-d H:i', $datetime2))
		);
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_assoc($result);
		mysql_free_result($result);
		
		if ($row['teachers_schedules_count'] == 0) {
			if ($datetime > time()) {
				$query = sprintf("INSERT INTO teachers_schedules SET teacher_id = %u, datetime = '%s'",
					mysql_real_escape_string($id),
					mysql_real_escape_string(gmdate('Y-m-d H:i', $datetime))
				);
				
				$result = mysql_query($query) or die(mysql_error());
			}
		}

		$redirect = 'teachers_schedule.php?id=' . $id . '&date=' . $date . '&time=' . $time;
		break;
		
	case 'delete_teacher_schedule':
		$teacher_id = $_GET['teacher_id'];
		$id = $_GET['id'];

		$query = sprintf("DELETE FROM teachers_schedules WHERE id = %u AND teacher_id = %u",
			mysql_real_escape_string($id),
			mysql_real_escape_string($teacher_id)
		);
		
		$result = mysql_query($query) or die(mysql_error());

		$redirect = 'teachers_schedule.php?id=' . $teacher_id;
		break;

	case 'delete':
		$id = $_GET['id'];
		
		$query = sprintf("DELETE FROM teachers_schedules WHERE teacher_id = %u",
			mysql_real_escape_string($id)
		);
		$result = mysql_query($query) or die(mysql_error());
		
		$query = sprintf("DELETE FROM teachers WHERE id = %u",
			mysql_real_escape_string($id)
		);
		$result = mysql_query($query) or die(mysql_error());
		
		$redirect = 'teachers.php';
		break;
}

mysql_close();

header('Location: ' . $redirect);
?>