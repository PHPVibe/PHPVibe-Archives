<?php
require_once '_inc.php';
$sku = MK_Request::getQuery('sk');
if ($sku == "info") 
{
include('library/profileinfo.php');
} else {
include('library/profilewall.php');
}

?>