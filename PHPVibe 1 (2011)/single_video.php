<?php
require_once("_inc.php");
require_once("library/video.func.php");
if ($_GET['id'] == "") { die("invalid video id"); }

$local_id = $_GET['id'];

$sql = dbquery("SELECT * FROM `videos` WHERE `id` = ".$local_id." LIMIT 0, 1");

while($row = mysql_fetch_array($sql)){
	$video_id = $row["youtube_id"];	
    $meta_description = $row["description"];
    $meta_description = substr($meta_description, 0, 150);  
    $description = $row["description"];
	$catid = $row["category"];
	$video_views = $row["views"];
	$video->title = $row["title"];
	$video_tags = $row["tags"];
	$video_time = $row["duration"];
	$video_likes = $row["liked"];
	$video_dislikes = $row["disliked"];
}
$csql = dbquery("SELECT cat_name FROM `channels` WHERE `cat_id` = ".$catid." LIMIT 0, 30 ");
while($row = mysql_fetch_array($csql)){
$category =  $row["cat_name"];

}

$canonical = $site_url.'video/'.$local_id.'/'.seo_clean_url($video->title) .'/';
$increasevideo = dbquery("UPDATE videos SET views = views+1 WHERE id = '".$local_id."';");



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
 <title><?php echo $video->title; ?></title>
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge" /><![endif]-->
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<base href="<?php print $config->site->url; ?>" />
<meta name="keywords" content="<?php echo $video_tags; ?>">
<meta name="description" content="<?php echo $meta_description?>">
<link rel="shortcut icon" href="<?php print $config->site->url; ?>favicon.ico" />
<link rel="canonical" href="<?php echo $canonical; ?>" />
<link rel="image_src" href="http://i2.ytimg.com/vi/<?php echo $video_id; ?>/0.jpg"/>
<link rel="video_src" href="<?php echo $site_url;?>tpl/player/player.swf?file=http://www.youtube.com/watch?v=<?php echo $video_id; ?>&autostart=true&logo.file=<?php echo $site_url;?>tpl/player/playerlogo.png&logo.link=<?php echo $canonical; ?>&logo.hide=false&logo.position=bottom-left&stretching=fill" />
<link href="<?php print $config->site->url; ?>tpl/css/default.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php print $config->site->url; ?>tpl/css/comments.css" media="screen" rel="stylesheet" type="text/css" />
 <link rel="stylesheet" href="<?php print $config->site->url; ?>tpl/css/buttons.css" type="text/css"/>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php print $config->site->url; ?>js/comment.js"></script>
<link rel="stylesheet" type="text/css" href="<?php print $config->site->url; ?>tpl/js/lightbox/themes/default/jquery.lightbox.css" />
<!--[if IE 6]><link rel="stylesheet" type="text/css" href="javascript/lightbox/themes/default/jquery.lightbox.ie6.css" /><![endif]-->
<script type="text/javascript" src="<?php print $config->site->url; ?>tpl/js/lightbox/jquery.lightbox.js"></script>
<script type="text/javascript">
  jQuery(document).ready(function($){
	$('#embed').lightbox();
  });
</script>
 <SCRIPT>
function clearDefault(el) {
if (el.defaultValue==el.value) el.value = ""
}
</SCRIPT>
<?php if( $user->isAuthorized() ) { ?>
<script type="text/javascript">
$(document).ready(function(){	

	//$('#voting_result').fadeOut();

	$('#like, #dislike').click(function(){

		var a = $(this).attr("id");
		var b = "<?php echo $local_id;?>";
		var dataString = 'value='+ a + '&val=' + b;

		 

		$.post("req/voting.php?"+ dataString, {

		}, function(response){

			$('#voting_result').fadeIn();

			$('#voting_result').html($(response).fadeIn('slow'));

			
			

		});

	});	

});	



</script>
<?php } ?>

 </head>
<body>
    
<div id="top_er" class="clearfix">
<div id="top_left" class="clearfix">
<a href="<?php print $config->site->url; ?>" rel="nofollow"><img src="tpl/images/logo.png" alt="<?php print $config->site->name; ?>"/></a>
 </div>
 
 <div id="top_center" class="clearfix">
 <div id="searchwrap">
