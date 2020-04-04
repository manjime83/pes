<?php require_once('_security.php'); ?>
<?php require_once('../_config.php'); ?>
<?php require_once('../_header.php'); ?>
<?php require_once('_menu.php'); ?>
<h1>Students</h1>
<table>
	<tr>
		<td colspan="3"><a href="students_edit.php"><img src="../images/add.png" alt="" width="16" height="16" align="absmiddle"> Create Student</a></td>
	</tr>
	<tr>
		<th scope="col">Code</th>
		<th scope="col">Name</th>
		<th scope="col">e-mail</th>
		<th scope="col">Time Zone</th>
		<th scope="col">Teacher</th>
		<th scope="col">&nbsp;</th>
	</tr>
	<?php
	$query = sprintf("SELECT s.id, s.email, s.code, s.name, s.timezone, t.code AS teacher_code, t.name AS teacher_name, is_active FROM students s LEFT JOIN teachers t ON s.teacher_id = t.id ORDER BY s.name");
	$result = mysql_query($query) or die(mysql_error());
	while ($row = mysql_fetch_assoc($result)) :
	?>
	<tr>
		<td><?php echo htmlspecialchars($row['code']); ?></td>
		<td><?php echo htmlspecialchars($row['name']); ?></td>
		<td><?php echo htmlspecialchars($row['email']); ?></td>
		<td><?php echo htmlspecialchars($row['timezone']); ?></td>
		<td><?php echo htmlspecialchars($row['teacher_code'] . ' - ' . $row['teacher_name']); ?></td>
		<td><a href="students_edit.php?id=<?php echo htmlspecialchars($row['id']); ?>"><img src="../images/pencil.png" alt="edit" width="16" height="16" align="absmiddle"></a> | <a href="students_control.php?action=delete&amp;id=<?php echo htmlspecialchars($row['id']); ?>"><img src="../images/delete.png" alt="delete" width="16" height="16" align="absmiddle"></a> |
			<?php if ($row['is_active'] == 0) : ?>
			<a href="students_control.php?action=activate&amp;id=<?php echo htmlspecialchars($row['id']); ?>"><img src="../images/status_offline.png" alt="activate" width="16" height="16" align="absmiddle"></a>
			<?php else : ?>
			<a href="students_control.php?action=deactivate&amp;id=<?php echo htmlspecialchars($row['id']); ?>"><img src="../images/status_online.png" alt="deactivate" width="16" height="16" align="absmiddle"></a>
			<?php endif; ?></td>
	</tr>
	<?php
	endwhile;
	mysql_free_result($result);
	?>
</table>
<?php require_once('../_footer.php'); ?>
