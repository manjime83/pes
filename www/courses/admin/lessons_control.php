<?php
require_once('../_config.php');
require_once('_security.php');

$redirect = '';

mysql_connect(HOSTNAME, USERNAME, PASSWORD);
mysql_select_db(DATABASE);

$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');

switch ($action) {
	case 'add':
		$email = $_POST['name'];
		
		$query = sprintf("SELECT COUNT(*) AS position FROM lessons");
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_assoc($result);
		mysql_free_result($result);
		
		$position = $row['position'];
		
		$query = sprintf("INSERT INTO lessons SET name = '%s', position = %u",
			mysql_real_escape_string($name),
			mysql_real_escape_string($position)
		);
		$result = mysql_query($query) or die(mysql_error());
		
		$redirect = 'lessons.php';
		break;
	
	case 'update':
		$id = $_POST['id'];
		$name = $_POST['name'];
		
		$query = sprintf("UPDATE lessons SET name = '%s' WHERE id = %u",
			mysql_real_escape_string($name),
			mysql_real_escape_string($id)
		);
		$result = mysql_query($query) or die(mysql_error());
		
		$redirect = 'lessons.php';
		break;

	case 'delete':
		$id = $_GET['id'];
		
		$query = sprintf("DELETE FROM lessons WHERE id = %u",
			mysql_real_escape_string($id)
		);
		$result = mysql_query($query) or die(mysql_error());
		
		$redirect = 'lessons.php';
		break;
		
	case 'up':
		$id = $_GET['id'];
		
		$query = sprintf("SELECT id FROM lessons WHERE position IN (SELECT position - 1 FROM lessons WHERE id = %u)",
			mysql_real_escape_string($id)
		);
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_assoc($result);
		mysql_free_result($result);
		
		if ($row) {
			$query = sprintf("UPDATE lessons SET position = position - 1 WHERE id = %u",
				mysql_real_escape_string($id)
			);
			$result = mysql_query($query) or die(mysql_error());
			
			$query = sprintf("UPDATE lessons SET position = position + 1 WHERE id = %u",
				mysql_real_escape_string($row['id'])
			);
			$result = mysql_query($query) or die(mysql_error());
		}
		
		$redirect = 'lessons.php';
		break;
	
	case 'down':
		$id = $_GET['id'];
		
		$query = sprintf("SELECT id FROM lessons WHERE position IN (SELECT position + 1 FROM lessons WHERE id = %u)",
			mysql_real_escape_string($id)
		);
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_assoc($result);
		mysql_free_result($result);
		
		if ($row) {
			$query = sprintf("UPDATE lessons SET position = position + 1 WHERE id = %u",
				mysql_real_escape_string($id)
			);
			$result = mysql_query($query) or die(mysql_error());
			
			$query = sprintf("UPDATE lessons SET position = position - 1 WHERE id = %u",
				mysql_real_escape_string($row['id'])
			);
			$result = mysql_query($query) or die(mysql_error());
		}
		
		$redirect = 'lessons.php';
		break;
}

mysql_close();

header('Location: ' . $redirect);
?>