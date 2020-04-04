<?php require_once('_security.php'); ?>
<?php require_once('../_config.php'); ?>
<?php require_once('../_header.php'); ?>
<?php require_once('_menu.php'); ?>
<?php
$id = isset($_GET['id']) ? $_GET['id'] : 0;

$query = sprintf("SELECT id, email, code, name, timezone, teacher_id FROM students WHERE id = %u",
	mysql_real_escape_string($id)
);
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($result);
mysql_free_result($result);

$action = $row ? 'update' : 'add';
?>
<h1><?php echo htmlspecialchars($row ? 'Update' : 'Create'); ?> Student</h1>
<form action="students_control.php" method="post">
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
			<th scope="row"><label for="email">e-mail</label></th>
			<td><input name="email" type="text" id="email" value="<?php echo htmlspecialchars($row['email']); ?>" maxlength="64"></td>
		</tr>
		<?php if ($action == 'add') : ?>
		<tr>
			<th scope="row"><label for="password">Password</label></th>
			<td><input type="password" name="password" id="password"></td>
		</tr>
		<?php endif; ?>
		<tr>
			<th scope="row"><label for="code">Code</label></th>
			<td><input name="code" type="text" id="code" value="<?php echo htmlspecialchars($row['code']); ?>" maxlength="8"></td>
		</tr>
		<tr>
			<th scope="row"><label for="timezone">Timezone</label></th>
			<td><select name="timezone" id="timezone">
				<?php
				$zones = timezone_identifiers_list();
				$continents = array('Africa', 'America', 'Antarctica', 'Arctic', 'Asia', 'Atlantic', 'Australia', 'Europe', 'Indian', 'Pacific');
				
				foreach ($zones as $zone) :
					$zone_array = explode('/', $zone);
					$continent = array_shift($zone_array);
					
					if (in_array($continent, $continents)) :
						$zone_name = str_replace('_', ' ', implode('/', $zone_array));
					
						if (!isset($selectcontinent)) :
						?><optgroup label="<?php echo htmlspecialchars($continent); ?>"><?php
						elseif ($selectcontinent != $continent) :
						?></optgroup><optgroup label="<?php echo htmlspecialchars($continent); ?>"><?php
						endif;
						?><option value="<?php echo htmlspecialchars($zone); ?>"<?php if ($zone == $row['timezone']) { echo ' selected="selected"'; } ?>><?php echo htmlspecialchars($zone_name); ?></option><?php
					endif;
					
					$selectcontinent = $continent;
				endforeach;
				?></optgroup>
			</select></td>
		</tr>
		<tr>
			<th scope="row"><label for="teacher_id">Teacher</label></th>
			<td><select name="teacher_id" id="teacher_id">
				<?php
				$query = sprintf("SELECT id, code, name FROM teachers ORDER BY name");
				$result = mysql_query($query) or die(mysql_error());
				
				while ($teacher = mysql_fetch_assoc($result)) :
				?>
				<option value="<?php echo htmlspecialchars($teacher['id']); ?>"<?php if ($teacher['id'] == $row['teacher_id']) { echo ' selected="selected"'; } ?>><?php echo htmlspecialchars($teacher['code'] . ' - ' . $teacher['name']); ?></option>
				<?php
				endwhile;
				
				mysql_free_result($result);
				?>
				</select></td>
		</tr>
		<tr>
			<th colspan="2" scope="row"><input type="submit" value="<?php echo htmlspecialchars($row ? 'Update' : 'Create'); ?>"></th>
		</tr>
	</table>
</form>
<?php require_once('../_footer.php'); ?>