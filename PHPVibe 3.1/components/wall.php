<?php $pageNumber = MK_Request::getQuery('page', 1);	
if(isset($_POST['id']) && $user->isAuthorized()) {
$update_now = dbquery("UPDATE user_wall SET message = '".cleanInput($_POST['enterMessage'])."' WHERE msg_id	= '".cleanInput($_POST['id'])."' and u_id='".$user->getId()."'");
}
$pagi_url = $site_url.'wall/&page=';
$seo_title = $lang['wall'];
include_once("tpl/header.php");
include_once("tpl/wall.tpl.php");
include_once("tpl/footer.php");
?>
