<?php require_once('_security.php'); ?>
<?php require_once('../_config.php'); ?>
<?php require_once('../_header.php'); ?>
<?php require_once('_menu.php'); ?>
<table cellpadding="5">
	<tr>
		<th scope="col">Date Time</th>
		<th scope="col">Student</th>
		<th scope="col">Lesson</th>
		<th scope="col">Comments</th>
	</tr>
	<?php
	$now = date('Y-m-d H:i');
	
	$query = sprintf("SELECT ts.id, ts.datetime, l.name AS lesson_name, s.name AS student_name, ts.teacher_comment FROM teachers_schedules ts LEFT JOIN lessons l ON ts.lesson_id = l.id LEFT JOIN students s ON ts.student_id = s.id WHERE (ts.datetime >= '%s' OR (ts.datetime < '%s' AND s.id IS NOT NULL)) AND ts.teacher_id = %u ORDER BY ts.datetime DESC",
		mysql_real_escape_string(gmdate('Y-m-d H:i', strtotime(date('Y-m-d')))),
		mysql_real_escape_string(gmdate('Y-m-d H:i', strtotime(date('Y-m-d')))),
		mysql_real_escape_string($_SESSION['teacher']['id'])
	);
	$result = mysql_query($query) or die(mysql_error());
	while ($row = mysql_fetch_assoc($result)) :
		$datetime = date('Y-m-d H:i', strtotime($row['datetime'] . ' GMT'));
	?>
	<tr>
		<td><?php echo htmlspecialchars(date('Y-m-d h:i a', strtotime($row['datetime'] . ' GMT'))); ?></td>
		<td><?php echo htmlspecialchars($row['student_name']); ?></td>
		<td align="center"><?php echo htmlspecialchars($row['lesson_name']); ?></td>
		<td align="center"><?php if ($datetime < $now && is_null($row['teacher_comment'])) : ?>
			<a href="comment_add.php?id=<?php echo htmlspecialchars($row['id']); ?>"><img src="../images/comment_add.png" alt="add comment" width="16" height="16" align="absmiddle"></a>
			<?php elseif ($datetime < $now && !is_null($row['teacher_comment'])) : ?>
			<a href="comment.php?id=<?php echo htmlspecialchars($row['id']); ?>"><img src="../images/comment.png" alt="view comment" width="16" height="16" align="absmiddle"></a>
			<?php else : ?>
			&nbsp;
			<?php endif; ?></td>
	</tr>
	<?php
	endwhile;
	mysql_free_result($result);
	?>
</table>
<?php require_once('../_footer.php'); ?>