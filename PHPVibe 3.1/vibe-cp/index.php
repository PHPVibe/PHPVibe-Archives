<?php include_once("header.php");
function is_valid_licence($data) {
global $config;
$key_info['key'] = $data;
$key_info['domain'] = getRegisteredDomain(parse_url($config->site->url, PHP_URL_HOST));
$serverurl = "http://labs.phpvibe.com/server/server.php";
$ch = curl_init ($serverurl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt ($ch, CURLOPT_POST, true);
curl_setopt ($ch, CURLOPT_POSTFIELDS, $key_info);
$result = curl_exec ($ch);
$result = json_decode($result, true);
curl_close($ch);
if($result['valid'] == "true"){ 
return true; } else {
return false;}
}
function isV3($key) {
$keypart= explode("-", $key);
if ($keypart[0] == "V300") { return true; } else {
return false;}

}
if( $config->site->installed && (!$config->licence->key || !isV3($config->licence->key) || !is_valid_licence($config->licence->key))) {
if(!$config->licence->key):
$h1 .= '<p class="simple-message simple-message-warning">Missing licence key</p>';
//elseif(!isV3($config->licence->key)):
//$h1 .=  '<p class="simple-message simple-message-warning">The licence key seems to be for an older version.</p>';
elseif(!is_valid_licence($config->licence->key)):
$h1 .=  '<p class="simple-message simple-message-warning">The licence key used it\'s not valid for this domain.</p>';
endif;

$form_settings = array(
			'attributes' => array(
				'class' => 'form'
			)
		);
		$form_structure = array();
		  $form_structure['licence_key'] = array(
				'type' => 'text',
				'label' => 'Licence Key',
				'tooltip' => 'This is licence key you have created for this domain at phpVibe.com.',
				'value' => $config->licence->key
			);
			
		$form_structure['search_submit'] = array(
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Save Key'
			)
		);	
		
		$form = new MK_Form($form_structure, $form_settings);			
			if( $form->isSuccessful() ) {
			$message = array();
			$config_data = array();			
			$fields = $form->getFields();
			$config_data['licence.key'] = $form->getField('licence_key')->getValue();
			
	if($config->core->mode === MK_Core::MODE_DEMO) 	{
				print  'Settings cannot be updated as <strong>'.$config->instance->name.'</strong> is running in demonstration mode.';
			}	else{
				print 'Your licence settings have been updated. ';
				MK_Utility::writeConfig($config_data,$target_ini);
			}

		}else{
			$licenceform = $form->render();			
			print ' <div id="content"> <div class="box"><div class="box-header"><h1>Please input license key</h1></div><div class="box-content"><div class="widget" style="width:auto;min-width:600px;">
	'.$h1.' '. $licenceform.'
			</div>			</div> 			</div>			</div>
	';		}	
die();
}
$comsql = dbquery("SELECT COUNT(*) FROM em_comments"); 
$nrcoms = mysql_result($comsql , 0);
$likesql = dbquery("SELECT COUNT(*) FROM likes"); 
$nrlikes = mysql_result($likesql , 0);
$usersql = dbquery("SELECT COUNT(*) FROM users"); 
$nrusers = mysql_result($usersql , 0);
$wallsql = dbquery("SELECT COUNT(*) FROM user_wall"); 
$nrstatuses = mysql_result($wallsql , 0);
$vidsql = dbquery("SELECT COUNT(*) FROM videos"); 
$nrvid = mysql_result($vidsql , 0);
$av= dbquery("SELECT AVG(views) AS VI FROM videos");
$avr = dbarray($av);
$tv= dbquery("SELECT SUM(views) AS total FROM videos");
$tvv = dbarray($tv);
?>
	<div id="content">
<div class="box">
<div class="box-header"><h1>Welcome to the administration area</h1></div>
<div class="box-content">
			<ul class="actions">
							<li><div><a href="#" class="alert-32"><?php echo $nrvid; ?></a><span>videos in the database</span></div></li>
							<li><div><a href="#" class="charts-32"><?php echo $tvv['total'];?></a><span>total video views</span></div></li>
							<li><div><a href="#" class="charts-32"><?php echo $avr['VI'];?></a><span>average views/video</span></div></li>						
							<li><div><a href="#" class="charts-32"><?php echo $nrlikes; ?></a><span> video likes count</span></div></li>		
							<li><div><a href="#" class="users-32"><?php echo $nrusers; ?></a><span>users have registred</span></div></li>
							<li><div><a href="#" class="data-32"><?php echo $nrstatuses; ?></a><span>wall posts by users</span></div></li>																
							<li><div><a href="#" class="edit-32"><?php echo $nrcoms; ?></a><span>comments counted</span></div></li>
							
						</ul>
	
<br class="clear"/>
<div class="floatL" style="width:47%;">
		
<div class="widget">

            <div class="title"><img src="img/icons/settings.png" alt="" class="titleIcon" /><h6>phpVibe </h6>

            	<div class="num"><a href="<?php print $config->instance->url; ?>" class="blueNum" target="_blank"> <?php print $config->core->name; ?> v<?php print $config->core->version; ?></a></div>

               
            </div>

			<div class="body">Running on <div class="num"><a href="<?php print $config->instance->url; ?>" class="greenNum" target="_blank"> <?php print $config->core->name; ?></a><a href="<?php print $config->instance->url; ?>" class="blueNum" target="_blank"> v<?php print $config->core->version; ?></a></div>

			<div class="clear"></div>
			<?php
$filename = $target_ini;
if (is_writable($filename)) {
    echo '<div class="hMsg hFailure">    <p>Security risk: Config file is writeable! </p>   </div> <p>Please make it unwriteable after you are done with configuring the website.</p> ';
} else {
    echo '<div class="hMsg hSuccess">    <p>Config file is  not writeable! </p>   </div> <br /><p>Remember to make it writeable <span class="red">ONLY</span> if you need to change the configuration.</p>';
}
?>
			</div>
			
			<div class="body">
			<?php 
		
			$parse = parse_url("$site_url"); 
			if($parse[path] != "/") {
			  echo '<div class="hMsg hWarning">    <p>Seems phpVibe it\'s installed in a folder </p>   </div> <br /><p>Remember to edit the root/.httaccess file and change RewriteBase / to RewriteBase '.$parse[path].'</p>';
			}
			?>
		
			</div>
        </div>
		</div>
		<div class="floatR" style="width:47%;">
	<div class="widget" style="width:auto; min-width:385px;">     

            <ul class="tabs">
			  <li><a href="#tab1">New comments</a></li>
               <li><a href="#tab2">New statuses</a></li>      

            </ul>           

            <div class="tab_container">
			                <div id="tab1" class="tab_content">
				<ul class="partners">

                <?php
$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$os    = dbquery("SELECT DISTINCT em_comments . * , em_likes.vote , users.display_name, users.avatar FROM em_comments
LEFT JOIN em_likes ON em_comments.id = em_likes.comment_id
LEFT JOIN users ON em_comments.sender_id = users.id order by em_comments.id DESC LIMIT 0,10");
$my_u_url = '#';

while($rrow = mysql_fetch_array($os)){
if(!empty($rrow['avatar'])):
$avatar = $rrow['avatar'];
else:
$avatar = $site_url.'tpl/images/light/no_image.jpg';
endif;
$part = str_replace("_","/",$rrow['object_id']);
$url =$site_url.$part.'#emContent_'.$rrow['object_id'];

?>
<li>
<a href="<?php echo $my_u_url;?>" title="" class="floatL"><img src="<?php echo $site_url.'com/timthumb.php?src='.$avatar.'&h=36&w=37&crop&q=100';?>" alt="" /></a>
<div class="pInfo">
<a href="<?php echo $my_u_url;?>" title=""><strong><?php echo $rrow['display_name'];?></strong></a>
<i><?php echo stripslashes($rrow['comment_text']);?> </i>	
 </div>
 <div class="pLinks">
<a href="<?php echo $url; ?>" title="View comments" class="tipW" target="_blank"><i class="icon-comment"></i></a>
 </div>
<div class="clear"></div>
 </li>
  <?php }  ?>
 </ul>
				
				</div>
     <div id="tab2" class="tab_content">
				
				  <ul class="partners">

                <?php

$os    = dbquery("SELECT DISTINCT user_wall . * , users.id,users.display_name, users.avatar FROM user_wall LEFT JOIN users ON user_wall.u_id = users.id order by user_wall.u_id  DESC LIMIT 0,10");

while($rrow = mysql_fetch_array($os)){
$my_u_url = $site_url.'user/'.$rrow['id'].'/'.seo_clean_url($rrow['display_name']) .'/';
if(!empty($rrow['avatar'])):
$avatar = $rrow['avatar'];
else:
$avatar = $site_url.'tpl/images/light/no_image.jpg';
endif;
$part = "status/".$rrow['msg_id'];
$url =$site_url.$part;

?>
<li>
<a href="<?php echo $my_u_url;?>" title="" class="floatL"><img src="<?php echo $site_url.'com/timthumb.php?src='.$avatar.'&h=36&w=37&crop&q=100';?>" alt="" /></a>
<div class="pInfo">
<a href="<?php echo $my_u_url;?>" title=""><strong><?php echo $rrow['display_name'];?></strong></a>
<i><?php echo twitterify(stripslashes($rrow['message']));?> </i>	
 </div>
 <div class="pLinks">
<a href="<?php echo $url; ?>" title="View comments" class="tipW" target="_blank"><i class="icon-comment"></i></a>
 </div>
<div class="clear"></div>
 </li>
  <?php }  ?>
 </ul>
				
				</div>



            </div>	

            <div class="clear"></div>		 

        </div>
		</div>
               </div>              

            </div>

<br style="clear:both;">

		</div>
	
<?php include_once("footer.php");?>