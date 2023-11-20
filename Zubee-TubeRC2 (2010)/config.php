<?php 
// Reffer to READ ME.txt file in root folder
if (eregi("config.php", $_SERVER['PHP_SELF'])) { die(); }

// Database Details

$DB_USER  = 'your database username';
$DB_PASS  = 'the pasword';

$DB_NAME  = 'your database name';

$DB_HOST  = 'localhost';
// 99% of the time, but if it doesn;t work, ask your hosting for mysql server adress
?>
