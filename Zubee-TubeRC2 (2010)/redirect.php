<?php
require_once "mainfile.php";

if (isset($_GET['url'])) { redirect($_GET['url']); } { redirect($site_url); }
?>