<form action="/video_tags.php" method="get" name="thisform-search" id="thisform-search" onsubmit="location.href='<?php print $config->site->url; ?>show/' + encodeURIComponent(this.tag.value).replace(/%20/g, '+'); return false;">
<input type="text" name="search" id="s" value="Search.." onfocus="if(this.value == 'Search..') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search..';}"/>
<input type="submit" value="" class="go" />
</form>
</div>
 </div>
 <div id="top_right" class="clearfix">


<?php
if($user->isAuthorized())
	{
	$user_message_module = MK_RecordModuleManager::getFromType('user_message');

		$user_messages_inbox = $user_message_module->searchRecords(
			array(
				array('field' => 'recipient', 'value' => $user->getId()),
				array('field' => 'type', 'value' => 'inbox_unread')
			)
		);
		$user_messages_inbox_total = count($user_messages_inbox);

		$user_messages_drafts = $user_message_module->searchRecords(
			array(
				array('field' => 'sender', 'value' => $user->getId()),
				array('field' => 'type', 'value' => 'draft')
			)
		);
		$user_messages_drafts_total = count($user_messages_drafts);
echo'
<div class="button-group">
<a href="user.php?id='.$user->getId().'" class="button blue icon man rounded">'.$user->getName().'</a> 
<a href="edit-profile.php" class="button blue icon preferences rounded">'.__("Edit Profile").'</a>
<a href="messages.php?folder=inbox" class="button blue icon mailclosed rounded">Inbox ('.$user_messages_drafts_total.')</a>
';
?>
<?php print $user->getType() === MK_RecordUser::TYPE_CORE ? '<a href="change-password.php" class="button blue icon padlock rounded">'.__("Password").'</a>' : '' ?>
<a href="logout.php" class="button blue icon eject rounded">Logout</a>
</div>
<?php
} else {
echo'
<div class="button-group">
<a href="'.$config->site->url.'login/" class="button blue icon man rounded">'.__("Guest").'</a> 
<a href="'.$config->site->url.'login/" class="button blue icon connections rounded">'.__("Login").'</a>
<a href="'.$config->site->url.'register/" class="button blue icon connections rounded">'.__("Register").'</a>
<a href="'.$config->site->url.'login/" class="button blue rounded on">Facebook</a>
<a href="'.$config->site->url.'login/" class="button green rounded on">Twitter</a>

</div>';
}
?>

</div>
</div>
<div id="content-bkg"> 
<div class="wrapper"> 
 <div class="centerblock clearfix">

                            <div class="button-group">                             
                                <a href="<?php print $config->site->url; ?>" class="button blue icon house rounded"><?php echo __("Home");?></a>
								<a href="<?php print $config->site->url; ?>browse/" class="button blue icon clapboard rounded"><?php echo __("Recent videos");?></a>
								<a href="<?php print $config->site->url; ?>viewed/" class="button blue icon star rounded"><?php echo __("Most Viewed");?></a>
                                <a href="<?php print $config->site->url; ?>liked/" class="button blue icon heart rounded"><?php echo __("Most liked videos");?></a>
                                <a href="<?php print $config->site->url; ?>members.php" class="button blue icon man rounded"><?php echo __("Our Community");?></a>
								 <a href="<?php print $config->site->url; ?>bigwall.php" class="button blue icon speechmedia rounded"><?php echo __("Recent Buzz");?></a>
                            </div>

</div>  
		<div class="clearfix" style="height:14px;"></div>
<div class="clearfix" id="main-content">
<div class="col col12">
<div class="col col7">
    <h1><?php echo $video->title; ?></h1>
	</div>	
	<div class="col col5 col-last">
	<div class="button-group" style="float:right;padding-right:5px;margin-right:5px;">
		<span class="button blue icon graph rounded"><?php echo $video_views; ?> <?php echo __("views");?></span>
	  <span class="button green icon heart rounded"><?php echo $video_likes; ?> <?php echo __("likes");?></span>
      <span class="button red icon trash rounded"><?php echo $video_dislikes; ?> <?php echo __("dislikes");?></span>
    </div>
	</div>
		</div>
		<div class="clearfix" style="height:4px;"></div>
	
<script type="text/javascript" src="<?=$site_url?>tpl/player/swfobject.js"></script>
<div id="mediaspace">

You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and

	a browser with JavaScript support.

</div>

