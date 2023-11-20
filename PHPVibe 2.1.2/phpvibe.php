<?php
error_reporting(0);
// This file initializes the Framework 
require_once 'admin/library/com/frame/framework.php';
// Connect to the database
MK_MySQL::connect();

// Start session & establish name-space
$session = MK_Session::getInstance();

// Get a copy of the sites config options
$config = MK_Config::getInstance();

// Define how cookies are used
$cookie = MK_Cookie::getInstance();

// Is phpVibe installed?
if( !$config->site->installed )
{
	header("Location: admin/", true, 302);
	exit;
}


// Check if user is logging in with Facebook
if( $config->site->facebook->login && ( $facebook_session = $facebook->getSession() ))
{
	$user_details = $facebook->api('/me');

	// Check if users has already logged in with this facebook account
	try
	{
		MK_Authorizer::authorizeByFacebookId( $user_details['id'] );
		$user = MK_Authorizer::authorize();
	}
	// If user hasn't logged in with this Facebook account
	catch( Exception $e )
	{
		// Check if this user is already registered with their Facebook email address 
		try
		{
			MK_Authorizer::authorizeByFacebookEmail( $user_details['email'] );
			$user = MK_Authorizer::authorize();
			
			if( !$user->getName() )
			{
				$user->setName( $user_details['name'] );
			}
			
			if( !$user->getAvatar() )
			{
				$user_details['picture'] = MK_FileManager::uploadFileFromUrl( 'http://graph.facebook.com/'.$user_details['id'].'/picture?type=large', $config->site->upload_path );
				$user->setAvatar( $user_details['picture'] );
			}

			$user
				->setFacebookId( $user_details['id'] )
				->save();
		}
		catch( Exception $e )
		{
			$user_module = MK_RecordModuleManager::getFromType('user');
			$user = MK_RecordManager::getNewRecord($user_module->getId());
			
			$user_details['picture'] = MK_FileManager::uploadFileFromUrl( 'http://graph.facebook.com/'.$user_details['id'].'/picture?type=large', $config->site->upload_path );
	
			$user
				->setEmail( $user_details['email'] )
				->setDisplayName( $user_details['name'] )
				->setName( $user_details['name'] )
				->setAvatar( $user_details['picture'] )
				->setType( MK_RecordUser::TYPE_FACEBOOK )
				->setFacebookId( $user_details['id'] )
				->save();
		}
	}

	$cookie->set('login', $user->getId(), $config->site->user_timeout);
	$session->login = $user->getId();
	
	if( !$redirect = $config->extensions->core->login_url )
	{
		$redirect = $logical_redirect;
	}
	header('Location: index.php', true, 302);
	exit;
}
// Check if user logged in with Twitter 
elseif( $config->site->twitter->login && $session->twitter_access_token )
{
	$user_details = $config->twitter->get('account/verify_credentials');
	unset($session->twitter_access_token);
	
	try
	{
		MK_Authorizer::authorizeByTwitterId( $user_details->id );
		$user = MK_Authorizer::authorize();

		$cookie->set('login', $user->getId(), $config->site->user_timeout);
		$session->login = $user->getId();
		
		if( !$redirect = $config->extensions->core->login_url )
		{
			$redirect = $logical_redirect;
		}
	}
	catch( Exception $e )
	{
		if( !$redirect = $config->extensions->core->login_url )
		{
			$redirect = $logical_redirect;
		}

		$session->twitter_details = serialize(
			array(
				'picture' => str_replace('_normal', '', $user_details->profile_image_url),
				'display_name' => $user_details->name,
				'name' => $user_details->name,
				'twitter_id' => $user_details->id,
				'email' => '',
			)
		);
	}

}
// Check if user hasn't finished logging in with Twitter
elseif( $config->site->twitter->login && !empty($session->twitter_details) && strpos($config->site->page_name, 'login.php') === false )
{
	header('Location: login.php', true, 302);
	exit;
}
// Check if user completed login with Twitter 
elseif( $config->site->twitter->login && !empty($session->twitter_details) )
{
	$user_details = unserialize( $session->twitter_details );
	if( !empty($user_details['email']) )
	{
	
		$user_details['picture'] = MK_FileManager::uploadFileFromUrl( $user_details['picture'], $config->site->upload_path );
	
		$user_module = MK_RecordModuleManager::getFromType('user');
		$user = MK_RecordManager::getNewRecord($user_module->getId());
	
		$user
			->setEmail( $user_details['email'] )
			->setDisplayName( $user_details['name'] )
			->setName( $user_details['name'] )
			->setAvatar( $user_details['picture'] )
			->setType( MK_RecordUser::TYPE_TWITTER )
			->setTwitterId( $user_details['twitter_id'] )
			->save();
	
		$cookie->set('login', $user->getId(), $config->site->user_timeout);
		$session->login = $user->getId();
		
		unset($session->twitter_details);
		header('Location: index.php', true, 302);
		exit;
	}
}
// advertising system
	require_once('ads.php');
	
	// Default language if you dont support browser language
	$DEFAULT_LANGUAGE = 'en';
	
	// This is the directory to the available languages folder
	$LANGUAGE_DIR = 'languages';
	
	// This is the directory to the language class
	require_once('language.php');
	
	// Makes the language class ready to be used
	$language = new Language();
	
	// Switches the languages through $_GET using buttons
	if(isset($_GET['lang'])):
   MK_Session::start('mk');
   $session = MK_Session::getInstance();
   unset($session->LANGUAGE);
   $session->LANGUAGE = $_GET['lang'];
   endif;
	
	$lang = $language->getLanguage(@$session->LANGUAGE);
		// Or you can use this method for your site language ignoring browser language and possibily to change site language
		//$lang = $language->getLanguage('en');
	
		
