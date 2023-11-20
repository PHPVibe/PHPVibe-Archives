<div class="page_sidebox box_alignfull">
<!-- BEGIN WIDGET -->	
		<div class="box one">
<div class="header">
<h2>Be awesome and join us</h2>
<span class="toggle"></span>
</div>			

<div class="content padding">
<a href='<?php print $config->site->url; ?>login.php?platform=facebook'><img src="<?php print $config->site->url; ?>tpl/images/fblogin.png" alt="Connect with Fb" /></a>
<a href='<?php print $config->site->url; ?>login.php?platform=twitter'><img src="<?php print $config->site->url; ?>tpl/images/twlogin.png" alt="Connect with Twitter"/></a>

</div>
</div>	
<div class="social-box">
						
			<a href='http://www.facebook.com/envato'><img src="<?php print $config->site->url; ?>tpl/images/facebook.png" alt="Fan us on Facebook"  width='48' height='48' /></a>
			
			<div class="social-box-text">
				<span class="social-arrow"></span>
				<span class="social-box-descrip">Connect on Facebook</span>
				<span class="social-box-count">Be one of our happy fans</span>
			</div>
		</div>
			<div class="social-box">
			<a href='http://twitter.com/themesector'><img src="<?php print $config->site->url; ?>tpl/images/twitter.png" alt="Follow on Twitter" width="48" height="48" /></a>
						<div class="social-box-text">
				<span class="social-arrow"></span>
				<span class="social-box-descrip">Follow on Twitter</span>
				<span class="social-box-count">Yeah, stalking is allowed!</span>
			</div>
		</div>
						
				<div class="social-box">
			<a href='nettuts.html'><img src="<?php print $config->site->url; ?>tpl/images/rss.png" alt="Subsribe to RSS" width="48" height="48" /></a>
			
						
			<div class="social-box-text">
				<span class="social-arrow"></span>
				<span class="social-box-descrip">Subscribe to RSS Feed</span>
								<span class="social-box-count">Get fresh videos on your e-mail!</span>
							</div>
		</div>
<div class="box one">
    	<div class="header">

 			<h2>Members</h2>

    <!--Toggle-->

    <span class="toggle"></span>

 		</div>			
<div class="content padding">
		
	<?php
	
	// We get an instance of the users module
$user_module = MK_RecordModuleManager::getFromType('user');

	// We don't want ALL of the users so we create a MK_Paginator
	$paginator = new MK_Paginator();
	
	
	
	$paginator
		->setPage(1)
		->setPerPage(15);
	
	// Get users
	$users = $user_module->getRecords($paginator);
	
	
	foreach($users as $current_user)
	{
	$u_url = $site_url.'user/'.$current_user->getId().'/'.seo_clean_url($current_user->getDisplayName()) .'/';
		$output.= '';
		if($avatar = $current_user->getAvatar())
		{
		$output.= '';
			$output.= '<a href="'.$u_url.'" title = "'.$current_user->getDisplayName().'"><img class="border_white" src="'.$site_url.'components/thumb.php?f='.$avatar.'&h=70&w=70&m=crop" alt = "'.$current_user->getDisplayName().'"/></a>';
		$output.= '';
		}
		
	}
	
	print $output;
	

	?>
</div>
</div>
</div>
<!-- end pv-sidebox -->