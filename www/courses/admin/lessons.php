<?php require_once('_security.php'); ?>
<?php require_once('../_config.php'); ?>
<?php require_once('../_header.php'); ?>
<?php require_once('_menu.php'); ?>
<h1>Lessons</h1>
<table>
	<tr>
		<td colspan="3"><a href="lessons_edit.php"><img src="../images/add.png" alt="" width="16" height="16" align="absmiddle"> Create Lesson</a></td>
	</tr>
	<tr>
		<th scope="col">Name</th>
		<th scope="col">&nbsp;</th>
	</tr>
	<?php
	$query = sprintf("SELECT COUNT(*) AS lesson_count FROM lessons");
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_assoc($result);
	mysql_free_result($result);
	
	$lesson_count = $row['lesson_count'];
		
	$query = sprintf("SELECT id, name FROM lessons ORDER BY id");
	$result = mysql_query($query) or die(mysql_error());
	while ($row = mysql_fetch_assoc($result)) :
	?>
	<tr>
		<td><?php echo htmlspecialchars($row['name']); ?></td>
		<td><a href="lessons_edit.php?id=<?php echo htmlspecialchars($row['id']); ?>"><img src="../images/pencil.png" alt="edit" width="16" height="16" align="absmiddle"></a> | <a href="lessons_control.php?action=delete&amp;id=<?php echo htmlspecialchars($row['id']); ?>"><img src="../images/delete.png" alt="delete" width="16" height="16" align="absmiddle"></a></td>
		<td align="center"><?php if ($row['position'] != 0) : ?>
			<a href="lessons_control.php?action=up&amp;id=<?php echo htmlspecialchars($row['id']); ?>"><img src="../images/arrow_up.png" alt="up" width="16" height="16" align="absmiddle"></a>
			<?php endif; ?>
			<?php if ($row['position'] != ($lesson_count - 1)) : ?>
			<a href="lessons_control.php?action=down&amp;id=<?php echo htmlspecialchars($row['id']); ?>"><img src="../images/arrow_down.png" alt="down" width="16" height="16" align="absmiddle"></a>
			<?php endif; ?></td>
	</tr>
	<?php
	endwhile;
	mysql_free_result($result);
	?>
</table>
<?php require_once('../_footer.php'); ?>