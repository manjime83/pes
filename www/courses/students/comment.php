<?php require_once('_security.php'); ?>
<?php require_once('../_config.php'); ?>
<?php require_once('../_header.php'); ?>
<?php require_once('_menu.php'); ?>
<?php
$id = isset($_GET['id']) ? $_GET['id'] : 0;

$query = sprintf("SELECT ts.id, l.name AS lesson_name, student_comment, student_comment_datetime, student_stars FROM teachers_schedules ts LEFT JOIN lessons l ON ts.lesson_id = l.id WHERE ts.id = %u",
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
		<td><?php echo nl2br(htmlspecialchars($row['student_comment'])); ?></td>
	</tr>
	<tr>
		<th scope="row">Comment Date</th>
		<td><?php echo htmlspecialchars($row['student_comment_datetime']); ?></td>
	</tr>
	<tr>
		<th scope="row">Calification</th>
		<td><?php for ($i = 0; $i < $row['student_stars']; $i++) : ?><img src="../images/star.png" width="16" height="16" alt="*"><?php endfor; ?></td>
	</tr>
</table>
<?php require_once('../_footer.php'); ?>