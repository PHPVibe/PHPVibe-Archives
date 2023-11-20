<?php

require_once('mainfile.php');

require_once("apifunctions.php");
require_once("includes/functions.php");
include_once("wi_class_files/autoMakeLinks.php");
include_once ("wi_class_files/agoTimeFormat.php");


/*-----------------------------------------*/



// delete recently viewed videos

dbquery("DELETE FROM recent WHERE ((".time()."-time) > 300)");



/*-----------------------------------------*/



// Show Template

if($template != "") {

	if(is_file('templates/'.$template.'/index.php')) {

		require_once('templates/'.$template.'/index.php');

	} else {

		die("Your template appears to be corrupt. Try re-uploading the folder.".'/templates/'.$template);

	}

} else {

	die("Your default template doesn't appear to be set.");

}



/*-----------------------------------------*/



ob_end_flush();



?>