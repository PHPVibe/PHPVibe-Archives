<div id="signup" class="signupform">
			<div id="signup-ct">
				<div class="signupform-header">
					<h2>Create a new account</h2>
					<p>It's simple, and free.</p>
				
				</div>
				
				<form name="form" enctype="multipart/form-data" method="post" action="<?php print $config->site->url; ?>register.php">
     
				  <div class="txt-fld">
				    <label for="display_name">Username</label>
				    <input name="display_name" id="display_name" type="text" />

				  </div>
				  <div class="txt-fld">
				    <label for="email">Email</label>
				    <input name="email" id="email" type="text" />
				  </div>
				  <div class="txt-fld">
				    <label for="password">Password</label>
				    <input name="password" id="password"  type="text" />

				  </div>
				  <div class="btn-fld">
				  <button type="submit">Create account &raquo;</button>
</div>
				 </form>
			</div>
			<p>
			Or choose a faster way <br/>
<a href='<?php print $config->site->url; ?>login.php?platform=facebook'><img src="<?php print $config->site->url; ?>tpl/images/facebook_signin.png" alt="Connect with Fb" /></a>
<a href='<?php print $config->site->url; ?>login.php?platform=twitter'><img src="<?php print $config->site->url; ?>tpl/images/twitter_signin.png" alt="Connect with Twitter"/></a>

</p>
		</div>
<div id="loginup" class="signupform">
			<div id="signup-ct">
				<div class="signupform-header">
					<h2>Login</h2>
					<p>..and enjoy the fun.</p>
				
				</div>
				
				<form name="form" enctype="multipart/form-data" method="post" action="<?php print $config->site->url; ?>login.php">
     
				  <div class="txt-fld">
				    <label for="email">Email</label>
				    <input name="email" id="email" type="text" />
				  </div>
				  <div class="txt-fld">
				    <label for="password">Password</label>
				    <input name="password" id="password"  type="text" />

				  </div>
				  <div class="btn-fld">
				  <button type="submit">Login &raquo;</button>
</div>
				 </form>
			</div>
			<p>
			Or choose a faster way <br/>
<a href='<?php print $config->site->url; ?>login.php?platform=facebook'><img src="<?php print $config->site->url; ?>tpl/images/facebook_signin.png" alt="Connect with Fb" /></a>
<a href='<?php print $config->site->url; ?>login.php?platform=twitter'><img src="<?php print $config->site->url; ?>tpl/images/twitter_signin.png" alt="Connect with Twitter"/></a>

</p>
		</div>