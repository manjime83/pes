<?php
session_start();

if (!isset($_SESSION['admin']) || !$_SESSION['admin']['logged_in']) {
	header('Location: index.php?msg=session&uri=' . urlencode($_SERVER['REQUEST_URI']));
} else {
	date_default_timezone_set($_SESSION['admin']['timezone']);
}
?>