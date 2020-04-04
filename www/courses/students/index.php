<?php require_once('../_config.php'); ?>
<?php require_once('../_header.php'); ?>
<form action="control.php" method="post">
	<input name="action" type="hidden" value="login">
	<input name="uri" type="hidden" value="<?php echo htmlspecialchars(isset($_GET['uri']) ? $_GET['uri'] : ''); ?>">
	<table align="center">
		<tr>
			<th colspan="2" scope="row">Student Login</th>
		</tr>
		<?php
		$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
		
		$messages = array(
			'session' => 'the session has expired',
			'login' => 'e-mail and/or password not found'
		);
		
		if (array_key_exists($msg, $messages)) :
		?>
		<tr>
			<td colspan="2"><?php echo htmlspecialchars($messages[$msg]); ?></td>
		</tr>
		<?php endif; ?>
		<tr>
			<th scope="row"><label for="email">e-mail</label></th>
			<td><input name="email" type="text" id="email" maxlength="64"></td>
		</tr>
		<tr>
			<th scope="row"><label for="password">Password</label></th>
			<td><input type="password" name="password" id="password"></td>
		</tr>
		<tr>
			<th colspan="2" scope="row"><input type="submit" value="Login"></th>
		</tr>
	</table>
</form>
<?php require_once('../_footer.php'); ?>