<script type='text/javascript'>

  var so = new SWFObject('<?php echo $site_url;?>tpl/player/player.swf','mpl','1050','406','9');

  so.addParam('allowfullscreen','true');

  so.addParam('allowscriptaccess','always');

  so.addParam('wmode','opaque');

  so.addVariable('file','http://www.youtube.com/watch?v=<?php echo $video_id; ?>');

  so.addVariable('image','http://i2.ytimg.com/vi/<?php echo $video_id; ?>/0.jpg');

  so.addVariable('controlbar','over');

  so.addVariable('logo.file','<?php echo $site_url;?>tpl/player/playerlogo.png');
  
  so.addVariable('logo.link','<?php echo $canonical;?>');
   
  so.addVariable('autostart','true');

  so.addVariable('logo.hide','false');

  so.addVariable('logo.position','top-left');

  //so.addVariable('stretching','fill');

 

  so.write('mediaspace');

 

</script>	
<div class="clearfix" style="height:14px;"></div>
<div class="col col12">
<div class="col col4">
   <a href="<?php print $config->site->url; ?>category/<?php echo $catid; ?>/<?php echo seo_clean_url($category); ?>/"  class="button blue icon speaker rounded" title="<?php echo $category; ?> video channel"><?php echo $category; ?></a>
	<a id="embed" class="button blue icon magnet rounded" href="#embedcodediv"><?php echo __("Embed video");?></a>
	</div>	
	<div class="col col4">
	<div class="like_dislike">

                                	<ul>

                                    	<li><a class="like" id="like" href="#" onClick=";return false;"><?php echo __("I like it");?></a></li>

                                		<li class="nobdr"><a class="dislike" id="dislike" href="#" onClick=";return false;"><?php echo __("I don't like it");?></a></li>

                                    </ul>

                                </div>
	</div>
	<div class="col col4 col-last">
	<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like href="<?php echo $canonical;?>" send="true" width="280" show_faces="false" font=""></fb:like>

	</div>
		</div>	
<div class="clearfix" style="height:14px;"></div>

<div class="col col9">
	<div id="voting_result" class="clearfix" style="display:none;"></div>		

<div class="clearfix" style="height:14px;"></div>
<div class="col-bkg clearfix">

 <?php
if(!$user->isAuthorized())
	{
echo'
<div class="button-group">
<a href="'.$config->site->url.'login/" class="button blue icon man rounded">Guests cannot comment</a> 
<a href="'.$config->site->url.'login/" class="button blue icon connections rounded">Login</a>
<a href="'.$config->site->url.'login/" class="button blue rounded on">Facebook Connect</a>
<a href="'.$config->site->url.'login/" class="button green rounded on">Twitter Login</a>

</div><br /> <br />';
}

  $object_id = 'video_'.$local_id; //identify the object which is being commented
include('loadComments.php'); //load the comments and display   
?>
<div class="share_this_video clearfix">
<div class="detail_min clearfix">
<ul>
<li> 
<?php echo $description; ?>

</li> 
<li>
<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
<a class="addthis_button_preferred_1"></a>
<a class="addthis_button_preferred_2"></a>
<a class="addthis_button_preferred_3"></a>
<a class="addthis_button_preferred_4"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4dbebba36feca69b"></script>

</li>
</ul>
</div>
</div>
 <?php 
$tags_array = explode(', ', $video_tags);
if (count($tags_array) > 0):
echo '<div class="button-group">';
$tag_links = "";
foreach ($tags_array as $tag):
$atag = str_replace(" ", "+", $tag);	
if ($tag != ""): $tag_links .= '<a href="'.$site_url.'show/'.$atag.'" class="button blue icon clapboard">'.$tag.'</a>';
endif;
endforeach;
else:
$tag_links = '';
endif;
echo $tag_links;
echo '</div>';
 ?>
<div class="vibe_contain">
 <ul>
