<?php require_once('_security.php'); ?>
<?php require_once('../_config.php'); ?>
<?php require_once('../_header.php'); ?>
<?php require_once('_menu.php'); ?>
<?php
$id = isset($_GET['id']) ? $_GET['id'] : 0;

$query = sprintf("SELECT id, name FROM lessons WHERE id = %u",
	mysql_real_escape_string($id)
);
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($result);
mysql_free_result($result);

$action = $row ? 'update' : 'add';
?>
<h1><?php echo htmlspecialchars($row ? 'Update' : 'Create'); ?> Lesson</h1>
<form action="lessons_control.php" method="post">
	<input name="action" type="hidden" value="<?php echo htmlspecialchars($action); ?>">
	<?php if ($action == 'update') : ?>
	<input name="id" type="hidden" value="<?php echo htmlspecialchars($row['id']); ?>">
	<?php endif; ?>
	<table>
		<tr>
			<th scope="row"><label for="name">Name</label></th>
			<td><input name="name" type="text" id="name" value="<?php echo htmlspecialchars($row['name']); ?>" maxlength="64"></td>
		</tr>
		<tr>
			<th colspan="2" scope="row"><input type="submit" value="<?php echo htmlspecialchars($row ? 'Update' : 'Create'); ?>"></th>
		</tr>
	</table>
</form>
<?php require_once('../_footer.php'); ?>