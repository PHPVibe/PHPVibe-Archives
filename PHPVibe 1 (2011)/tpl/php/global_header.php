<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml"> 
<head>
<base href="<?php print $config->site->url; ?>" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?php print ( !empty($head_title) ? implode(' / ', array_reverse($head_title)).' - ' : '' ) . $config->site->name; ?></title>
<meta name="description" content="<?php print ( !empty($head_desc) ? implode(' / ', array_reverse($head_desc)).' - ' : '' ) . $config->site->name; ?>" />
<link rel="shortcut icon" href="favicon.ico" />
<link href="<?php print $config->site->url; ?>tpl/css/default.css" media="screen" rel="stylesheet" type="text/css" />
 <link rel="stylesheet" href="<?php print $config->site->url; ?>tpl/css/buttons.css" type="text/css"/>

 <SCRIPT>
function clearDefault(el) {
if (el.defaultValue==el.value) el.value = ""
}
</SCRIPT>

<script type="text/javascript" src="<?php print $config->site->url; ?>tpl/js/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php print $config->site->url; ?>tpl/js/lightbox/themes/default/jquery.lightbox.css" />
<!--[if IE 6]><link rel="stylesheet" type="text/css" href="javascript/lightbox/themes/default/jquery.lightbox.ie6.css" /><![endif]-->
<script type="text/javascript" src="<?php print $config->site->url; ?>tpl/js/lightbox/jquery.lightbox.min.js"></script>
<script type="text/javascript" src="<?php print $config->site->url; ?>tpl/js/jquery.menu.min.js"></script>
<script type="text/javascript" src="<?php print $config->site->url; ?>tpl/js/jquery.easing.1.3.js"></script>

<script type="text/javascript">


  jQuery(document).ready(function($) {
    $('.addtoplaylist').live('click', function(ev) {
      
      var video = $(this).attr('href');
     

      $.lightbox('<?php print $config->site->url; ?>tpl/player/player.swf', {
	    width: 640,
        height: 360,		
        force: 'flash',	
        flashvars: 'file='+video+'&autostart=true&repeat=always&logo.file=<?php print $config->site->url; ?>tpl/player/playerlogo.png&logo.link=<?php print $config->site->url; ?>&logo.hide=false&logo.position=bottom-left&stretching=fill'
      });
      
      ev.preventDefault();
    
    });
  });

  
  jQuery(document).ready(function() {
    //Tooltips
    $(".tip_trigger").delay(3000).hover(function(){
        tip = $(this).find('.tip');
        tip.show(); //Show tooltip
    }, function() {
        tip.hide(); //Hide tooltip
    }).mousemove(function(e) {
        var mousex = e.pageX + 10; //Get X coodrinates
        var mousey = e.pageY + 10; //Get Y coordinates
        var tipWidth = tip.width(); //Find width of tooltip
        var tipHeight = tip.height(); //Find height of tooltip

        //Distance of element from the right edge of viewport
        var tipVisX = $(window).width() - (mousex + tipWidth);
        //Distance of element from the bottom of viewport
        var tipVisY = $(window).height() - (mousey + tipHeight);

        if ( tipVisX < 20 ) { //If tooltip exceeds the X coordinate of viewport
            mousex = e.pageX - tipWidth - 10;
        } if ( tipVisY < 20 ) { //If tooltip exceeds the Y coordinate of viewport
            mousey = e.pageY - tipHeight - 10;
        }
        //Absolute position the tooltip according to mouse position
        tip.css({  top: mousey, left: mousex });
    });
});
</script>
<?php if (!empty($head_extra)) { echo $head_extra;}?>
 </head>
<body>
    
<div id="top_er" class="clearfix">
<div id="top_left" class="clearfix">
<a href="<?php print $config->site->url; ?>" rel="nofollow"><img src="tpl/images/logo.png" alt="<?php print $config->site->name; ?>"/></a>
 </div>
 
 <div id="top_center" class="clearfix">
 <div id="searchwrap">
<form action="/video_tags.php" method="get" name="thisform-search" id="thisform-search" onsubmit="location.href='<?php print $config->site->url; ?>show/' + encodeURIComponent(this.tag.value).replace(/%20/g, '+'); return false;">
<input type="text" name="search" id="s" value="<?php echo __("Search.."); ?>" onfocus="if(this.value == 'Search..') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search..';}"/>
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