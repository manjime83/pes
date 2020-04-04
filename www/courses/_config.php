<?php
error_reporting(E_ALL);
ini_set('display_errors', 1); 

define('HOSTNAME', getenv('MYSQL_HOST'));
define('USERNAME', getenv('MYSQL_USER'));
define('PASSWORD', getenv('MYSQL_PASSWORD'));
define('DATABASE', getenv('MYSQL_DATABASE'));
?>