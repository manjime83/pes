<?php

require_once('../_config.php');

require_once('_security.php');



$redirect = '';



mysql_connect(HOSTNAME, USERNAME, PASSWORD);

mysql_select_db(DATABASE);



$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');



switch ($action) {

	case 'reserve':

		if ($_SESSION['student']['is_active'] != 0) {

			$id = $_GET['id'];

			

			$query = sprintf("SELECT datetime FROM teachers_schedules WHERE id = %u AND teacher_id = %u",

				mysql_real_escape_string($id),

				mysql_real_escape_string($_SESSION['student']['teacher_id'])

			);

			$result = mysql_query($query) or die(mysql_error());

			$row = mysql_fetch_assoc($result);

			mysql_free_result($result);

			

			$datetime = $row['datetime'];

			

			$limit = gmdate('Y-m-d H:i', gmmktime(gmdate('H') + 1));

			

			if ($datetime > $limit) {

				$datetime_offset = 60 * 60 * 36;

				$datetime1 = strtotime($datetime . 'GMT') - $datetime_offset;

				$datetime2 = strtotime($datetime . 'GMT') + $datetime_offset;

				

				$query = sprintf("SELECT COUNT(*) AS teachers_schedules_count FROM teachers_schedules WHERE teacher_id = %u AND student_id = %u AND '%s' < datetime AND datetime < '%s'",

					mysql_real_escape_string($_SESSION['student']['teacher_id']),

					mysql_real_escape_string($_SESSION['student']['id']),

					mysql_real_escape_string(gmdate('Y-m-d H:i', $datetime1)),

					mysql_real_escape_string(gmdate('Y-m-d H:i', $datetime2))

				);

				$result = mysql_query($query) or die(mysql_error());

				$row = mysql_fetch_assoc($result);

				mysql_free_result($result);

				

				if ($row['teachers_schedules_count'] == 0) {

					$query = sprintf("SELECT MAX(lesson_id) AS lesson_id FROM teachers_schedules WHERE datetime < '%s' AND teacher_id = %u AND student_id = %u",

						mysql_real_escape_string($datetime),

						mysql_real_escape_string($_SESSION['student']['teacher_id']),

						mysql_real_escape_string($_SESSION['student']['id'])

					);

					$result = mysql_query($query) or die(mysql_error());

					$row = mysql_fetch_assoc($result);

					mysql_free_result($result);

					

					$lesson_id = $row['lesson_id'];

					

					if ($lesson_id == '') {

						$query = sprintf("SELECT id FROM lessons ORDER BY id LIMIT 1",

							mysql_real_escape_string($lesson_id)

						);

						$result = mysql_query($query) or die(mysql_error());

						$row = mysql_fetch_assoc($result);

						mysql_free_result($result);

						

						$next_lesson_id = $row['id'];

					} else {

						$query = sprintf("SELECT id FROM lessons WHERE id = %u + 1",

							mysql_real_escape_string($lesson_id)

						);

						$result = mysql_query($query) or die(mysql_error());

						$row = mysql_fetch_assoc($result);

						mysql_free_result($result);

						

						if ($row) {

							$next_lesson_id = $row['id'];

						} else {

							$next_lesson_id = 0;

						}

					}

					

					if ($next_lesson_id > 0) {

						$query = sprintf("UPDATE teachers_schedules SET student_id = %u, lesson_id = %u WHERE id = %u AND teacher_id = %u",

							mysql_real_escape_string($_SESSION['student']['id']),

							mysql_real_escape_string($next_lesson_id),

							mysql_real_escape_string($id),

							mysql_real_escape_string($_SESSION['student']['teacher_id'])

						);

						$result = mysql_query($query) or die(mysql_error());

						

						$query = sprintf("UPDATE teachers_schedules SET lesson_id = lesson_id + 1 WHERE datetime > '%s' AND teacher_id = %u AND student_id = %u",

							mysql_real_escape_string($datetime),

							mysql_real_escape_string($_SESSION['student']['teacher_id']),

							mysql_real_escape_string($_SESSION['student']['id'])

						);

						$result = mysql_query($query) or die(mysql_error());

						

						$query = sprintf("SELECT id FROM lessons ORDER BY id DESC LIMIT 1",

							mysql_real_escape_string($lesson_id)

						);

						$result = mysql_query($query) or die(mysql_error());

						$row = mysql_fetch_assoc($result);

						mysql_free_result($result);

						

						$last_lesson_id = $row['id'];

						

						$query = sprintf("UPDATE teachers_schedules SET student_id = NULL, lesson_id = NULL WHERE teacher_id = %u AND student_id = %u AND lesson_id = %u",

							mysql_real_escape_string($_SESSION['student']['teacher_id']),

							mysql_real_escape_string($_SESSION['student']['id']),

							mysql_real_escape_string($last_lesson_id + 1)

						);

						$result = mysql_query($query) or die(mysql_error());

					}

				}

			}

		}

		

		$redirect = 'sessions.php';

		

		break;



	case 'unschedule':

		$id = $_GET['id'];

		

		$query = sprintf("SELECT datetime FROM teachers_schedules WHERE id = %u AND teacher_id = %u AND student_id = %u",

			mysql_real_escape_string($id),

			mysql_real_escape_string($_SESSION['student']['teacher_id']),

			mysql_real_escape_string($_SESSION['student']['id'])

		);

		$result = mysql_query($query) or die(mysql_error());

		$row = mysql_fetch_assoc($result);

		mysql_free_result($result);

		

		$datetime = $row['datetime'];

		

		$limit = gmdate('Y-m-d H:i', gmmktime(gmdate('H') + 12));

		

		if ($datetime > $limit) {

			$query = sprintf("UPDATE teachers_schedules SET student_id = NULL, lesson_id = NULL WHERE id = %u AND teacher_id = %u AND student_id = %u",

				mysql_real_escape_string($id),

				mysql_real_escape_string($_SESSION['student']['teacher_id']),

				mysql_real_escape_string($_SESSION['student']['id'])

			);

			$result = mysql_query($query) or die(mysql_error());

			

			$query = sprintf("UPDATE teachers_schedules SET lesson_id = lesson_id - 1 WHERE datetime > '%s' AND teacher_id = %u AND student_id = %u",

				mysql_real_escape_string($datetime),

				mysql_real_escape_string($_SESSION['student']['teacher_id']),

				mysql_real_escape_string($_SESSION['student']['id'])

			);

			$result = mysql_query($query) or die(mysql_error());

		}

		

		$redirect = 'sessions.php';

		break;

}



mysql_close();



header('Location: ' . $redirect);

?>