// If user session has expired but cookie is still active
if( $cookie->login && empty($session->login) )
{
	$session->login = $cookie->login;
}

// Get current user
if( !empty($session->login) )
{
    MK_Authorizer::authorizeById( $session->login );
}

$user = MK_Authorizer::authorize();
//define site url variable
 $site_url = $config->site->url;
 
     /***
     *  Form the user url
     ***/
    function jsEncode($address, $text){
	global $site_url;
	$the_u_url = $site_url.'user/'.$address.'/'.seo_clean_url($text) .'/';
        return '<a href="'.$the_u_url.'">'. $text.'</a>';
    }

    /***
     *  Get rid of all HTML in the input
     ***/
    function cleanInput($str){
        return nl2br(htmlspecialchars(strip_tags(trim(urldecode($str)))));
    }

    /***
     *  Make links clickable
     ***/
    function twitterify($ret) {
        $ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\" rel=\"nofollow\">\\2</a>", $ret);
        $ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\" rel=\"nofollow\">\\2</a>", $ret);
        $ret = preg_replace("/@(\w+)/", "<a href=\"http://www.twitter.com/\\1\" target=\"_blank\" rel=\"nofollow\">@\\1</a>", $ret);
        $ret = preg_replace("/#(\w+)/", "<a href=\"http://search.twitter.com/search?q=\\1\" target=\"_blank\" rel=\"nofollow\">#\\1</a>", $ret);
        return $ret;
    }
    
    /***
     *  Comment Like Text
     ***/
    function commentLikeText($total, $me=true){
        global $lang;
        
        if($me){
            if($total == 0){
                return $lang['youlikethis'];
            }elseif($total == 1){
                return $lang['youandone'];
            }else{
                return str_replace('XXX',$total,$lang['youandxx']);
            }       
        }else{
            if($total == 1){
                return $lang['onelikes'];
            }else{
                return str_replace('XXX',$total,$lang['xxlikethis']);
            }
        }
    }
