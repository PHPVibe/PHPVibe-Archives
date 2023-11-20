<?php error_reporting(1);
// Fire up phpRevolution Framework 
require_once 'app/init.php';
//define site url variable
 $site_url = $config->site->url;
 
    /* -- Some Comments Settings, edit as you wish -- */
	
    //how to format dates
    $DATEFORMAT = '%c'; //see http://at2.php.net/manual/en/function.strftime.php for other possibilities
    //what to hide comments under SHOW MORE
    $CCOUNT     = 10;
    //Name Input Field Visible?
    $SHOWNAME   = false;
    //eMail Input Field Visible?
    $SHOWMAIL   = false;    
    //allow "liking" of comments?
    $ALLOWLIKE  = true;
    //enable tags (list tags you wish to enable eg 'IMG,A,B,SPAN')?
    $ENABLETAGS = 'img,a,b,strong';        
  
/* ----- Start cache system ----- */
$Cache = new CacheSys("cache/", 600);
$VidCache = new CacheSys("cache/videos/", 600000);

/* ----- Defines time to collect cache ----- */
$Cache->SetTtl(600);
$VidCache->SetTtl($config->cache->time);
/* ---- Call the bd class --- */
$dbi = new sqli();

/* --- This Root ---*/
$phpviberoot = dirname(__FILE__);

/* ---- Languages --- */

// Default language 
	$DEFAULT_LANGUAGE = $config->site->dlang;	
	// This is the directory to the available languages folder
	$LANGUAGE_DIR = $phpviberoot.'/langs';	
	// This is the directory to the language class
	// Makes the language class ready to be used
	$language = new Language();
	// Switches the languages through $_GET using buttons
	if(isset($_GET['lang'])){
   MK_Session::start('mk');
   $session = MK_Session::getInstance();
   unset($session->LANGUAGE);
   $session->LANGUAGE = $_GET['lang'];
  }
  	$lang = $language->getLanguage(@$session->LANGUAGE);
 ?>