<?php 
$morecat = 'rel_cat_'.$catid;
if(!$string = $Cache->Load("$morecat")){
                     $string = '';			 
					 $sql = dbquery("SELECT * FROM videos WHERE category='".$catid."' ORDER BY id DESC LIMIT 0,16");
	
					 while($row = mysql_fetch_array($sql)){
	$new_id = $row["id"];	
	$new_yt = $row["youtube_id"];
	$new_title = $row["title"];
	$small_title = substr($new_title, 0, 50);  
    $new_description = $row["description"];
	$new_seo_url = $site_url.'video/'.$new_id.'/'.seo_clean_url($new_title) .'/';
	$new_duration = $row["duration"];
	
  $string .='<li>
                        	<div class="vibekeep">
                            	<a href="'.$new_seo_url.'"><img src="http://i4.ytimg.com/vi/'.$new_yt.'/default.jpg" width="147" height="99" alt="" />
                                	<span class="time">'.sec2hms($new_duration).'</span>
                                </a>
                            </div>
							<div class="clear"></div>

                        	<p class="ttle"><a href="'.$new_seo_url.'">'.$small_title.'></a></p>
							
                        </li>';
						}
 $Cache->Save($string, "$morecat");
}
echo $string;
?>
 </ul>



                </div>	

<div class="clearfix"></div>
</div>
  </div>


<div class="col col4 col-last">

  <div class="sidecol-bkg">
 <div class="sidebare clearfix">

<div class="sidekeep clearfix">

<ul class="clearfix">
<?php 
$cache_rel = $cur_user_lang.'related_'.$local_id;
 if(!$vtrend = $Cache->Load($cache_rel)){
$vtrend = '';			 
 
$keywords       = explode(',', $video_tags);
$keywords_add   = NULL;
$keywords_count = count($keywords);

if ( $keywords_count > 1 ) {
    for ( $i=1; $i<$keywords_count; $i++ ) {
        $keywords_add .= " OR tags LIKE '%" .mysql_real_escape_string($keywords[$i]). "%'";
    }
}
$key_add        = "( tags LIKE '%" .mysql_real_escape_string($keywords['0']). "%' " .$keywords_add. ")";

 $related_sql = dbquery("SELECT id,youtube_id,title,views,duration,liked FROM videos WHERE ".$key_add." ORDER BY views DESC LIMIT 0,10 ");
 while($row = mysql_fetch_array($related_sql)){
	$new_id = $row["id"];	
	$new_yt = $row["youtube_id"];
	$new_title = $row["title"];
	$small_title = substr($new_title, 0, 30);  
	$new_seo_url = $site_url.'video/'.$new_id.'/'.seo_clean_url($new_title) .'/';	
	$new_views = $row["views"];
	$new_duration = $row["duration"];
	$new_liked = $row["liked"];
	
	
  $vtrend .='
<li class="clearfix">
<div class="thumb clearfix">
<a href="'.$new_seo_url.'"><img src="'.Get_Thumb($new_yt).'"  width="124" height="84" alt="'.$new_title.'" />
<span class="time">'.sec2hms($new_duration).'</span>
</a>
</div>
<div class="description clearfix">
<p><a href="'.$new_seo_url.'"> '.$small_title.'...</a></p>
<p class="viewcounts">'.$new_views.'  '.__("views").'</p>
<p class="stat">'.__("Liked by").' '.$new_liked.' '.__("persons").'</p> 
</div>
</li>';

}
 $Cache->Save($vtrend, $cache_rel);
}
echo $vtrend;
?>
</ul> 	
</div>
</div>


 </div>
        </div>
      
    </div>
    
    </div>
	<div id="embedcodediv" style="display:none;">
	Embed the video on your website:
	<br/> <br/> 
	Link to it: <br />
	<input name="txt" value="<?php echo $canonical;?>" type="text" size="40"/>
<br/> <br/> 
	Put it on your website: <br />
	<textarea cols="20" rows="2" style="width:320px; height:200px; font-size:14px;" maxlength="1045" >
<object type="application/x-shockwave-flash" style="width:640px; height:510px;" data="http://www.youtube.com/v/<?php echo $video_id; ?>?fs=1&amp;hl=en_US&amp;rel=0"> 
<param name="movie" value="http://www.youtube.com/v/<?php echo $video_id; ?>?fs=1&amp;hl=en_US&amp;rel=0" /> 
<param value="application/x-shockwave-flash" name="type" /> 
<param value="true" name="allowfullscreen" /> 
<param value="always" name="allowscriptaccess" /> 
<param value="opaque" name="wmode" /> 
</object>
<br/> <small>Found here : <a href="<?php echo $canonical; ?>"<?php echo $video->title; ?></a></small> 
</textarea>
	
	</div>

<?php      
include_once("tpl/php/footer.php");
?>