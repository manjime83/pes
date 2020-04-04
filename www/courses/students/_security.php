<?php
session_start();

if (!isset($_SESSION['student']) || !$_SESSION['student']['logged_in']) {
	header('Location: index.php?msg=session&uri=' . urlencode($_SERVER['REQUEST_URI']));
} else {
	date_default_timezone_set($_SESSION['student']['timezone']);
}
?>