####################################################################################

    /* -- Some UI Settings, edit as you wish -- */
    //how to format dates
    $DATEFORMAT = '%c'; //see http://at2.php.net/manual/en/function.strftime.php for other possibilities

    //what to hide comments under SHOW MORE
    $CCOUNT     = 2;

    //Name Input Field Visible?
    $SHOWNAME   = false;

    //eMail Input Field Visible?
    $SHOWMAIL   = false;
    
    //allow "liking" of comments?
    $ALLOWLIKE  = true;

    //enable tags (list tags you wish to enable eg 'IMG,A,B,SPAN')?
    $ENABLETAGS = 'img,a,b,strong';
    
    
    
    //comment moderator email
    $MODMAIL    = $config->site->email;
    
    //moderate comments? (will also send them via email)
    $MODCOM     = true;
    
    //email all new comments to the email address above?
    $MAILCOM    = true;

    //the address from which new comments are sent from
    $MAILFROM   = $config->site->email;



function removeCommonWords($input){
	 
	 	// EEEEEEK Stop words
		$commonWords = array('a','able','about','above','abroad','according','accordingly','across','actually','adj','after','afterwards','again','against','ago','ahead','ain\'t','all','allow','allows','almost','alone','along','alongside','already','also','although','always','am','amid','amidst','among','amongst','an','and','another','any','anybody','anyhow','anyone','anything','anyway','anyways','anywhere','apart','appear','appreciate','appropriate','are','aren\'t','around','as','a\'s','aside','ask','asking','associated','at','available','away','awfully','b','back','backward','backwards','be','became','because','become','becomes','becoming','been','before','beforehand','begin','behind','being','believe','below','beside','besides','best','better','between','beyond','both','brief','but','by','c','came','can','cannot','cant','can\'t','caption','cause','causes','certain','certainly','changes','clearly','c\'mon','co','co.','com','come','comes','concerning','consequently','consider','considering','contain','containing','contains','corresponding','could','couldn\'t','course','c\'s','currently','d','dare','daren\'t','definitely','described','despite','did','didn\'t','different','directly','do','does','doesn\'t','doing','done','don\'t','down','downwards','during','e','each','edu','eg','eight','eighty','either','else','elsewhere','end','ending','enough','entirely','especially','et','etc','even','ever','evermore','every','everybody','everyone','everything','everywhere','ex','exactly','example','except','f','fairly','far','farther','few','fewer','fifth','first','five','followed','following','follows','for','forever','former','formerly','forth','forward','found','four','from','further','furthermore','g','get','gets','getting','given','gives','go','goes','going','gone','got','gotten','greetings','h','had','hadn\'t','half','happens','hardly','has','hasn\'t','have','haven\'t','having','he','he\'d','he\'ll','hello','help','hence','her','here','hereafter','hereby','herein','here\'s','hereupon','hers','herself','he\'s','hi','him','himself','his','hither','hopefully','how','howbeit','however','hundred','i','i\'d','ie','if','ignored','i\'ll','i\'m','immediate','in','inasmuch','inc','inc.','indeed','indicate','indicated','indicates','inner','inside','insofar','instead','into','inward','is','isn\'t','it','it\'d','it\'ll','its','it\'s','itself','i\'ve','j','just','k','keep','keeps','kept','know','known','knows','l','last','lately','later','latter','latterly','least','less','lest','let','let\'s','like','liked','likely','likewise','little','look','looking','looks','low','lower','ltd','m','made','mainly','make','makes','many','may','maybe','mayn\'t','me','mean','meantime','meanwhile','merely','might','mightn\'t','mine','minus','miss','more','moreover','most','mostly','mr','mrs','much','must','mustn\'t','my','myself','n','name','namely','nd','near','nearly','necessary','need','needn\'t','needs','neither','never','neverf','neverless','nevertheless','new','next','nine','ninety','no','nobody','non','none','nonetheless','noone','no-one','nor','normally','not','nothing','notwithstanding','novel','now','nowhere','o','obviously','of','off','often','oh','ok','okay','old','on','once','one','ones','one\'s','only','onto','opposite','or','other','others','otherwise','ought','oughtn\'t','our','ours','ourselves','out','outside','over','overall','own','p','particular','particularly','past','per','perhaps','placed','please','plus','possible','presumably','probably','provided','provides','q','que','quite','qv','r','rather','rd','re','really','reasonably','recent','recently','regarding','regardless','regards','relatively','respectively','right','round','s','said','same','saw','say','saying','says','second','secondly','see','seeing','seem','seemed','seeming','seems','seen','self','selves','sensible','sent','serious','seriously','seven','several','shall','shan\'t','she','she\'d','she\'ll','she\'s','should','shouldn\'t','since','six','so','some','somebody','someday','somehow','someone','something','sometime','sometimes','somewhat','somewhere','soon','sorry','specified','specify','specifying','still','sub','such','sup','sure','t','take','taken','taking','tell','tends','th','than','thank','thanks','thanx','that','that\'ll','thats','that\'s','that\'ve','the','their','theirs','them','themselves','then','thence','there','thereafter','thereby','there\'d','therefore','therein','there\'ll','there\'re','theres','there\'s','thereupon','there\'ve','these','they','they\'d','they\'ll','they\'re','they\'ve','thing','things','think','third','thirty','this','thorough','thoroughly','those','though','three','through','throughout','thru','thus','till','to','together','too','took','toward','towards','tried','tries','truly','try','trying','t\'s','twice','two','u','un','under','underneath','undoing','unfortunately','unless','unlike','unlikely','until','unto','up','upon','upwards','us','use','used','useful','uses','using','usually','v','value','various','versus','very','via','viz','vs','w','want','wants','was','wasn\'t','way','we','we\'d','welcome','well','we\'ll','went','were','we\'re','weren\'t','we\'ve','what','whatever','what\'ll','what\'s','what\'ve','when','whence','whenever','where','whereafter','whereas','whereby','wherein','where\'s','whereupon','wherever','whether','which','whichever','while','whilst','whither','who','who\'d','whoever','whole','who\'ll','whom','whomever','who\'s','whose','why','will','willing','wish','with','within','without','wonder','won\'t','would','wouldn\'t','x','y','yes','yet','you','you\'d','you\'ll','your','you\'re','yours','yourself','yourselves','you\'ve','z','zero');

		return preg_replace('/\b('.implode('|',$commonWords).')\b/','',$input);
	}

