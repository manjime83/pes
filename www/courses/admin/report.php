<?php require_once('_security.php'); ?>
<?php require_once('../_config.php'); ?>
<?php require_once('../_header.php'); ?>
<?php require_once('_menu.php'); ?>
<h1>Report</h1>
<form action="report.php" method="get">
	<table>
		<tr>
			<th scope="row">Student Name</th>
			<td><select name="student_id" onchange="this.form.submit()">
					<option value="0">&nbsp;</option>
					<?php
					$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : 0;
					
					$query = sprintf("SELECT id, code, name FROM students ORDER BY name");
					$result = mysql_query($query) or die(mysql_error());
					
					while ($student = mysql_fetch_assoc($result)) :
					?>
					<option value="<?php echo htmlspecialchars($student['id']); ?>"<?php if ($student['id'] == $student_id) { echo ' selected="selected"'; } ?>><?php echo htmlspecialchars($student['code'] . ' - ' . $student['name']); ?></option>
					<?php
					endwhile;
					
					mysql_free_result($result);
					?>
				</select></td>
		</tr>
	</table>
</form>
<table>
	<tr>
		<th scope="col">Student Comment Datetime</th>
		<th scope="col">Lesson</th>
		<th scope="col">Student</th>
		<th scope="col">Student Comment</th>
		<th scope="col">Student Stars</th>
		<th scope="col">Teacher Comment Datetime</th>
		<th scope="col">Teacher</th>
		<th scope="col">Teacher Name</th>
		<th scope="col">Teacher Comment</th>
		<th scope="col">Student Attendance</th>
	</tr>
	<?php
	$query = sprintf("SELECT ts.student_comment_datetime, l.name AS lesson_name, ts.student_id, s.code AS student_code, s.name AS student_name, ts.student_comment, ts.student_stars, ts.teacher_comment_datetime, t.code AS teacher_code, t.name AS teacher_name, ts.teacher_name as teacher_comment_name, ts.teacher_comment, ts.student_attendance FROM teachers_schedules ts LEFT JOIN lessons l ON ts.lesson_id = l.id LEFT JOIN students s ON ts.student_id = s.id LEFT JOIN teachers t ON ts.teacher_id = t.id WHERE ts.student_id = %u ORDER BY ts.datetime", mysql_real_escape_string($student_id));
	$result = mysql_query($query) or die(mysql_error());
	while ($row = mysql_fetch_assoc($result)) :
	?>
	<tr>
		<td><?php echo htmlspecialchars($row['student_comment_datetime']); ?></td>
		<td><?php echo htmlspecialchars($row['lesson_name']); ?></td>
		<td><?php echo is_null($row['student_id'])  ? '&nbsp;' : htmlspecialchars($row['student_code'] . ' - ' . $row['student_name']); ?></td>
		<td><?php echo nl2br(htmlspecialchars($row['student_comment'])); ?></td>
		<td><?php for ($i = 0; $i < $row['student_stars']; $i++) : ?>
			<img src="../images/star.png" width="16" height="16" alt="*">
			<?php endfor; ?></td>
		<td><?php echo htmlspecialchars($row['teacher_comment_datetime']); ?></td>
		<td><?php echo htmlspecialchars($row['teacher_code'] . ' - ' . $row['teacher_name']); ?></td>
		<td><?php echo htmlspecialchars($row['teacher_comment_name']); ?></td>
		<td><?php echo nl2br(htmlspecialchars($row['teacher_comment'])); ?></td>
		<td><?php if (is_null($row['teacher_comment'])) : ?>
			&nbsp;
			<?php else : ?>
			<img src="../images/<?php echo htmlspecialchars($row['student_attendance'] ? 'accept' : 'cancel'); ?>.png" width="16" height="16" alt="<?php echo htmlspecialchars($row['student_attendance'] ? 'yes' : 'no'); ?>">
			<?php endif; ?></td>
	</tr>
	<?php
	endwhile;
	mysql_free_result($result);
	?>
</table>
<?php require_once('../_footer.php'); ?>