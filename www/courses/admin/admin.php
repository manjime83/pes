<?php require_once('_security.php'); ?>

<?php require_once('../_config.php'); ?>

<?php require_once('../_header.php'); ?>

<?php require_once('_menu.php'); ?>

<?php

$teachers = array();

$query = sprintf("SELECT id, code, name FROM teachers ORDER BY name");

$result = mysql_query($query) or die(mysql_error());

while ($row = mysql_fetch_assoc($result)) {

	$teachers[] = $row;

}

mysql_free_result($result);



$teachers_schedules = array();

$query = sprintf("SELECT ts.id, ts.teacher_id, ts.datetime, ts.student_id, s.code AS student_code, l.name AS lesson_name FROM teachers_schedules ts LEFT JOIN students s ON ts.student_id = s.id LEFT JOIN lessons l ON ts.lesson_id = l.id WHERE ts.datetime >= '%s' ORDER BY ts.datetime",

	mysql_real_escape_string(gmdate('Y-m-d H:i', strtotime(date('Y-m-d'))))

);

$result = mysql_query($query) or die(mysql_error());

while ($row = mysql_fetch_assoc($result)) {

	$teacher_id = $row['teacher_id'];

	unset($row['teacher_id']);

	$datetime = date('Y-m-d H:i', strtotime($row['datetime'] . ' GMT'));

	unset($row['datetime']);

	$teachers_schedules[$teacher_id][$datetime] = $row;

}

mysql_free_result($result);

// print_r($teachers_schedules);



$dates = array();

for ($i = 0; $i < 15; $i++) {

	$dates[] = date('Y-m-d', mktime(0, 0, 0, date('n'), date('j') + $i));

}



$times = array();

for ($i = 0; $i < 48; $i++) {

	$times[] = date('H:i', mktime(0, $i * 30));

}

?>

<table border="1">

	<tr>

		<td>&nbsp;</td>

		<?php foreach ($dates as $date) : ?>

		<td rowspan="<?php echo htmlspecialchars(count($times) + 2); ?>">&nbsp;</td>

		<th colspan="<?php echo htmlspecialchars(count($teachers)); ?>" scope="col"><?php echo htmlspecialchars(date('l', strtotime($date))); ?><br />

			<?php echo htmlspecialchars(date('d-m-Y', strtotime($date))); ?></th>

		<?php endforeach; ?>

	</tr>

	<?php 

	$skip_cell = array();

	foreach ($times as $time) :

	?>

	<tr>

		<th scope="row"><?php echo htmlspecialchars(date('h:i a', strtotime($time))); ?></th>

		<?php

		foreach ($dates as $date) :

			$weekday = date('w', strtotime($date));

			$datetime = $date . ' ' . $time;

			

			foreach ($teachers as $teacher) :

				if (array_key_exists($teacher['id'], $skip_cell) && in_array($datetime, $skip_cell[$teacher['id']])) {

					continue;

				}

				

				$is_scheduled = FALSE;

				$student_id = NULL;

				$student_code = NULL;

				$lesson_name = NULL;



				if (array_key_exists($teacher['id'], $teachers_schedules)) {

					$is_scheduled = array_key_exists($datetime, $teachers_schedules[$teacher['id']]);

					if ($is_scheduled) {

						$student_id = $teachers_schedules[$teacher['id']][$datetime]['student_id'];

						$student_code = $teachers_schedules[$teacher['id']][$datetime]['student_code'];

						$lesson_name = $teachers_schedules[$teacher['id']][$datetime]['lesson_name'];

					}

				}

				

				if ($is_scheduled && $time != '23:30') {

					$rowspan = 2;

					$skip_cell[$teacher['id']][] = date('Y-m-d H:i', strtotime($datetime) + (60 * 30));

				} else {

					$rowspan = 1;

				}

		?>

		<td rowspan="<?php echo htmlspecialchars($rowspan); ?>" style="text-align: center; background-color: <?php echo htmlspecialchars($is_scheduled ? (is_null($student_id) ? 'Green' : 'Red') : ($weekday == 0 ? 'Gray' : 'Transparent')); ?>;"><?php if (!is_null($student_id)) : ?><?php echo htmlspecialchars($student_code); ?><br /><?php echo htmlspecialchars($lesson_name); ?><?php else : ?>&nbsp;<?php endif; ?></td>

		<?php

			endforeach;

		endforeach;

		?>

	</tr>

	<?php endforeach; ?>

	<tr>

		<td>&nbsp;</td>

		<?php

		foreach ($dates as $date) :

			foreach ($teachers as $teacher) :

		?>

		<th scope="col"><?php echo htmlspecialchars($teacher['code']); ?></th>

		<?php

			endforeach;

		endforeach;

		?>

	</tr>

</table>

<?php require_once('../_footer.php'); ?>