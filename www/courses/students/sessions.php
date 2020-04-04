<?php require_once('_security.php'); ?>

<?php require_once('../_config.php'); ?>

<?php require_once('../_header.php'); ?>

<?php require_once('_menu.php'); ?>

<h1>Sessions</h1>

<?php

$teacher_schedule = array();

$query = sprintf("SELECT ts.id, ts.datetime, ts.student_id, l.name AS lesson_name FROM teachers_schedules ts LEFT JOIN lessons l ON ts.lesson_id = l.id WHERE ts.datetime >= '%s' AND ts.teacher_id = %u ORDER BY ts.datetime",

	mysql_real_escape_string(gmdate('Y-m-d H:i', strtotime(date('Y-m-d')))),

	mysql_real_escape_string($_SESSION['student']['teacher_id'])

);

$result = mysql_query($query) or die(mysql_error());

while ($row = mysql_fetch_assoc($result)) {

	$datetime = date('Y-m-d H:i', strtotime($row['datetime'] . ' GMT'));

	unset($row['datetime']);

	$teacher_schedule[$datetime] = $row;

}

mysql_free_result($result);

// print_r($teacher_schedule);



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

		<td rowspan="<?php echo htmlspecialchars(count($times) + 1); ?>">&nbsp;</td>

		<th scope="col"><?php echo htmlspecialchars(date('l', strtotime($date))); ?><br />

			<?php echo htmlspecialchars(date('d-m-Y', strtotime($date))); ?></th>

		<?php endforeach; ?>

	</tr>

	<?php 

	$limit24 = date('Y-m-d H:i', mktime(date('H') + 12));

	$limit1 = date('Y-m-d H:i', mktime(date('H') + 1));

	$skip_cell = array();

	foreach ($times as $time) :

	?>

	<tr>

		<th scope="row"><?php echo htmlspecialchars(date('h:i a', strtotime($time))); ?></th>

		<?php

		foreach ($dates as $date) :

			$weekday = date('w', strtotime($date));

			$datetime = $date . ' ' . $time;

			

			if (in_array($datetime, $skip_cell)) {

				continue;

			}

			

			$is_scheduled = array_key_exists($datetime, $teacher_schedule);

			if ($is_scheduled) {

				$student_id = $teacher_schedule[$datetime]['student_id'];

				$lesson_name = $teacher_schedule[$datetime]['lesson_name'];

			} else {

				$student_id = NULL;

				$lesson_name = NULL;

			}

			

			if ($is_scheduled && $time != '23:30') {

				$rowspan = 2;

				$skip_cell[] = date('Y-m-d H:i', strtotime($datetime) + (60 * 30));

			} else {

				$rowspan = 1;

			}

		?>

		<td rowspan="<?php echo htmlspecialchars($rowspan); ?>" style="text-align: center; background-color: <?php echo htmlspecialchars($is_scheduled ? (is_null($student_id) ? 'Green' : ($student_id == $_SESSION['student']['id'] ? 'Yellow' : 'Red')) : ($weekday == 0 ? 'Gray' : 'Transparent')); ?>;"><?php if ($is_scheduled) : ?>

			<?php if (is_null($student_id)) : ?>

			<?php if ($datetime > $limit1 && $_SESSION['student']['is_active'] != 0) : ?>

			<a href="sessions_control.php?action=reserve&amp;id=<?php echo htmlspecialchars($teacher_schedule[$datetime]['id']); ?>"><img src="../images/clock_add.png" alt="schedule" width="16" height="16" align="absmiddle"></a>

			<?php else : ?>

			&nbsp;

			<?php endif; ?>

			<?php elseif ($student_id == $_SESSION['student']['id']) : ?>

			<?php echo htmlspecialchars($teacher_schedule[$datetime]['lesson_name']); ?>

			<?php if ($datetime > $limit24) : ?>

			<br />

			<a href="sessions_control.php?action=unschedule&amp;id=<?php echo htmlspecialchars($teacher_schedule[$datetime]['id']); ?>"><img src="../images/clock_delete.png" alt="schedule" width="16" height="16" align="absmiddle"></a>

			<?php endif; ?>

			<?php endif; ?>

			<?php else : ?>

			&nbsp;

			<?php endif; ?></td>

		<?php endforeach; ?>

	</tr>

	<?php endforeach; ?>

</table>

<?php require_once('../_footer.php'); ?>