function time_ago($date,$granularity=2) {
    $date = strtotime($date);
    $difference = time() - $date;
    $periods = array('decade' => 315360000,
        'year' => 31536000,
        'month' => 2628000,
        'week' => 604800, 
        'day' => 86400,
        'hour' => 3600,
        'minute' => 60,
        'second' => 1);
    if ($difference < 5) { // less than 5 seconds ago, let's say "just now"
        $retval = "posted just now";
        return $retval;
    } else {                            
        foreach ($periods as $key => $value) {
            if ($difference >= $value) {
                $time = floor($difference/$value);
                $difference %= $value;
                $retval .= ($retval ? ' ' : '').$time.' ';
                $retval .= (($time > 1) ? $key.'s' : $key);
                $granularity--;
            }
            if ($granularity == '0') { break; }
        }
        return $retval.' ago';      
    }
}


/* ----- Define chache system ----- */
include_once("com/cache.php");
$Cache = new CacheSys("cache/", 600);
$VidCache = new CacheSys("cache/videos/", 600000);
$FeedCache = new CacheSys("cache/feeds/", 86400);
/* ----- Defines time to collect cache ----- */
$Cache->SetTtl(600);
$VidCache->SetTtl(600000);
$FeedCache->SetTtl(86400);

include_once("tpl/videoloop.php");

function html_back($input) 
{
	$original = array("<", ">", "&", '"', "'", "'");
	$replaced = array("&lt;", "&gt;", "&amp;", "&quot;","&apos;", "&#039;");
	$newinput = str_replace($replaced, $original, $input);
	
	return htmlspecialchars_decode($newinput);
}

    ####################################################################################################
    /* ----- DO NOT EDIT BELOW THIS LINE ----- */
    //open the actual DB connection
    try{
        $db = new PDO('mysql:host='.$config->db->host.';dbname='.$config->db->name,$config->db->username,$config->db->password,array());
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
        $db->exec("SET NAMES 'utf8'");
    }catch (exception $e){
        header('Content-type: application/x-json');
        echo json_encode(array('dberror' => $e->getMessage()));
        exit;
    }
	
 ?>
