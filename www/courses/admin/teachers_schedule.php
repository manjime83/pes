<?php require_once('_security.php'); ?>
<?php require_once('../_config.php'); ?>
<?php require_once('../_header.php'); ?>
<?php require_once('_menu.php'); ?>
<?php
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$time = isset($_GET['time']) ? $_GET['time'] : '12:00';

$query = sprintf("SELECT id, code, name, timezone FROM teachers WHERE id = %u",
	mysql_real_escape_string($id)
);
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($result);
mysql_free_result($result);
?>
<h1>Schedule Teachers</h1>
<table>
	<tr>
		<th scope="row">Name</th>
		<td><?php echo htmlspecialchars($row['code'] . '-' . $row['name']); ?></td>
	</tr>
	<tr>
		<th scope="row">Timezone</th>
		<td><?php echo htmlspecialchars($row['timezone']); ?></td>
	</tr>
	<tr>
		<td colspan="2"><form action="teachers_control.php" method="post">
				<input name="action" type="hidden" value="add_teacher_schedule">
				<input name="id" type="hidden" value="<?php echo htmlspecialchars($row['id']); ?>">
				<table>
					<tr>
						<td><input name="date" type="text" value="<?php echo htmlspecialchars($date); ?>" size="12" maxlength="10"></td>
						<td><select name="time" id="time">
								<?php
								for ($i = 0; $i < 48; $i++) :
									$t = mktime(0, 30 * $i);
								?>
								<option value="<?php echo htmlspecialchars(date('H:i', $t)); ?>"<?php if (date('H:i', $t) == $time) : ?> selected="selected"<?php endif; ?>><?php echo htmlspecialchars(date('h:i a', $t)); ?></option>
								<?php endfor; ?>
							</select></td>
						<td><input type="submit" value="Add"></td>
					</tr>
				</table>
			</form>
			<table>
				<?php
				$query = sprintf("SELECT id, datetime FROM teachers_schedules WHERE teacher_id = %u AND datetime >= '%s' ORDER BY datetime",
					mysql_real_escape_string($row['id']),
					mysql_real_escape_string(gmdate('Y-m-d H:i'))
				);
				$result = mysql_query($query) or die(mysql_error());
				
				while ($teachers_schedules = mysql_fetch_assoc($result)) {
				?>
				<tr>
					<td><?php echo htmlspecialchars(date('Y-m-d h:i a', strtotime($teachers_schedules['datetime'] . ' GMT'))); ?> <a href="teachers_control.php?action=delete_teacher_schedule&amp;teacher_id=<?php echo htmlspecialchars($row['id']); ?>&amp;id=<?php echo htmlspecialchars($teachers_schedules['id']); ?>"><img src="../images/delete.png" alt="delete" width="16" height="16" align="absmiddle"></a></td>
				</tr>
				<?php
			}
			
			mysql_free_result($result);
			?>
			</table></td>
	</tr>
</table>
</form>
<?php require_once('../_footer.php'); ?>