<?php
if(!$user->isAuthorized())
	{ 
include("login.tpl.php");
}
?>
<div class="clear"></div>
<!-- Footer -->
    	<footer id="footer">
    		<span class="left-footer">
    			    		Powered by phpVibe		
    			    		</span>
    		<span class="right-footer">
    			    		Running on phpVibe		
    			    		</span>
    	</footer>
		
		<div id="footmenu_wrapper">
			<div id="footmenu" class="nav_up bar_nav round_all clearfix">
			<a href="#" class="minimize round_top"><span>minimize</span></a>
				<ul class="round_all clearfix">

					<li><a class="round_left" href="<?php print $config->site->url; ?>">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/grey/Home.png">
						Home</a>
					</li> 

				

					<li><a href="#">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/grey/battery.png">
						Accordion
						<span class="icon">&nbsp;</span></a> 														
						<ul>
							<li><a href="#">
								<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/grey/zip_file.png">Fruits
								<span class="icon">&nbsp;</span></a>
								<div class="accordion">
									<a href="#">Apples</a>
									<a href="#">Oranges</a>
									<a href="#">Bananas</a>
								</div>	
							</li>
							<li class="link"><a href="http://en.wikipedia.org/wiki/Bread">
								<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/grey/winner_podium.png">Breads</a>
							</li>
							<li><a href="#">
								<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/grey/sport_shirt.png">Vegetables
								<span class="icon">&nbsp;</span></a>
								<div class="accordion">
									<a href="#">Potatoes</a>
									<a href="#">Spinach</a>
									<a href="#">Celery</a>
								</div>	
							</li>
							<li><a href="#">
								<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/grey/trashcan_2.png">Meat
								<span class="icon">&nbsp;</span></a>
								<div class="accordion">
									<a href="#">Beef</a>
									<a href="#">Pork</a>
									<a href="#">Venison</a>
								</div>	
							</li>
						</ul>					
					</li>

					<li class="has_mega_menu"><a href="#">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/grey/chrome.png">
						Mega Menu
						<span class="icon">&nbsp;</span></a>
						<div class="mega_menu container_16"> 
							<div class="grid_8"> 
								<h2>Welcome to Sherpa Nav System</h2> 
								<p><img class="float_left" src="images/sherpa_crest.jpg" width="132" height="132"><strong>Sherpas</strong> were immeasurably valuable to early explorers of the Himalayan region, serving as guides and porters at the extreme altitudes of the peaks and passes in the region. Today, the term is used casually to refer to almost any guide or porter hired for mountaineering expeditions in the Himalayas.</p>
								<p>In Nepal, however, <strong>Sherpas</strong> insist on making the distinction between themselves and general porters, because <strong>Sherpas</strong> often serve in a more guide-like role and command higher pay and respect from the community.</p>
							</div> 
							<div class="grid_4"> 
								<h4>1/4 Column</h4> 
								<p><strong>Sherpas</strong> are short in stature to accelerate the speed of circulation around the body and also breathe more quickly than the average person to extract more oxygen from the thin air.</p>
							</div> 
							<div class="grid_4"> 
								<h4>1/4 Column</h4> 
								<p><strong>Sherpas</strong> are renowned in the international climbing and mountaineering community for their hardiness, expertise, and experience at high altitudes.</p>
							</div> 
							<div class="grid_8"> 
								<p>It has been speculated that a portion of the <strong>Sherpas</strong>' climbing ability is the result of a genetic adaptation to living in high altitudes. Some of these adaptations include unique hemoglobin-binding enzymes, doubled nitric oxide production, hearts that can utilize glucose, and lungs with an increased efficiency in low oxygen conditions.</p>
							</div> 
						</div> 
					</li>

					<li><a href="#">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/grey/chart_6.png">
						Mixed
						<span class="icon">&nbsp;</span></a>
						<ul>
							<li><a href="#">North America
								<span class="icon">&nbsp;</span></a>
								<div class="accordion">
									<a href="#">Paris</a>
									<a href="#">Lyon</a>
									<a href="#">Marseille</a>
									<a href="#">Toulouse</a>
								</div>
							</li>
							<li><a href="#">Europe
								<span class="icon">&nbsp;</span></a>	
								<ul>
									<li><a href="#">Eastern</a></li>
									<li><a href="#">Central</a></li>
									<li><a href="#">Western
										<span class="icon">&nbsp;</span></a>			
										<ul>
											<li><a href="#">Germany
												<span class="left icon">&nbsp;</span></a>									
												<ul class="slide_left">
													<li><a href="#">Berlin</a></li>
													<li><a href="#">Munich</a></li>
													<li><a href="#">Frankfurt</a></li>
												</ul>
											</li>
											<li><a href="#">Netherlands</a></li>
											<li><a href="#">France
												<span class="left icon">&nbsp;</span></a>									
												<div class="accordion">
													<a href="#">Paris</a>
													<a href="#">Lyon</a>
													<a href="#">Marseille</a>
													<a href="#">Toulouse</a>
												</div>					
											</li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#">Asia</a></li>
						</ul>
					</li>

					<li><a href="#">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/grey/book.png">
						Link</a>
					</li>

			<?php
if($user->isAuthorized())
	{?>		
						<li class="send_right"><a href="<?php echo $u_plink; ?>">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/grey/admin_user_2.png">
						My profile
						<span class="icon">&nbsp;</span></a>
						<ul>
							
							<li><a href="<?php print $config->site->url; ?>logout.php">Logout</a></li>
							 <li><a href="<?php echo $u_plink; ?>">View profile</a></li>
                            <li><a href="<?php print $config->site->url; ?>edit-profile.php">Edit Profile</a></li>
						</ul>
					</li>
					<?php } else {					?>
						
						
						
						<li class="send_right"><a href="#">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/grey/male_contour.png">
						Connect Now
						<span class="icon">&nbsp;</span></a>
						<ul>
							
						
							
                            <li class="link"><a href="#">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/grey/Key.png">
						Login
						<span class="icon">&nbsp;</span></a>
						</li>
						
							<li  class="link"><a href="#">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/grey/Twitter.png">
						Twitter Login
						<span class="icon">&nbsp;</span></a>
						</li>
					<li  class="link"><a href="#">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/grey/Facebook.png">
						Facebook Login
						<span class="icon">&nbsp;</span></a>
						</li>
						</ul>
					</li>
					 <li  class="link send_right"><a href="#">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/grey/Pants.png">
						Register
						<span class="icon">&nbsp;</span></a>
						<ul>
						
                            <li class="link"><a href="#">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/grey/Key.png">
						Register
						<span class="icon">&nbsp;</span></a>
						</li>
						
							<li  class="link"><a href="#">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/grey/Twitter.png">
						Twitter Connect
						<span class="icon">&nbsp;</span></a>
						</li>
					<li  class="link"><a href="#">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/grey/Facebook.png">
						Facebook Connect
						<span class="icon">&nbsp;</span></a>
						</li>
						</ul>
						</li>
				
					
					<?php }	?>

				</ul>
			</div>
		</div>

    	<div class="clear"></div>
    	
    	
    </section>

	
<script type="text/javascript" src="<?php print $config->site->url; ?>components/sherpa/scripts/sherpa_ui.js"></script>
<script type='text/javascript' src='<?php print $config->site->url; ?>tpl/js/jquery.custom5152.js?ver=1.0'></script>
<?php if($page == "video") { ?>
<script type='text/javascript' src='<?php print $config->site->url; ?>tpl/js/videoscroll.js'></script>
<?php } ?>
</body>  
</html>