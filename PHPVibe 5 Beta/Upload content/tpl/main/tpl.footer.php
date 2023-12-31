<?php /* PHPVibe v5's footer */
function footer_add(){
global $db, $cachedb,$next;	
$up = 'var next_time = \'0\';';
if(is_video()) {
global $video;
if((isset($video) && $video) && has_list()) {
if(!isset($next) || is_empty($next['link'])) {	
$new = guess_next();
} else {
$new =	$next;
}
if(isset($new['link']) && !nullval($new['link'])) {
$up = 'var next_time = \''.intval($video->duration * 1000 + 1000).'\';';
$up .= 'var next_url = \''.$new['link'].'&list='._get('list').'\';';
}
}
}
$up .= 'var nv_lang = \''._lang("Next video starting soon").'\';';
$footer =  '
</div>
</div>
</div>
</div>
<a href="#" id="linkTop" class="backtotop"><i class="icon-angle-double-up"></i></a>
<div id="footer" class="row block full oboxed">';
$footer .='<div class="row footer-holder">
<div class="container footer-inner">
<div class="row">
<div class="col-md-2 col-xs-12 footer-logo">
<a href="'.site_url().'">'.show_logo('footer').' </a>
</div>
<div class="col-md-7 col-xs-12 col-md-offset-1">
<div class="row row-socials">
    <div class="btn-group dropup">
                    <a class="btn btn-sm btn-default"><i class="icon icon-globe"></i> '._lang("Language").'</a>
                    <a class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      <span class="caret"></span>
                     </a>
                    <ul class="dropdown-menu" role="menu">
					'.lang_menu().'
                     </ul>
    </div>
';
$footer .='
<ul class="socialfooter">';
 if(not_empty(get_option("our_facebook", "#"))) { 
  $footer .= '<li class="facebook">
    <a rel="nofollow" class="tipS" href="'.get_option("our_facebook").'" target="_blank" title="'._lang("Facebook").'"></a>
    </a>
  </li>';
  }
if(not_empty(get_option("our_googleplus", "#"))) { 
  $footer .= '<li class="googleplus">
    <a rel="nofollow" class="tipS" href="'.get_option("our_googleplus").'" target="_blank" title="'._lang("Google Plus").'"></a>
    </a>
  </li>';
  }
  if(not_empty(get_option("our_youtube", "#"))) { 
  $footer .= '<li class="youtube">
    <a rel="nofollow" class="tipS" href="'.get_option("our_youtube").'" target="_blank" title="'._lang("Youtube").'"></a>
    </a>
  </li>';
  }
if(not_empty(get_option("our_pinterest", "#"))) { 
  $footer .= '<li class="pinterest">
    <a rel="nofollow" class="tipS" href="'.get_option("our_pinterest").'" target="_blank" title="'._lang("Pinterest").'"></a>
    </a>
  </li>';
  }
if(not_empty(get_option("our_twitter", "#"))) { 
  $footer .= '<li class="twitter">
    <a rel="nofollow" class="tipS" href="'.get_option("our_twitter").'" target="_blank" title="'._lang("Twitter").'"></a>
    </a>
  </li>';
  }
  if(not_empty(get_option("our_rss", "#"))) { 
  $footer .= '<li class="rss">
    <a rel="nofollow" class="tipS" href="'.get_option("our_rss").'" target="_blank" title="'._lang("Feedburner").'"></a>
    </a>
  </li>';
  }
if(not_empty(get_option("our_skype", "#"))) { 
  $footer .= '<li class="skype">
    <a rel="nofollow" class="tipS" href="'.get_option("our_skype").'" target="_blank" title="'._lang("Skype").'"></a>
    </a>
  </li>';
  }
if(not_empty(get_option("our_vimeo", "#"))) { 
  $footer .= '<li class="vimeo">
    <a rel="nofollow" class="tipS" href="'.get_option("our_vimeo").'" target="_blank" title="'._lang("Vimeo").'"></a>
    </a>
  </li>';
  }
 if(not_empty(get_option("our_dribbble", "#"))) { 
  $footer .= '<li class="dribbble">
    <a rel="nofollow" class="tipS" href="'.get_option("our_dribbble").'" target="_blank" title="'._lang("Dribbble").'"></a>
    </a>
  </li>';
  }
if(not_empty(get_option("our_flickr", "#"))) { 
  $footer .= '<li class="flickr">
    <a rel="nofollow" class="tipS" href="'.get_option("our_flickr").'" target="_blank" title="'._lang("Flickr").'"></a>
    </a>
  </li>';
  }
 if(not_empty(get_option("our_linkedin", "#"))) { 
  $footer .= '<li class="linkedin">
    <a rel="nofollow" class="tipS" href="'.get_option("our_linkedin").'" target="_blank" title="'._lang("Linked in").'"></a>
    </a>
  </li>';
  }
$footer .='</ul>
';
$footer .= '</div>
<div class="row row-links">';
$posts = $cachedb->get_results("select title,pid from ".DB_PREFIX."pages where menu = 1 ORDER BY m_order, title ASC limit 0,100");
if($posts) {
foreach ($posts as $px) {
$footer .='<a class="btn btn-flat btn-default btn-squared" href="'.page_url($px->pid, $px->title).'" title="'._html($px->title).'"> '._cut(_html($px->title),190).'</a>';	
}	
}
$footer .='</div>
<div class="row row-rights">
'.site_copy().'
</div>				  
</div>
</div>
';
$footer .='</div>
</div>
</div>
</div>

'.login_modal().'
<div class="modal fade" id="search-now" aria-hidden="true" aria-labelledby="search-now" role="dialog" tabindex="-1">
<div class="modal-dialog modal-sidebar modal-lg">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<div class="modal-body">
<div class="panel panel-transparent">
<div class="row">
<form action="" method="get" id="searchform" onsubmit="location.href=\''.site_url().show.'/\' + encodeURIComponent(this.tag.value).replace(/%20/g, \'+\'); return false;">
<div class="form-group form-material floating">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="icon icon-search"></i></span>
                    <div class="form-control-wrap">
                      <input type="text" class="form-control input-lg empty" name="tag" value ="">
                      <label class="floating-label">'._lang("Search media").'</label>
                    </div>
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="submit">'._lang("Search").'</button>
                    </span>
                  </div>
                </div>
				</form>

</div>
</div>
</div>
</div>
</div>
</div>
<!-- End Search Modal -->
<script type="text/javascript">
var site_url = \''.site_url().'\';
'.$up.'
var select2choice = \''._lang("Select option").'\';
</script>
<script type="text/javascript" src="'.tpl().'styles/js/bootstrap.js"></script>
<script type="text/javascript" src="'.tpl().'styles/js/jquery.form.min.js"></script>
<script type="text/javascript" src="'.tpl().'styles/js/jquery.imagesloaded.min.js"></script>
<script type="text/javascript" src="'.tpl().'styles/js/jquery.infinitescroll.min.js"></script>
<script type="text/javascript" src="'.tpl().'styles/js/jquery.gritter.js"></script>
<script type="text/javascript" src="'.tpl().'styles/js/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="'.tpl().'styles/js/jquery.emoticons.js"></script>
<script type="text/javascript" src="'.tpl().'styles/js/owl-carousel/owl.carousel.min.js"></script>
<script type="text/javascript" src="'.tpl().'styles/js/jquery.minimalect.min.js"></script>
<script type="text/javascript" src="'.tpl().'styles/js/jquery.validarium.js"></script>
<script type="text/javascript" src="'.tpl().'styles/js/jquery.tagsinput.js"></script>
<script type="text/javascript" src="'.tpl().'styles/js/jquery.grid-a-licious.min.js"></script>
<script type="text/javascript" src="'.tpl().'styles/js/phpvibe_app.js"></script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId='.Fb_Key.'";
fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>
'.extra_js().'
'._pjs(get_option('googletracking')).'
</body>
</html>';
return $footer;
}
function login_modal(){
if(is_user()) {return '';}
$socials = '';
if(get_option('allowfb',0) == 1 ) {
$socials .= '<div class="social-login fb-login">
<a href="'.site_url().'?action=login&type=facebook" class="btn btn-block btn-raised social-facebook"><i class="icon icon-facebook bd-facebook"></i><em> '._lang("Login with").'</em> '._lang("Facebook").'</a>
</div>';	
}
if(get_option('allowg',0) == 1 ) {
$socials .= '<div class="social-login google-login">
<a href="'.site_url().'?action=login&type=google" class="btn btn-block social-google-plus"><i class="icon icon-google-plus bd-google-plus"></i><em> '._lang("Login with").'</em> '._lang("Google Plus").'</a>
</div>';	
}
$lg = '<!-- Start Login Modal -->
<div class="modal fade" id="login-now" aria-hidden="true" aria-labelledby="login-now" role="dialog" tabindex="-1">
<div class="modal-dialog modal-sidebar modal-sm">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
<h4 class="modal-title">'._lang('Login').'</h4>
</div>
<div class="modal-body">
<div class="panel">
<div class="row">'.$socials.'
<form method="post" action="'.site_url().'login" class="mtop10 modal-form">
<div class="form-group form-material floating">
<input type="email" class="form-control" name="email" required data-error="'._lang("Your e-mail must be valid.").'" />
<label class="floating-label">'._lang("Email").'</label>
</div>
<div class="form-group form-material floating">
<input type="password" class="form-control" name="password" required />
<label class="floating-label">'._lang("Password").'</label>
</div>
<div class="form-group clearfix">
<div class="checkbox-custom checkbox-inline checkbox-primary checkbox-lg pull-left">
<input type="checkbox" id="inputCheckbox" name="remember" checked=checked>
<label for="inputCheckbox">'._lang("Remember me").'</label>
</div>
<a class="pull-right" data-target="#forgot-pass" data-toggle="modal" href="javascript:void(0)">'._lang("Forgot password?").'</a>
</div>
<button type="submit" class="btn btn-primary btn-block mtop20">'._lang("Sign In").'</button>
</form>
<p class="mtop10">'._lang("Still no account? Please go to").' <a data-target="#register-now" data-toggle="modal" href="javascript:void(0)">'._lang("Sign up").'</a></p>
</div>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default btn-block" data-dismiss="modal">'._lang("Close").'</button>
</div>
</div>
</div>
</div>
<!-- End Login Modal -->
<!-- Start Recover Modal -->
<div class="modal fade" id="forgot-pass" aria-hidden="true" aria-labelledby="forgot-pass" role="dialog" tabindex="-1">
<div class="modal-dialog modal-sidebar modal-sm">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
<h4 class="modal-title">'._lang('Forgotten password').'</h4>
</div>
<div class="modal-body">
<div class="panel">
<div class="row">
<form method="post" action="'.site_url().'login" class="modal-form">
<div class="form-group form-material floating">
<input type="hidden" name="forgot-pass" value="1"/>
<input type="email" class="form-control" name="remail" data-error="'._lang("Your e-mail must be valid.").'" required/>
<label class="floating-label">'._lang("Your e-mail").'</label>
</div>
<button type="submit" class="btn btn-primary btn-block mtop20">'._lang("Recover now").'</button>
</form>
</div>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default btn-block" data-dismiss="modal">'._lang("Close").'</button>
</div>
</div>
</div>
</div>
<!-- End Recover Modal -->
<!-- Start Register Modal -->
<div class="modal fade" id="register-now" aria-hidden="true" aria-labelledby="register-now" role="dialog" tabindex="-1">
<div class="modal-dialog modal-sidebar modal-sm">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
<h4 class="modal-title">'._lang('Create an account').'</h4>
</div>
<div class="modal-body">
<div class="panel">
<div class="row">'.$socials;
if(get_option('allowlocalreg') == 1 ) {
$lg .= '	
<form method="post" action="'.site_url().'register" class="mtop10 modal-form">
<div class="form-group form-material floating">
<input type="name" class="form-control" name="name" required/>
<label class="floating-label">'._lang("Your name").'</label>
</div>
<div class="form-group form-material floating">
<input type="email" class="form-control" name="email" required/>
<label class="floating-label">'._lang("Email").'</label>
</div>

<div class="form-group form-material floating">
<input type="password" id="password1" class="form-control" name="password" required/>
<label class="floating-label">'._lang("Password").'</label>
</div>
<div class="form-group form-material floating">
<input type="password" class="form-control" name="password2" data-match="#password1" data-match-error="'._lang("Passwords do not match").'" required/>
<label class="floating-label">'._lang("Repeat password").'</label>
<div class="help-block with-errors"></div>
</div>';
if(!nullval(get_option("recaptcha-sk", null))) {
$lg .= '<div class="g-recaptcha" data-sitekey="'.get_option("recaptcha-sk").'" style="margin-left:-17px"></div>';
}
$lg .= '<button type="submit" class="btn btn-primary btn-block mtop20">'._lang("Create account").'</button>
</form>
</div>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default btn-block" data-dismiss="modal">'._lang("Close").'</button>
</div>
</div>
</div>
</div>
<!-- End Register Modal -->';

$lg .= "<script src='https://www.google.com/recaptcha/api.js'></script>";	
}
	
return $lg;
}

?>