 <?php



if (curPageName() != 'index.php') {
echo '<div class="right_ads">';
include("ads.php"); 
echo '</div>';
}

?>
<div class="right_articles">
	<?php


	    $Twitter = new EpiTwitter($consumerKey, $consumerSecret);

if(isset($_GET['oauth_token']) || (isset($_COOKIE['oauth_token']) && isset($_COOKIE['oauth_token_secret'])))
{
// user accepted access
	if( !isset($_COOKIE['oauth_token']) || !isset($_COOKIE['oauth_token_secret']) )
	{
		// user comes from twitter
	    $Twitter->setToken($_GET['oauth_token']);
		$token = $Twitter->getAccessToken();
		setcookie('oauth_token', $token->oauth_token);
		setcookie('oauth_token_secret', $token->oauth_token_secret);
		$Twitter->setToken($token->oauth_token, $token->oauth_token_secret);

	}
	else
	{
	 // user switched pages and came back or got here directly, stilled logged in
	 $Twitter->setToken($_COOKIE['oauth_token'],$_COOKIE['oauth_token_secret']);
	}

    $user= $Twitter->get_accountVerify_credentials();
	echo "
	 <p class=\"title\">
	Hello <strong>{$user->screen_name}</strong></p>
	<p>
	<img src=\"{$user->profile_image_url}\"><br />
	You last tweeted: <br />
	<strong>{$user->status->text}</strong><br/>

	</p>";

}
elseif(isset($_GET['denied']))
{
 // user denied access
 echo 'You must sign in through twitter first<br/>';
 echo '<a href="' . $Twitter->getAuthenticateUrl() . '">
<img src="twitterButton.png" alt="sign in with twitter" />
</a>';
}
else
{
// user not logged in
 echo 'You are not logged in<br/>';
 echo '<a href="' . $Twitter->getAuthenticateUrl() . '">
<img src="twitterButton.png" alt="sign in with twitter" />
</a>';
}
?>
	</div> 
<div class="right_articles">
	 <p class="title">New Members<p>
	 <?php newmembers() ?>
</div>             
        <div class="right_articles">
            <p class="title">Top Videos<p>
            <p><table width="100%"><? TopVideos() ?></table></p>
        </div>
          
        <div class="right_articles">
            <p class="title">Tag Cloud<p>
            <p><? TagCloud(40); ?></p>
        </div>