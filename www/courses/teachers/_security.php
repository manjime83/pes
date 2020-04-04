<?php
session_start();

if (!isset($_SESSION['teacher']) || !$_SESSION['teacher']['logged_in']) {
	header('Location: index.php?msg=session&uri=' . urlencode($_SERVER['REQUEST_URI']));
} else {
	date_default_timezone_set($_SESSION['teacher']['timezone']);
}
?>