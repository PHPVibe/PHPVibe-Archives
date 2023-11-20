<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
	
		<title><?=$username?>'s Profile</title>
		
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		
		<meta name="keywords" content="<?=$username?>">
		<meta name="description" content="Twitter opinions ( Tweets ) about the video <?=$video->title?>. Video Youtube <?=$video->title?> : <?=$meta_description?>">
		
		<base href="<?=$site_url?>" />
		
		<link href="<?=$site_url?>templates/<?=$template?>/style.css" rel="stylesheet" type="text/css" />
		<link rel="alternate" type="application/rss+xml" title="<?php echo $site_title; ?> Feed" href="<?php echo $site_url; ?>rss" />
		<link rel="shortcut icon" href="<?=$site_url?>templates/<?=$template?>/images/favicon.ico">
		
		<script type="text/javascript" src="<?=$site_url?>includes/prototype.js"></script>
				
<link href="<?=$site_url?>templates/<?=$template?>/dropdown/dropdown.css" media="all" rel="stylesheet" type="text/css" />
<link href="<?=$site_url?>templates/<?=$template?>/dropdown/themes/mainmenu/default.ultimate.css" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery/jquery.js"></script>
<!--[if lt IE 7]>
<script type="text/javascript" src="js/jquery/jquery.dropdown.js"></script>
<![endif]-->


	</head>
	
<body>
<div id="content">
	<?php include("header.php"); ?>
							
		<div id="left">

<div id="user_data">
<? 


echo '<h2>Profile of '.$username.'!!! </h2><br /> <br />';
echo '<img src="'.$avatar.'"/><br />';
echo 'Location: '.$city.' <br />';
echo 'About: '.$details.' <br />';
echo 'His blog: '.$blog.' <br />';
echo 'He twitted: '.$tweets.' tweets <br />';
echo 'And he\'s loved by : '.$followers.' twitter fans <br />';
?>
</div>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/><br/><h2>Let's see what he comments around here!!!</h2><br/><br/>
<div id='tweet_container'>
<ol class="timeline" id="com">

<?php

 
// Let's see if he commented of we pulled some video comments by him

$comsql = dbquery("SELECT * FROM comments WHERE uname = '".$username."'");
while($row = mysql_fetch_array($comsql)) 
{
$com = toLink($row['comment']);
$date = $row['date'];
$vidid = $row['vid'];
echo '<li>';
echo ''.$username.' said '.$com.' on '.$date.' for video id '.$vidid.'';
echo '</li>';
}
?>
</ol>
</div>
<?php
// Pulling users Tweets
echo '<br/><br/><h2>Let\'s see what he tweets about!!!</h2><br/><br/>';
?>
<div id='tweet_container'>
<ol class="timeline" id="updates">
<?php
$timesql = dbquery("SELECT * FROM timeline WHERE user = '".$username."' order by tid desc");
while($row=mysql_fetch_array($timesql)) 
{
$msg = toLink($row['tweets']);
echo '<li>';
echo $msg;
echo '</li>';
}
?>
</ol>
</div>


</div>
<!-- Right Side Content -->
	<div id="right">
	<?php echo '<img src="'.$big_avatar.'"/><br />'; ?>
      <?php echo '<h1>'.$username.' </h1><br /> <br />';?>
	  <div class="right_articles" style="clear:both;">
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
	<p>
	Hello <strong>{$user->screen_name}</strong><br />
	from <strong>{$user->location}</strong><br/>
	<img src=\"{$user->profile_image_url}\"><br />		
You have <strong>{$user->followers_count}</strong> Followers <br/>
Since you joined Twitter at <br/>
<strong>{$user->created_at}</strong><br/>
and you tweeted <strong>{$user->statuses_count} statuses</strong><br/>
You last tweeted: <br />
	<strong>{$user->status->text}</strong><br/>
	</p>";

	}
elseif(isset($_GET['denied']))
{
 // user denied access
 echo 'You must sign in through Twitter first!<br/><br/>';
 echo '<a href="' . $Twitter->getAuthenticateUrl() . '">
<img src="twitterButton.png" alt="sign in with twitter" />
</a>';
}
else
{
// user not logged in
 echo '<strong>Hello Stranger!</strong> Join the fun!<br/><br/>';
 echo '<a href="' . $Twitter->getAuthenticateUrl() . '">
<img src="twitterButton.png" alt="sign in with twitter" />
</a>';
}
	?>
</div>
	</div>
	<!-- Right Side Content / END -->


<!-- Footer -->
	<?php include("footer.php"); ?>
	<!-- Footer / END -->
	</div>	
</body>

</html>