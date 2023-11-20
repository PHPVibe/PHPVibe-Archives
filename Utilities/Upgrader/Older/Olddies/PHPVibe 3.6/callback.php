<?php error_reporting(0);
//ini_set('display_errors', '1');
include 'load.php';
ob_start();
if (is_user()) { redirect();}

//Check callback type(twitter, facebook, google)
if (!empty($_GET['type'])) {
    $cookieArr = array();
    switch ($_GET['type']) {
        case 'twitter':
            //Initialize twitter by using factory pattern over main class
			require_once( INC.'/twitter/EpiCurl.php' );
			require_once( INC.'/twitter/EpiOAuth.php' );
            require_once( INC.'/twitter/EpiTwitter.php' );
             $twitterObj = new EpiTwitter(Tw_Key, Tw_Secret);
			// var_dump($twitterObj);
			//  echo "<br /> ------------------------ <br />";
            $twitterObj->setToken($_GET['oauth_token']);
            $token = $twitterObj->getAccessToken();
            $twitterObj->setToken($token->oauth_token, $token->oauth_token_secret);
            $twitterInfo= $twitterObj->get_accountVerify_credentials();	
            //var_dump($twitterInfo);
			// echo "<br /> ------------------------ <br />";			
			$keys_values = array(
                                "oauth_token" => $token->oauth_token,
								"oauth_token_secret" => $token->oauth_token_secret,
                                "name" => $twitterInfo->name,
                                "username" => $twitterInfo->screen_name,								
								"email"=> NULL,	
                                "avatar"=> $twitterInfo->profile_image_url,								
                                "type"=>"twitter"  );
				
				
           
            break;
        case 'facebook':
            //Initialize facebook by using factory pattern over main class
            require_once( INC.'/fb/facebook.php' );
			$facebook = new Facebook(array(
  'appId'  => Fb_Key,
  'secret' => Fb_Secret,
));
 // Get User ID
$user = $facebook->getUser();          
	if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

$user_pic = user::getDataFromUrl('http://graph.facebook.com/'.$user_profile["id"].'/picture?type=large&redirect=false');
$avatarInfo = json_decode($user_pic);
$user_profile["img"] = $avatarInfo->data->url;
$loc = null;
if(!empty($user_profile["location"]["name"])) {
$loc = explode(",", $user_profile["location"]["name"]);
}
 $keys_values = array(
                                "fid"=>$user_profile["id"],
                                "name"=>$user_profile["name"],
								"username"=>$user_profile["username"],
								"email"=>$user_profile["email"],
								"local"=>$loc[0],
								"country"=>$loc[1],
								"email"=>$user_profile["email"],
								"bio"=>$user_profile["bio"],
								"gender"=>$user_profile["gender"],
								"avatar"=>$user_profile["img"],
                                "type"=>"facebook"                        
                               
                             
                             );
//var_dump($keys_values); 							 
            break;
        case 'google':
                //Initialize google by using factory pattern over main class
                require_once( INC.'/google/openid.php');				 
				$googleObj =  new LightOpenID();
                if ($googleObj->validate()) {
                    $identity = $googleObj->identity;
                    $attributes = $googleObj->getAttributes();
                    $email = $attributes['contact/email'];
                    $first_name = $attributes['namePerson/first'];
                    $last_name = $attributes['namePerson/last'];
				//echo $attributes['openid_claimed_id'].'<br /> <br />';
               
                /**
                 * Prepare data inorder to send it to the complete registration 
                 **/
                				
				$keys_values = array(
                                "gid"=>$_GET["openid_claimed_id"],
                                "name"=>$first_name . ' ' . $last_name,								
								"email"=>$email,								
                                "type"=>"google"  );
				 }
				//var_dump($keys_values); 
				
                //Redirect main page for user data ceck from db
               // SocialAuth::redirectParentWindow('google', $dataArr, $_COOKIE['ref']);
                break;
        
       
    }

if(isset($keys_values) && is_array($keys_values)) {	
$id = user::checkUser($keys_values);
if(!$id) {
$id = user::AddUser($keys_values);
user::LoginUser($id);
if (is_user()) { redirect(site_url().'index.php');}
} else {
user::LoginUser($id);
if (is_user()) { redirect(site_url().'index.php');}
}


} else {
echo _lang('Error. Please go back');
}
} else {
echo _lang('Error. Please go back');
}

?>

 
