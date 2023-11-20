<?php
include 'EpiCurl.php';
include 'EpiOAuth.php';
include 'EpiTwitter.php';
include 'keys.php';
require_once("mainfile.php");

$mysql_hostname = $DB_HOST;
$mysql_user = $DB_USER;
$mysql_password = $DB_PASS;
$mysql_database = $DB_NAME;
$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
mysql_select_db($mysql_database, $bd) or die("Could not select database");


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
	Username: <br />
	<strong>{$user->screen_name}</strong><br />
	Profile Image:<br/>
	<img src=\"{$user->profile_image_url}\"><br />	
	Location <br />
	<strong>{$user->location}</strong><br/>
	About <br/>
	<strong>{$user->description}</strong><br/>
Website <br/>
<strong>{$user->url}</strong><br/>
Twitter Followers <br/>
<strong>{$user->followers_count}</strong><br/>
Using Twitter since
<strong>{$user->created_at}</strong><br/>
Tweeted<br/>
<strong>{$user->statuses_count} statuses</strong><br/>

	</p>";
	echo "
	<p>
	Last Tweet: <br />
	<strong>{$user->status->text}</strong><br/>

	</p>";
$oauth_token = $_COOKIE['oauth_token'];
$oauth_token_secret = $_COOKIE['oauth_token_secret'];

// Storing token keys
$check = dbrows(dbquery("SELECT uname FROM users WHERE uname = '".$user->screen_name."'"));
if($check == 0):
dbquery("insert into users(uname,oauth_token,oauth_token_secret,uimg,uloc,uabout,uweb,utweet,ufollow)values('$user->screen_name','$oauth_token','$oauth_token_secret', '$user->profile_image_url', '$user->location', '$user->description', '$user->url', '$user->statuses_count', '$user->followers_count')");
else:
dbquery("update users SET oauth_token='$oauth_token',
oauth_token_secret='$oauth_token_secret', uimg ='$user->profile_image_url', uabout ='$user->description', utweet='$user->statuses_count', ufollow='$user->followers_count'  where uname='$user->screen_name'");

endif;


// Grab the timeline and save it

for ($i = 1; $i <= 2; $i++) {	
$page_url = 'http://twitter.com/statuses/user_timeline/'.$user->screen_name.'.rss?&page=';
$feedURL = $page_url . $i;
$doc = new DOMDocument();
$doc->load($feedURL);
foreach ($doc->getElementsByTagName('item') as $node) {
        $user_tweets = $node->getElementsByTagName('title')->item(0)->nodeValue;
		$user_tweeted_raw = str_replace("".$user->screen_name.":", "",$user_tweets);
		$user_tweeted = cleanQuery($user_tweeted_raw);
		$check = dbrows(dbquery("SELECT * FROM timeline WHERE user = '".$user->screen_name."' AND tweets='".$user_tweeted."' "));
		if($check == 0):
        dbquery("insert into timeline(user,tweets)values('$user->screen_name','$user_tweeted')");
endif;
// show the user his timeline
// $my_time = dbquery("SELECT * FROM 'timeline' WHERE user = '".$user->screen_name."'");
$timesql = dbquery("SELECT * FROM timeline WHERE user = '".$user->screen_name."' order by tid desc");
while($row=mysql_fetch_array($timesql)) 
{
$msg=$row['tweets'];
echo $msg;
echo '<br/>';
}
}
}

header("Location: $site_url/user/$user->screen_name");
}

elseif(isset($_GET['denied']))
{
 // user denied access
 echo 'You must sign in through Twitter first';
 echo '<a href="' . $Twitter->getAuthenticateUrl() . '">
<img src="twitterButton.png" alt="sign in with twitter" />
</a>';
}
else
{
// user not logged in
 echo 'You are not logged in';
 echo '<a href="' . $Twitter->getAuthenticateUrl() . '">
<img src="twitterButton.png" alt="sign in with twitter" />
</a>';


}