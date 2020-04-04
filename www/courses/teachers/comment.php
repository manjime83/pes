<?php require_once('_security.php'); ?>
<?php require_once('../_config.php'); ?>
<?php require_once('../_header.php'); ?>
<?php require_once('_menu.php'); ?>
<?php
$id = isset($_GET['id']) ? $_GET['id'] : 0;

$query = sprintf("SELECT ts.id, l.name AS lesson_name, teacher_comment, teacher_comment_datetime, teacher_name, student_attendance FROM teachers_schedules ts LEFT JOIN lessons l ON ts.lesson_id = l.id WHERE ts.id = %u",
	mysql_real_escape_string($id)
);
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($result);
mysql_free_result($result);
?>
<h1>Comment Lesson <?php echo htmlspecialchars($row['lesson_name']); ?></h1>
<table>
	<tr>
		<th scope="row">Comment</th>
		<td><?php echo nl2br(htmlspecialchars($row['teacher_comment'])); ?></td>
	</tr>
	<tr>
		<th scope="row">Comment Date</th>
		<td><?php echo htmlspecialchars($row['teacher_comment_datetime']); ?></td>
	</tr>
	<tr>
		<th scope="row">Name</th>
		<td><?php echo htmlspecialchars($row['teacher_name']); ?></td>
	</tr>
	<tr>
		<th scope="row">Student Attendance</th>
		<td><img src="../images/<?php echo htmlspecialchars($row['student_attendance'] ? 'accept' : 'cancel'); ?>.png" width="16" height="16" alt="<?php echo htmlspecialchars($row['student_attendance'] ? 'yes' : 'no'); ?>"></td>
	</tr>
</table>
<?php require_once('../_footer.php'); ?>