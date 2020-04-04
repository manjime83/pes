<?php require_once('_security.php'); ?>
<?php require_once('../_config.php'); ?>
<?php require_once('../_header.php'); ?>
<?php require_once('_menu.php'); ?>
<h1>Teachers</h1>
<table>
	<tr>
		<td colspan="3"><a href="teachers_edit.php"><img src="../images/add.png" alt="" width="16" height="16" align="absmiddle"> Create Teacher</a></td>
	</tr>
	<tr>
		<th scope="col">Code</th>
		<th scope="col">Name</th>
		<th scope="col">e-mail</th>
		<th scope="col">Time Zone</th>
		<th scope="col">Status</th>
		<th scope="col">&nbsp;</th>
	</tr>
	<?php
	$query = sprintf("SELECT id, email, code, name, timezone, nickname FROM teachers ORDER BY name");
	$result = mysql_query($query) or die(mysql_error());
	while ($row = mysql_fetch_assoc($result)) :
	?>
	<tr>
		<td><?php echo htmlspecialchars($row['code']); ?></td>
		<td><?php echo htmlspecialchars($row['name']); ?></td>
		<td><?php echo htmlspecialchars($row['email']); ?></td>
		<td><?php echo htmlspecialchars($row['timezone']); ?></td>
		<td><?php if ($row['nickname'] != '') : ?>
			<a href="skype:<?php echo htmlspecialchars($row['nickname']); ?>?call"><img src="http://mystatus.skype.com/smallclassic/<?php echo htmlspecialchars($row['nickname']); ?>" style="border: none;" width="114" height="20" alt="teacher status" /></a>
			<?php else : ?>
			&nbsp;
			<?php endif; ?></td>
		<td><a href="teachers_edit.php?id=<?php echo htmlspecialchars($row['id']); ?>"><img src="../images/pencil.png" alt="edit" width="16" height="16" align="absmiddle"></a> | <a href="teachers_schedule.php?id=<?php echo htmlspecialchars($row['id']); ?>"><img src="../images/clock.png" alt="schedule" width="16" height="16" align="absmiddle"></a> | <a href="teachers_control.php?action=delete&amp;id=<?php echo htmlspecialchars($row['id']); ?>"><img src="../images/delete.png" alt="delete" width="16" height="16" align="absmiddle"></a></td>
	</tr>
	<?php
	endwhile;
	mysql_free_result($result);
	?>
</table>
<?php require_once('../_footer.php'); ?>
