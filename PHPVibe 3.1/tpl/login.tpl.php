<div id="signup" class="signupform">
			<div id="signup-ct">
				<div class="signupform-header">
					<h2><?php print $lang['reg-title']; ?></h2>
					<p><?php print $lang['reg-sub']; ?></p>
				
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
				  <button type="submit"><?php print $lang['createacc']; ?> &raquo;</button>
</div>
				 </form>
			</div>

		</div>
<div id="loginup" class="signupform">
			<div id="signup-ct">
				<div class="signupform-header">
					<h2><?php print $lang['login']; ?></h2>
					<p><?php print $lang['login-sub']; ?></p>
				
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
				  <button type="submit"><?php print $lang['login']; ?> &raquo;</button>
</div>
				 </form>
			</div>
			
		</div>