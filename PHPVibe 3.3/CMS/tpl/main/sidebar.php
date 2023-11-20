<div id="sidebar-wrapper" class="span2 left-sidebar top10 hidden-phone hidden-tablet">
<div id="sidebar"> 
<div class="close-me visible-phone visible-tablet hidden-desktop">
<a id="mobi-hide-sidebar" class="topicon tipN" href="javascript:void(0)" title="<?php echo _lang('Hide'); ?>"><i class="icon-plus"></i></a>
</div>
<?php /* The video lists */
echo '<div class="i-box"> 
	<div class="widget-body">
	<div class="">
	<ul>
	<li><a href="'.list_url(browse).'" title="'._lang('Browse').'"><i class="icon-bullhorn inlist"></i> '._lang('Browse').'</a></li>
	<li><a href="'.list_url(mostviewed).'" title="'._lang('Most Viewed').'"><i class="icon-list-ol inlist"></i> '._lang('Most Viewed').'</a></li>
	<li><a href="'.list_url(promoted).'" title="'._lang('Featured').'"><i class="icon-check inlist"></i> '._lang('Featured').'</a></li>
	<li><a href="'.list_url(mostliked).'" title="'._lang('Most Liked').'"><i class="icon-heart inlist"></i> '._lang('Most Liked').'</a></li>	
	
    </ul>
    </div>
    </div>
    </div>';
if (is_user()) {
echo '<div class="i-box"> 
<div class="widget-head"><i class="icon-reorder"></i> '._lang("My stuff").'</div>
	<div class="widget-body">
	<div class="">
	<ul>
<li><a href="'.site_url().me.'&sk=new-playlist"><i class="icon-plus"></i> '. _lang('Create playlist').'</a> </li>
<li><a href="'.site_url().me.'&sk=playlists"><i class="icon-edit"></i> '. _lang('Manage playlists').'</a> </li>
<li><a href="'.site_url().me.'&sk=likes"><i class="icon-remove-circle"></i> '. _lang('Manage likes').'</a> </li>
<li><a href="'.site_url().me.'&sk=videos"><i class="icon-check"></i> '. _lang('Manage videos').'</a> </li>
    </ul>
    </div>
    </div>
    </div>';
}
/* The menu */
echo the_nav();
if (is_user()) {
/* start my  subscriptions */ 
$subscriptions = $db->get_results("select * from ".DB_PREFIX."users where ".DB_PREFIX."users.id in ( select uid from ".DB_PREFIX."users_friends where fid ='".user_id()."') ORDER BY ".DB_PREFIX."users.views DESC limit 0,20");	
$scs = ''; //Dun add scroll
if($subscriptions) {
if($db->num_rows > 10) {$scs ='scroll-items'; /*Add scroll if more than 10 */}
echo '<div class="i-box"> <div class="widget-head"><i class="icon-align-justify"></i> '._lang('Subscriptions').'</div>
	<div class="widget-body">
	<div class="'.$scs.'">
	<ul>';
foreach ($subscriptions as $sub) {
echo '
	<li><a href="'.profile_url($sub->id, $sub->name).'" title="'.$sub->name.'">
	<img class="tiny" src="'.thumb_fix($sub->avatar).'"> 	'._cut(stripslashes($sub->name), 20).'</a></li>	
	';
}
echo '
</ul>
</div>
</div>
</div>';
}
/* end subscriptions */
/* start my playlists */	
$myplays = $db->get_results("SELECT id,title,picture FROM ".DB_PREFIX."playlists where owner= '".user_id()."' order by views desc limit 0,20");
$pcs = ''; //Dun add scroll
if($myplays) { 
if($db->num_rows > 10) {$pcs ='scroll-items'; /*Add scroll if more than 10 */}
echo '	<div class="i-box">
	<div class="widget-head">
	<i class="icon-list-ul"></i> '._lang('My playlists').'
	</div>
	<div class="widget-body">
	<div class="'.$pcs.'">
	<ul>';
  foreach ($myplays as $myplay) {
	echo '
	<li><a href="'.playlist_url($myplay->id, $myplay->title).'" title="'.$myplay->title.'">
	<img class="tiny" src="'.thumb_fix($myplay->picture).'"> 	'._cut(stripslashes($myplay->title), 20).'</a> <a class="pull-right tipS" title="'._lang("Play all").'" href="'.site_url().'forward/'.$myplay->id.'/"><i class="icon-forward" style="margin-right:7px;"></i></a></li>
	';
	}
echo'</ul>
	</div>
	</div>
	</div>';
	} 
/* end my playlists */	
} else { 
/*If guest, show some statistics*/
?>

<ul class="statistics">
				    			<li>
				    				<div class="top-info">
					    				<a href="#" title="" class="blue-square"><i class="icon-film"></i></a>
					    				<strong><?php echo _count('videos'); ?></strong>
					    			</div>
									<div class="progress progress-micro"><div class="bar" style="width: 40%;"></div></div>
									<span><?php echo _lang('Videos');?></span>
				    			</li>
								<li>
				    				<div class="top-info">
					    				<a href="#" title="" class="sea-square"><i class="icon-group"></i></a>
					    				<strong><?php echo _count('users'); ?></strong>
					    			</div>
									<div class="progress progress-micro"><div class="bar" style="width: 40%;"></div></div>
									<span><?php echo _lang('Members');?></span>
				    			</li>
				    			<li>
				    				<div class="top-info">
					    				<a href="#" title="" class="red-square"><i class="icon-eye-open"></i></a>
					    				<strong><?php echo _count('videos','views',true ); ?></strong>
					    			</div>
									<div class="progress progress-micro"><div class="bar" style="width: 40%;"></div></div>
									<span><?php echo _lang('Video views');?></span>
				    			</li>
				    			<li>
				    				<div class="top-info">
					    				<a href="#" title="" class="green-square"><i class="icon-ok"></i></a>
					    				<strong><?php echo _count('likes' ); ?></strong>
					    			</div>
									<div class="progress progress-micro"><div class="bar" style="width: 40%;"></div></div>
									<span><?php echo _lang('Video likes');?></span>
				    			</li>
				    			<li>
				    				<div class="top-info">
					    				<a href="#" title="" class="purple-square"><i class="icon-fast-forward"></i></a>
					    				<strong><?php echo _count('playlists' ); ?></strong>
					    			</div>
									<div class="progress progress-micro"><div class="bar" style="width: 40%;"></div></div>
									<span><?php echo _lang('Playlists');?></span>
				    			</li>
							
				    		</ul>

<?php } ?>
</div>
</div>