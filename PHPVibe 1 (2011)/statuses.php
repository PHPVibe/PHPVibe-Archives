<?php
require_once '_inc.php';
include_once("req/tolink.php");
require_once("library/video.func.php");
include_once("library/AutoEmbed.class.php");
$AE = new AutoEmbed();
$this_user_id = MK_Request::getQuery('id');
$user_module = MK_RecordModuleManager::getFromType('user');
$user_profile = MK_RecordManager::getFromId($user_module->getId(), $this_user_id);
$sql = dbquery("SELECT msg_id FROM user_wall where u_id='".$this_user_id."'"); 
$nr = mysql_num_rows($sql);
if (isset($_GET['pn'])) { 
    $pn = preg_replace('#[^0-9]#i', '', $_GET['pn']); 
} else { 
    $pn = 1;
} 
$BrowsePerPage = 15;
$lastPage = ceil($nr / $BrowsePerPage);
$head_title = array();
$head_desc = array();
$head_title[] = 'the Buzz of '. $user_profile->getName(); 
$head_desc[] = 'Recent statuses from '.$user_profile->getName(); 
$head_extra = '
<link href="'.$config->site->url.'tpl/css/comments.css" media="screen" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="'.$config->site->url.'js/comment.js"></script>
';
include_once("tpl/php/global_header.php");
?>


<div class="clearfix" id="main-content">
<div class="col col9">
  <div class="col-bkg clearfix">
    <h1><?php print $user_profile->getName(); ?> >> <?php echo __("Recent statuses ");?></h1>
<div id="wall" class="facebookWall">

<?php
$limit = 'LIMIT ' .($pn - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$result=mysql_query("select * from user_wall where u_id='".$this_user_id."' order by msg_id desc $limit");
 while($row = mysql_fetch_array($result)){
$id=$row['msg_id'];
$msg=$row['message'];
$user_id=$row['u_id'];
$user_time=$row['time'];
$user_video=$row['att'];
$msg=toLink($msg);
$user_module = MK_RecordModuleManager::getFromType('user');
$user_wall = MK_RecordManager::getFromId($user_module->getId(), $user_id);
$u_avatar = $user_wall->getAvatar();
$u_name = $user_wall->getDisplayName();

echo '
<li>
<img class="avatar" src="../../library/thumb.php?f='.$u_avatar.'&h=62&w=62&m=crop" />
<div class="status">
<h2><a href="user.php?id='.$user_id.'">'.$u_name.'</a></h2>
<p class="message">'.$msg.'</p>
';
if ($AE->parseUrl($user_video)) {
$AE->setWidth(240);
$AE->setHeight(160); 
echo '<div class="attachment">'.$AE->getEmbedCode().'</div>';  
}
echo '</div>
<p class="meta">'.$user_time.'</p>
<div class="comment-data">
';  

$object_id = 'status_'.$id; //identify the object which is being commented
include('loadComments.php'); //load the comments and display    
echo '</div></li>';

}
?>
</div>

<?php
   include 'library/pagination.php';
   $url = $config->site->url.'statuses.php?id='.$this_user_id.'&pn=';


$a = new pagination;	

$a->set_current($pn);

$a->set_pages_items(12);

$a->set_per_page($BrowsePerPage);

$a->set_values($nr);

$a->show_pages($url);
     ?>	

</div>
</div>

<?php      
include_once("sidebar.php");
include_once("tpl/php/footer.php");
?>