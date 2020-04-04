<?php require_once('_security.php'); ?>
<?php require_once('../_config.php'); ?>
<?php require_once('../_header.php'); ?>
<?php require_once('_menu.php'); ?>
<?php
$query = sprintf("SELECT nickname FROM teachers WHERE id = %u",
	mysql_real_escape_string($_SESSION['student']['teacher_id'])
);
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($result);
mysql_free_result($result);

$nickname = $row['nickname'];

if ($nickname != '') :
?>
<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>
<p>&nbsp;</p>
<p><a href="skype:<?php echo htmlspecialchars($nickname); ?>?call"><img src="http://mystatus.skype.com/smallclassic/<?php echo htmlspecialchars($nickname); ?>" style="border: none;" width="114" height="20" alt="teacher status" /></a></p>
<p>&nbsp;</p>
<?php endif; ?>
<table cellpadding="5">
	<tr>
		<th scope="col">Date Time</th>
		<th scope="col">Lesson</th>
		<th scope="col">Delete Class</th>
		<th scope="col">Comments</th>
	</tr>
	<?php
	$limit = date('Y-m-d H:i', mktime(date('H') + 12));
	$now = date('Y-m-d H:i');
	
	$query = sprintf("SELECT ts.id, ts.datetime, l.name AS lesson_name, ts.student_comment FROM teachers_schedules ts LEFT JOIN lessons l ON ts.lesson_id = l.id WHERE ts.student_id = %u ORDER BY ts.datetime DESC",
		mysql_real_escape_string($_SESSION['student']['id'])
	);
	$result = mysql_query($query) or die(mysql_error());
	while ($row = mysql_fetch_assoc($result)) :
		$datetime = date('Y-m-d H:i', strtotime($row['datetime'] . ' GMT'));
	?>
	<tr>
		<td><?php echo htmlspecialchars(date('Y-m-d h:i a', strtotime($row['datetime'] . ' GMT'))); ?></td>
		<td align="center"><?php echo htmlspecialchars($row['lesson_name']); ?></td>
		<td align="center"><?php if ($datetime > $limit) : ?>
			<a href="sessions_control.php?action=unschedule&amp;id=<?php echo htmlspecialchars($row['id']); ?>"><img src="../images/clock_delete.png" alt="unschedule" width="16" height="16" align="absmiddle"></a>
			<?php else : ?>
			&nbsp;
			<?php endif; ?></td>
		<td align="center"><?php if ($datetime < $now && is_null($row['student_comment'])) : ?>
			<a href="comment_add.php?id=<?php echo htmlspecialchars($row['id']); ?>"><img src="../images/comment_add.png" alt="add comment" width="16" height="16" align="absmiddle"></a>
			<?php elseif ($datetime < $now && !is_null($row['student_comment'])) : ?>
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