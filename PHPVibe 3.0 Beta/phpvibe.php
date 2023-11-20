<?php error_reporting(1);
// Fire up phpRevolution Framework 
require_once 'app/init.php';
// Default language 
	$DEFAULT_LANGUAGE = 'en';	
	// This is the directory to the available languages folder
	$LANGUAGE_DIR = 'langs';	
	// This is the directory to the language class
	require_once('language.php');	
	// Makes the language class ready to be used
	$language = new Language();
	$lang = $language->getLanguage('en');

//define site url variable
 $site_url = $config->site->url;
 
    /* -- Some Comments Settings, edit as you wish -- */
	
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


/* ----- Start cache system ----- */
$Cache = new CacheSys("cache/", 600);
$VidCache = new CacheSys("cache/", 600000);

/* ----- Defines time to collect cache ----- */
$Cache->SetTtl(600);
$VidCache->SetTtl(600000);
 ?>