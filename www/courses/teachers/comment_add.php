<?php require_once('_security.php'); ?>
<?php require_once('../_config.php'); ?>
<?php require_once('../_header.php'); ?>
<?php require_once('_menu.php'); ?>
<?php
$id = isset($_GET['id']) ? $_GET['id'] : 0;

$query = sprintf("SELECT ts.id, l.name AS lesson_name FROM teachers_schedules ts LEFT JOIN lessons l ON ts.lesson_id = l.id WHERE ts.id = %u",
	mysql_real_escape_string($id)
);
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($result);
mysql_free_result($result);
?>
<h1>Comment Lesson <?php echo htmlspecialchars($row['lesson_name']); ?></h1>
<form action="comment_control.php" method="post">
	<input name="action" type="hidden" value="add">
	<input name="id" type="hidden" value="<?php echo htmlspecialchars($row['id']); ?>">
	<table>
		<tr>
			<th scope="row"><label for="teacher_comment">Comment</label></th>
			<td><textarea name="teacher_comment" cols="64" rows="4" id="teacher_comment"></textarea></td>
		</tr>
		<tr>
			<th scope="row"><label for="teacher_name">Name</label></th>
			<td><input name="teacher_name" type="text" maxlength="64"></td>
		</tr>
		<tr>
			<th scope="row"><label for="student_attendance">Student Attendance</label></th>
			<td><select name="student_attendance" id="student_attendance">
				<option value="1">Yes</option>
				<option value="0">No</option>
			</select></td>
		</tr>
		<tr>
			<th colspan="2" scope="row"><input type="submit" value="Add Comment" onclick="return confirm('Are you sure do you want to submit this comment?');"></th>
		</tr>
	</table>
</form>
<?php require_once('../_footer.php'); ?>