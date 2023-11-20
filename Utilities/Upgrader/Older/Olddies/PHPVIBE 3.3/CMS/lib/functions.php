<?php /*!
 * phpVibe v3.3
 *
 * Copyright Media Vibe Solutions
 * http://www.phpRevolution.com
 * phpVibe IS NOT A FREE SOFTWARE
 * If you have downloaded this CMS from a website other
 * than www.phpvibe.com or www.phpRevolution.com or if you have received
 * this CMS from someone who is not a representative of phpVibe, you are involved in an illegal activity.
 * The phpVibe team takes actions against all unlincensed websites using Google, local authorities and 3rd party agencies.
 * Designed and built exclusively for sale @ phpVibe.com & phpRevolution.com.
 */

// Global functions
//Site url
function site_url() {
return SITE_URL;
}
function redirect($url=null) {	
	if(!$url) { 	$url = site_url(); 	}
	header('Location: '.$url);
	exit();
}

//array isset	  
function _globalIsSet($arrayPostGet,$postGetList){
$flagValidation = true;
foreach ($postGetList as $testValue){
if (!(isset($arrayPostGet[$testValue]))){
$flagValidation = false;
}
}
return $flagValidation;
}
//returns current page
function this_page() {
$page = isset($_GET['p']) ? intval($_GET['p']) : 1;
return $page;
}
//return next page
function next_page(){
return this_page() + 1;
}
//query limit
function this_limit(){
$limit = 'LIMIT ' .(this_page() - 1) * bpp() .',' .bpp(); 
return $limit;
}
//query offset
function this_offset($nr){
$limit = 'LIMIT ' .(this_page() - 1) * $nr .',' .$nr; 
return $limit;
}
//browse per page
function bpp() {
if(get_option('bpp') > 0) {
return get_option('bpp');
}
return 24;
}
//ajax call
function is_ajax_call() {
global $_GET;
return (isset($_GET['ajax']) || isset($_GET['lightbox'] ));
}
//check if value is null
function nullval($value){
if(is_null($value) || $value==""){
return true;  }
else { return false;
}
}
//global time ago	
function time_ago($date,$granularity=2) {
	  if (nullval($date)) {
	  return '';
	  }
    $periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths         = array("60","60","24","7","4.35","12","10");
 
    $now             = time();
    $unix_date         = strtotime($date);
 
       // check validity of date
    if(empty($unix_date)) {    
        return $date;
    }
 
    // is it future date or past date
    if($now > $unix_date) {    
        $difference     = $now - $unix_date;
        $tense         = "ago";
 
    } else {
        $difference     = $unix_date - $now;
        $tense         = "from now";
    }
 
    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }
 
    $difference = round($difference);
 
    if($difference != 1) {
        $periods[$j].= "s";
    }
 
    return "$difference $periods[$j] {$tense}";
}
	
//return search engine query	
function get_search_term_engine($url){
        $query_term ='';
        //add more engines as required
       // $url = 'http://www.yahoo.co.uk/?hl=en&cp=33&gs_id=29&xhr=t&q=detect+search+engine+referrer+php&pf=p&sclient=psy&source=hp&pbx=1&oq=detect+search+engine+referrer+php&aq=f&aqi=&aql=&gs_sm=&gs_upl=&bav=on.2,or.r_gc.r_pw.&fp=42c36fc8de204fb4&biw=1024&bih=604';
        if(preg_match('/[\.\/](google|yahoo|bing|mywebsearch|ask|alltheweb)\.[a-z\.]{2,5}[\/]/i',$url,$search_engine)){
        
                    //new google uses a # in some cases so PHP_URL_QUERY will not work.
                    preg_replace('/#/', '?', $url, 1);
                    //$search_engine[0]= str_replace('/', '', $search_engine[0]);
                    $search_engine[0]= preg_replace('/\//', '', $search_engine[0], 1);
                   $search_engine[0]= preg_replace('/./', '', $search_engine[0], 1);
                    // Parse the URL into an array
                    $parsed = parse_url( $url, PHP_URL_QUERY );
                    
                    // Parse the query string into an array
                    parse_str( $parsed, $query );
                    
                    if (isset($parsed['q'])){
                        $query_term=$parsed['q'];
                    }
                    else if (isset($parsed['p'])){
                        $query_term=$parsed['p'];
                    }
                    if(trim($query_term)!=''){
                        $query_term='---';
                    }
                    
                    return array('searchterm'=>$query_term,"searchengine"=>$search_engine[0]);
}
        else{
             return null;
        }

    }
	

/**
 * Read an option from DB (or from cache if available). Return value or $default if not found
 *
 */
function get_option( $option_name, $default = false ) {
	global $db, $all_options;
	
	// Allow plugins to short-circuit options
	$pre = apply_filter( 'shunt_option_'.$option_name, false );
	if ( false !== $pre )
		return $pre;

	// If option not available already, get its value from the DB
	if ( !isset( $all_options[$option_name] ) ) {
		
		$option_name = escape( $option_name );
		$row = $db->get_row( "SELECT `option_value` FROM ".DB_PREFIX."options WHERE `option_name` = '$option_name' LIMIT 1" );
		if ( is_object( $row) ) { // Has to be get_row instead of get_var because of funkiness with 0, false, null values
			$value = $row->option_value;
		} else { // option does not exist, so we must cache its non-existence
			$value = $default;
		}
		$all_options[ $option_name ] = maybe_unserialize( $value );
	}

	return apply_filter( 'get_option_'.$option_name, $all_options[$option_name] );
}

/**
 * Read all options from DB at once
 *
 */
function get_all_options() {
	global $cachedb;
	$vibe_opt = array();

	// Allow plugins to short-circuit all options. (Note: regular plugins are loaded after all options)
	$pre = apply_filter( 'shunt_all_options', false );
	if ( false !== $pre )
		return $pre;

	$allopt = $cachedb->get_results( "SELECT `option_name`, `option_value` FROM  ".DB_PREFIX."options where autoload='yes'" );
	
	foreach( (array)$allopt as $option ) {
		$vibe_opt[$option->option_name] = maybe_unserialize( $option->option_value );
	}
	
	$vibe_opts = apply_filter( 'get_all_options', $vibe_opt );
	
	return $vibe_opts;
}

/**
 * Update (add if doesn't exist) an option to DB
 *
 */
function update_option( $option_name, $newvalue ) {
	global $db;
	

	$safe_option_name = escape( $option_name );

	$oldvalue = get_option( $safe_option_name );

	// If the new and old values are the same, no need to update.
	if ( $newvalue === $oldvalue )
		return false;

	if ( false === $oldvalue ) {
		add_option( $option_name, $newvalue );
		return true;
	}

	$_newvalue = escape( maybe_serialize( $newvalue ) );
	
	//do_action( 'update_option', $option_name, $oldvalue, $newvalue );

	$db->query( "UPDATE  ".DB_PREFIX."options SET `option_value` = '$_newvalue' WHERE `option_name` = '$option_name'" );

	if ( $db->rows_affected == 1 ) {
		$db->option[ $option_name ] = $newvalue;
		return true;
	}
	return false;
}

/**
 * Add an option to the DB
 *
 */
function add_option( $name, $value = '' ) {
	global $db;
	
	$safe_name = escape( $name );

	// Make sure the option doesn't already exist
	if ( false !== get_option( $safe_name ) )
		return;

	$_value = escape( maybe_serialize( $value ) );

	//do_action( 'add_option', $safe_name, $_value );

	$db->query( "INSERT INTO  ".DB_PREFIX."options (`option_name`, `option_value`) VALUES ('$name', '$_value')" );
	return;
}


/**
 * Delete an option from the DB
 *
 */
function delete_option( $name ) {
	global $db;
	
	$name = escape( $name );

	// Get the ID, if no ID then return
	$option = $db->get_row( "SELECT option_id FROM  ".DB_PREFIX."options WHERE `option_name` = '$name'" );
	if ( is_null( $option ) || !$option->option_id )
		return false;
		
	//do_action( 'delete_option', $option_name );		
	$db->query( "DELETE FROM  ".DB_PREFIX."options WHERE `option_name` = '$name'" );
	return true;
}
// seo rewrite function
function nice_url($url) {
$string ='';
//$url = check_invalid_utf8($url);
// translate other languages
$url = url_translate($url);
// remove all chars
$url = preg_replace("/[^a-z0-9]+/","-",strtolower($url));
//remove doubled -
$url = str_replace(array('-----','----','---','--'),'-', $url);
return urlencode(strtolower($url));
}
function url_translate($string) {
$specialchars = array(
		// Latin
		'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C', 
		'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 
		'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O', 
		'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH', 
		'ß' => 'ss', 
		'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c', 
		'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 
		'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o', 
		'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th', 
		'ÿ' => 'y',
 
		// Latin symbols
		'©' => '(c)',
 
		// Greek
		'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
		'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
		'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
		'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
		'Ϋ' => 'Y',
		'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
		'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
		'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
		'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
		'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
 
		// Turkish
		'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
		'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g', 
 
		// Russian
		'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
		'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
		'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
		'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
		'Я' => 'Ya',
		'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
		'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
		'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
		'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
		'я' => 'ya',
 
		// Ukrainian
		'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
		'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
 
		// Czech
		'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U', 
		'Ž' => 'Z', 
		'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
		'ž' => 'z', 
 
		// Polish
		'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z', 
		'Ż' => 'Z', 
		'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
		'ż' => 'z',
 
		// Latvian
		'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N', 
		'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
		'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
		'š' => 's', 'ū' => 'u', 'ž' => 'z'
	);
return strtr($string,$specialchars);
}
//return safe GET
function _get($val){
global $_GET;
if(isset($_GET[$val])) {
return esc_attr($_GET[$val]);
}
return null;
}
//return safe GET integer
function _get_int($val){
return intval(_get($val));
}
//return safe POST
function _post($val){
global $_POST;
if(isset($_POST[$val])) {
return esc_attr($_POST[$val]);
}
return null;
}
//return safe POST integer
function _post_int($val){
return intval(_post($val));
}
//return percent
function percent($first, $num_total, $precision = 0) {
if ($num_total > 0){
$res = round( ($first / $num_total) * 100, $precision );
return $res;
} elseif($first > 0) {
return 100;
}
return 0;
}
//limit a string
function _cut($str,$nb=10) {
	    if (strlen($str) > $nb) {
		if (extension_loaded('mbstring')) {
		mb_internal_encoding("UTF-8");
	    $str = mb_substr($str, 0, $nb);	       
	    } else {
		 $str = substr($str, 0, $nb);
		}
		}
	    return $str;
	}
//Language function	
function current_lang() {
$cl = isset($_SESSION['phpvibe-language'])? $_SESSION['phpvibe-language'] : get_option('def_lang');
return $cl;
}
function lang_terms($lang = null){
global $db;
$lang = (is_null($lang)) ? current_lang() : $lang;
$all_terms  = get_language($lang);
if(is_null($all_terms) || !is_array($all_terms)) {
//Switch to english if 
$all_terms  = get_language('en');
} 
return $all_terms;
}
function _lang($txt) {
global $trans;
if (isset($trans[$txt])){
return $trans[$txt];
} else {
lang_log($txt);
return $txt;
}	
}
/**
 * Log term in the DB
 *
 */
 function lang_log($txt) {
 global $db;
 if($db) {
 $txt = escape($txt);
 /* Check if term exists in matrix */
 $check = $db->get_row( "SELECT count(*) as nr FROM  ".DB_PREFIX."langs WHERE `term` = '$txt'" );
if ( !$check || ($check->nr < 1) ) {
//Insert term
 $db->query( "INSERT INTO  ".DB_PREFIX."langs (`term`) VALUES ('$txt')" );
 }
 }
 }
/**
 * Get language terms from the DB
 *
 */
function get_language( $lang_code, $default = false ) {
	global $cachedb;
	
		$lang_code = escape( $lang_code );
		$row = $cachedb->get_row( "SELECT `lang_terms` FROM ".DB_PREFIX."languages WHERE `lang_code` = '$lang_code' LIMIT 1" );
		if ( is_object( $row) ) { // Has to be get_row instead of get_var because of funkiness with 0, false, null values
			$value = $row->lang_terms;
		} else { // language does not exist, so we must cache its non-existence
			$value = $default;
		}	

	return apply_filter( 'get_language_'.$lang_code,  maybe_unserialize( $value ) );
}
/**
 * Add an language to the DB
 *
 */
function add_language( $name, $value = '' ) {
	global $db;
	
	$safe_name = escape( $name );
	$long_name = escape($value["language-name"]);

	// Make sure the language doesn't already exist
$language = $db->get_row( "SELECT term_id FROM  ".DB_PREFIX."languages WHERE `lang_code` = '$name'" );
	if ( !$language || !$language->term_id ) {
	$_value = escape( maybe_serialize( $value ) );

	//do_action( 'add_language', $safe_name, $_value );

	$db->query( "INSERT INTO  ".DB_PREFIX."languages (`lang_name`, `lang_code`, `lang_terms`) VALUES ('$long_name','$name', '$_value')" );
	}
	return;
}


/**
 * Delete an language from the DB
 *
 */
function delete_language( $name ) {
	global $db;
	
	$name = escape( $name );

	// Get the ID, if no ID then return
	$language = $db->get_row( "SELECT term_id FROM  ".DB_PREFIX."languages WHERE `lang_code` = '$name'" );
	if ( is_null( $language ) || !$language->term_id )
		return false;
		
	//do_action( 'delete_language', $lang_code );		
	$db->query( "DELETE FROM  ".DB_PREFIX."languages WHERE `lang_code` = '$name'" );
	return true;
}
/* end language */
//Common actions
function the_header(){
do_action('vibe_header');
}
function the_footer() {
do_action('vibe_footer');
}
function the_sidebar() {
do_action('vibe_sidebar');
}
function vibe_headers () {
echo apply_filters('vibe_meta_filter', meta_add());
echo apply_filters('vibe_header_filter', header_add());
}
function vibe_footers() {
echo apply_filters('vibe_footer_filter', footer_add());
}

//Map the actions
add_action('vibe_header', 'vibe_headers', 1);
add_action('vibe_footer', 'vibe_footers', 1);

//sidebar
function the_side(){
global $db;
include_once(TPL.'/sidebar.php');
}

add_action('vibe_sidebar', 'the_side', 1);

function _copy($text){
$text = $text.'<p>'.base64_decode(get_option('softc')).' '.get_option('licto').'</p>';
return $text;
}
add_filter('tfc', '_copy');

//Video time func
function video_time($sec, $padHours = false) {
    $hms = "";    
    // there are 3600 seconds in an hour, so if we
    // divide total seconds by 3600 and throw away
    // the remainder, we've got the number of hours
    $hours = intval(intval($sec) / 3600); 
 if ($hours > 0):
    // add to $hms, with a leading 0 if asked for
    $hms .= ($padHours) 
          ? str_pad($hours, 2, "0", STR_PAD_LEFT). ':'
          : $hours. ':';
     endif;
    // dividing the total seconds by 60 will give us
    // the number of minutes, but we're interested in 
    // minutes past the hour: to get that, we need to 
    // divide by 60 again and keep the remainder
    $minutes = intval(($sec / 60) % 60); 
    // then add to $hms (with a leading 0 if needed)
    $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ':';
    // seconds are simple - just divide the total
    // seconds by 60 and keep the remainder
    $seconds = intval($sec % 60); 
    // add to $hms, again with a leading 0 if needed
    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
    return $hms;
}
// SEO Func support
function video_url($id, $title, $list=null){
if(is_null($list)){
return site_url().video.url_split.$id.url_split.nice_url($title).'/';
}
//else keep the list
return site_url().video.url_split.$id.url_split.nice_url($title).'&list='.$list;
}
function profile_url($id, $title){
return site_url().profile.url_split.nice_url($title).url_split.$id.'/';
}
function playlist_url($id, $title){
return site_url().playlist.url_split.nice_url($title).url_split.$id.'/';
}
function channel_url($id, $title){
return site_url().channel.url_split.nice_url($title).url_split.$id.'/';
}
function note_url($id, $title=null){
if(!is_null($title)) {
return site_url().note.url_split.$id.url_split.nice_url($title).'/';
}
return site_url().note.url_split.$id.'/';
}
function list_url($part){
return site_url().videos.url_split.$part.'/';
}
//Misc functions
function render_video($code) {
global $width,$height;
$code = htmlspecialchars_decode(specialchars_decode($code));
 //just in case this failed on submit
		$embed = preg_replace('/width="([0-9]+)"/i', 'width="##videoW##"', $code);
		$embed = preg_replace('/height="([0-9]+)"/i', 'height="##videoH##"', $embed);
		$embed = preg_replace('/value="(window|opaque|transparent)"/i', 'value="transparent"', $embed);
		$embed = preg_replace('/wmode="(.*?)"/i', 'wmode="transparent"', $embed);
		$embed = preg_replace('/width=([0-9]+)/i', 'width=##videoW##', $embed);
		$embed = preg_replace('/height=([0-9]+)/i', 'height=##videoH##', $embed);
		//add new size
		$postembed = str_replace("##videoW##",$width,$embed);
        $postembed = str_replace("##videoH##",$height,$postembed);
		
return $postembed;
}
// Mini Layout func
function layout($part){
global $db, $video, $cachedb;
include_once(TPL.'/'.$part.'.php');
}
function tpl() {
return site_url().'tpl/'.THEME.'/';
}
// NSFW
function nsfilter() {
global $video;
if($video->nsfw < 1){
return false;
}elseif(isset($_SESSION['nsfw']) && $_SESSION['nsfw'] > 0){
 return false;
}else {
return true;
}
}
//SEO
function seo_title() {
return apply_filters( 'phpvibe_title', get_option('seo_title'));
}
function seo_desc() {
return apply_filters( 'phpvibe_desc', get_option('seo_desc'));
}
//Db count
function _count($table, $field=null, $sum=false){
global $db;
if($field && !$sum) {
$c = $db->get_row("SELECT count(".$field.") as nr FROM ".DB_PREFIX.$table);
} elseif ($field && $sum) {
$c = $db->get_row("SELECT sum(".$field.") as nr FROM ".DB_PREFIX.$table);
} else {
$c = $db->get_row("SELECT count(*) as nr FROM ".DB_PREFIX.$table);

}
return number_format($c->nr, 0);
}
//Fb count 
function _fb_count($name){
if(get_option('Fb_Key') && get_option('Fb_Secret')) {
$fans = get_option('fb-fans');
$checked = get_option('fb-fans-checked');
if(($checked + 1400) < time()) { 

require_once( INC.'/fb/facebook.php' );

$facebook = new Facebook(array(
  'appId'  => get_option('Fb_Key'),
  'secret' => get_option('Fb_Secret'),
));

if($facebook) {
$got = $facebook->api($name);
//Update values
update_option('fb-fans', $got['likes']);
update_option('fb-fans-checked', time());
return $got['likes'];
}
} else { return $fans; }
}
}
// Thumb fix
function thumb_fix($thumb, $resize = false, $w=280, $h=280) {
if($thumb) {
if (strpos($thumb, "http") === 0) {
return $thumb;
} elseif($resize) {
return site_url().'res.php?src='.$thumb.'&q=100&w='.$w.'&h='.$h;
}else {
return site_url().$thumb;
}
}
}
//Prettify tags
function pretty_tags($tags, $class='', $pre='', $post = ''){
$list ='';
$keywords_array = explode(',', $tags);
if (count($keywords_array) > 0){
foreach ($keywords_array as $keyword){
if ($keyword != ""){
$qterm = nice_url(trim($keyword));
$k_url = site_url().show.'/'.$qterm.'/';
$list .=  $pre.'<a class="'.$class.'" href="'.$k_url.'">'.$keyword.'</a>'.$post;
}
}
}
return $list;
}
//Guess next video
function guess_next($list=null) {
global $video, $db;
//Small fix if id is low
//to avoid errors
if(is_null($list) || ($list < 1)) {
$videox = $db->get_row("SELECT id ,title from ".DB_PREFIX."videos where id > $video->id order by id asc");
} else {
$videox = $db->get_row("SELECT id ,title from ".DB_PREFIX."videos where id < $video->id and id in(select video_id from ".DB_PREFIX."playlist_data where playlist=$list ) order by id desc");
if(!$videox) {
/* Try again if no smaller id */
$videox = $db->get_row("SELECT id ,title from ".DB_PREFIX."videos where id <> $video->id and id in(select video_id from ".DB_PREFIX."playlist_data where playlist=$list ) order by id desc");
}
}
$next = array();
if($videox) {
$next['av'] = true;
if(is_null($list)) {
$next['link'] = video_url($videox->id , $videox->title);
} else {
$next['link'] = video_url($videox->id , $videox->title).'&list='.$list;
}
$next['title'] = stripslashes($videox->title);
} else {
//Avoid warnings
$next['av'] = false;
$next['link'] = null;
$next['title'] = null;
}
return $next;
}
function has_list() {
return (!is_null(_get('list')) && (intval(_get('list')) > 0));
}
function isPost () {
return strtolower($_SERVER['REQUEST_METHOD']) === 'post';
}
function the_nav() {
global $db, $cachedb;
include( INC.'/class.tree.php' );
$tree = new Tree;
$nav = '<div class="CNav"> ';                 
$nav .=' <a href="'.canonical().'#!/#back" class="CNav-back hide tipN" title="'._lang("Back one level").'" id="CNav-back"><i class="icon-double-angle-left"></i></a>';
$nav .='<div class="CNav-body"><div class="CNav-wrapper" id="CNav">';
$categories = $cachedb->get_results("SELECT cat_id as id, child_of as ch, cat_name as name FROM  ".DB_PREFIX."channels limit 0,10000");
if($categories) {	
foreach ($categories as $cat) {
if($cat->ch < 1) {$cat->ch = null;}
		$label = '<a href="'.channel_url($cat->id, $cat->name).'" title="'. stripslashes($cat->name).'">'. stripslashes($cat->name).'</a>';
		$li_attr = '';		
		$tree->add_row($cat->id, $cat->ch, $li_attr, $label);
	}
$nav .=$tree->generate_list();	
}
$nav .='</div></div></div>';				
return apply_filters('the_navigation' , $nav);
}
function subscribe_box($user, $btnc = "button small-button nomargin", $counter = true){
global $db;
if (!is_user()) {
//It's guest
echo '<a class="'.$btnc.'" href="'.site_url().'login/"><i class="icon-bell"></i>'._lang('Subscribe').'</a>';
if ($counter) { echo '<span class="count-subscribers"><span class="nr">'.get_subscribers($user).'</span></span>'; }
} elseif ($user <> user_id()) {
//If it's not you
$check = $db->get_row("SELECT count(*) as nr from ".DB_PREFIX."users_friends where uid ='".$user."' and fid='".user_id()."'");
if($check->nr < 1) {
//You're not subscribed
echo '<a id="subscribe" class="'.$btnc.' subscriber" href="javascript:Subscribe('.$user.', 1)"><i class="icon-bell"></i>'._lang('Subscribe').'</a>';
 if ($counter) { echo '<span class="count-subscribers"><span class="nr">'.get_subscribers($user).'</span></span>'; }
} else {
//You are, but can unsubscribe
echo '<a id="unsubscribe" class="'.$btnc.' subscriber" href="javascript:Subscribe('.$user.', 3)"><i class="icon-bell"></i>'._lang('Unsubscribe').'</a>';
 if ($counter) { echo '<span class="count-subscribers"><span class="nr">'.get_subscribers($user).'</span></span>'; }
}
} else {
//It's you
echo '<a href="'.profile_url(user_id(), user_name()).'&sk=subscribers" class="'.$btnc.'"><i class="icon-bell"></i>'._lang('It\'s you').'</a>';
if ($counter) { echo ' <span class="count-subscribers"><span class="nr">'.get_subscribers($user).'</span></span>';}
}
}
function get_subscribers($user) {
global $db;
$sub = $db->get_row("Select count(*) as nr from ".DB_PREFIX."users where ".DB_PREFIX."users.id in ( select fid from ".DB_PREFIX."users_friends where uid ='".$user."')");
return $sub->nr;
}
function list_title($list) {
global $db;
/*for video header in list mode */
if($list) {
$playlist = $db->get_row("SELECT title FROM ".DB_PREFIX."playlists where id = '".intval($list) ."' limit  0,1");
return strip_tags(stripslashes($playlist->title));
}
}
function canonical() {
global $canonical;
if(isset($canonical) && !empty($canonical)) {
return $canonical;
}
/*else try to build an url for menu's back step not to fail */
return selfURL();
}

function selfURL() { 
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : ""; 
    $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s; 
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]); 
    return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI']; 
} 
function strleft($s1, $s2) { return substr($s1, 0, strpos($s1, $s2)); }
/*Track  activity */
function add_activity($type, $obj, $extra ='') {
global $db;
if (is_user()&& $type && $obj)
{
$db->query("INSERT INTO ".DB_PREFIX."activity (`user`, `type`, `object`, `extra`) VALUES ('".user_id()."', '".toDb($type)."', '".toDb($obj)."', '".toDb($extra)."')");
}
}
function has_activity($type, $obj, $extra =''){
global $db;
$check = $db->get_row("SELECT count(*) as nr from ".DB_PREFIX."activity where user ='".user_id()."' and type = '".toDb($type)."' and object = '".toDb($obj)."' and extra = '".toDb($extra)."'" );
return ($check->nr > 0);
}
function remove_activity($type, $obj, $extra =''){
global $db;
$db->query("delete from ".DB_PREFIX."activity where user ='".user_id()."' and type = '".toDb($type)."' and object = '".toDb($obj)."' and extra = '".toDb($extra)."'" );
}
function default_content(){
/* Dummy function for default template
manipulated by filters */
$def = '';
return apply_filters('the_defaults' , $def);
}
function get_activity($done) {
global $db;
if($done){
$did = array();
switch($done->type){
case 1:
$tran["like"] = _lang('liked a video');
$tran["dislike"] = _lang('Disliked a video');
$class["like"] = "greenText";
$class["dislike"] = "redText";
$did["what"] = $tran[$done->extra];
$video = $db->get_row("SELECT title,id,description from ".DB_PREFIX."videos where id='".intval($done->object)."'");
if($video) {
$did["content"] = '<a href="'.video_url($video->id , $video->title).'" title="'.stripslashes($video->title).'"><i class="icon-film"></i> <strong>'.stripslashes(_cut($video->title, 46)).'</strong></a> <br /> '.stripslashes(_cut($video->description, 246));
$did["class"] = $class[$done->extra];
}
break;
case 2:
$did["what"] = _lang("collected a video");
$video = $db->get_row("SELECT title,id from ".DB_PREFIX."videos where id='".intval($done->object)."'");
$playlist = $db->get_row("SELECT title,id from ".DB_PREFIX."playlists where id='".intval($done->extra)."'");
if($video && $playlist) {
$did["content"] = '<a href="'.video_url($video->id , $video->title).'" title="'.stripslashes($video->title).'"><i class="icon-film"></i> <strong>'.stripslashes(_cut($video->title, 66)).'</strong></a> <br />';
$did["content"] .= _lang("in playlist ").' <a href="'.playlist_url($playlist ->id , $playlist ->title).'" title="'.stripslashes($playlist ->title).'"><i class="icon-list-alt"></i> <strong>'.stripslashes(_cut($playlist ->title, 146)).'</strong></a>';
$did["class"] = "greenSeaText";
}
break;
case 3:
$did["what"] = _lang("watched a video");
$video = $db->get_row("SELECT title,id,description from ".DB_PREFIX."videos where id='".intval($done->object)."'");
if($video) {
$did["content"] = '<a href="'.video_url($video->id , $video->title).'" title="'.stripslashes($video->title).'"><i class="icon-film"></i> <strong>'.stripslashes(_cut($video->title, 46)).'</strong></a> <br /> '.stripslashes(_cut($video->description, 246));
$did["class"] = "midnightBlueText";
} else {
$did["content"] ="";
$did["class"] = "";
}
break;
case 4:
$did["what"] = _lang("shared a video");
$video = $db->get_row("SELECT title,id,description from ".DB_PREFIX."videos where id='".intval($done->object)."'");
if($video) {
$did["content"] = '<a href="'.video_url($video->id , $video->title).'" title="'.stripslashes($video->title).'"><i class="icon-upload-alt"></i> <strong>'.stripslashes(_cut($video->title, 46)).'</strong></a> <br /> '.stripslashes(_cut($video->description, 246));
$did["class"] = "redText";
}
break;
case 5:
$did["what"] = _lang("subscribed to ");
$video = $db->get_row("SELECT name,id from ".DB_PREFIX."users where id='".intval($done->object)."'");
if($video) {
$did["content"] = '<a href="'.profile_url($video->id , $video->name).'" title="'.stripslashes($video->name).'"><i class="icon-ok-sign"></i> <strong>'.stripslashes(_cut($video->name, 46)).'</strong></a>';
$did["class"] = "sunFlowerText";
}
break;
case 6:
$did["what"] = _lang("commented");
$video = $db->get_row("SELECT title,id from ".DB_PREFIX."videos where id='".intval($done->object)."'");
if($video) {
$cd = "video_".intval($done->object);
$com = $db->get_row("SELECT comment_text from ".DB_PREFIX."em_comments where object_id='".$cd."'");
$did["content"] = '<span class="coms">'.$com->comment_text.'</span><br />'._lang("on video").' <a href="'.video_url($video->id , $video->title).'" title="'.stripslashes($video->title).'"><i class="icon-film"></i> <strong>'.stripslashes(_cut($video->title, 46)).'</strong></a>';
$did["class"] = "carrotText";
}
break;
case 7:
$did["what"] = _lang("liked a comment");
$com = $db->get_row("SELECT comment_text,object_id from ".DB_PREFIX."em_comments where id='".intval($done->object)."'");
$vid = intval(str_replace('video_','',$com->object_id));
$video = $db->get_row("SELECT title,id from ".DB_PREFIX."videos where id='".$vid."'");
if($video) {
$did["content"] = '<span class="coms">'.$com->comment_text.'</span><br />'._lang("on video").' <a href="'.video_url($video->id , $video->title).'" title="'.stripslashes($video->title).'"><i class="icon-film"></i> <strong>'.stripslashes(_cut($video->title, 46)).'</strong></a>';
$did["class"] = "emerlandText";
}
break;
}
if(!isset($did["content"])) {$did["content"] = "";}
if(!isset($did["class"])) {$did["class"] = "";}
return $did;
}

}
//Video processing
function unpublish_video($id){
global $db;
$id = intval($id);
if($id){
if (is_moderator()){
//can edit any video
$db->query("UPDATE ".DB_PREFIX."videos SET pub = '0' where id='".$id."'");
} else {
//make sure it's his video
$db->query("UPDATE ".DB_PREFIX."videos SET pub = '0' where id='".$id."' and user_id ='".user_id()."'");
}

}
}
function publish_video($id){
global $db;
$id = intval($id);
if($id){
if (is_moderator()){
//can edit any video
$db->query("UPDATE ".DB_PREFIX."videos SET pub = '1' where id='".$id."'");
} else {
//make sure it's his video
$db->query("UPDATE ".DB_PREFIX."videos SET pub = '1' where id='".$id."' and user_id ='".user_id()."'");
}

}
}
function delete_video($id) {
global $db;
if(intval($id) && is_moderator()){
$video = $db->get_row("SELECT * from ".DB_PREFIX."videos where id='".intval($id)."'");
if($video) {
if($video->embed || $video->remote) {
//delete imediatly if remote
$db->query("DELETE from ".DB_PREFIX."videos where id='".intval($id)."'");
} else {
//try to delete file to
 $vid = new Vibe_Providers(10, 10);
 $source = $vid->VideoProvider($video->source);
 if(($source == "localimage") || ($source == "localfile") ) {
 $path = ABSPATH.'/'.get_option('mediafolder').str_replace(array("localimage", "localfile"),array("", ""),$video->source);
 //remove video file
 remove_file($path);
 $thumb = $video->thumb;
if($thumb && ($thumb != "uploads/noimage.png")) {
$vurl = parse_url(trim($thumb, '/')); 
if(!isset($vurl['scheme']) || $vurl['scheme'] !== 'http'){ 
$thumb = ABSPATH.'/'.$thumb;
//remove thumb
 remove_file($thumb);
 }

}
 } 
$db->query("DELETE from ".DB_PREFIX."videos where id='".intval($id)."'"); 
echo '<div class="msg-info">'.$video->title.' was removed.</div>';
}
}
}
}
function remove_file($filename) {
if(is_moderator() && is_readable($filename)) {
chmod($filename, 0777);
if (unlink($filename)){
echo '<div class="msg-info">'.$filename.' removed.</div>';
} else {
echo '<div class="msg-warning">'.$filename.' was not removed. Check server permisions for "unlink" function.</div>';
}
;
}
}
function unlike_video($id, $u = null){
global $db;
$id = intval($id);
if($id){
if (is_moderator()){
if(is_null($u)) {
$u = user_id();
}
$db->query("delete from ".DB_PREFIX."likes where uid ='".$u."' and vid='".$id."'");
} else {
//delete like
$db->query("delete from ".DB_PREFIX."likes where uid ='".user_id()."' and vid='".$id."'");
}
//Set video to -1
$db->query("update ".DB_PREFIX."videos set liked=liked-1 where id='".$id."'");

}
}
function delete_playlist($id){
global $db;
$id = intval($id);
if($id){
if (is_moderator()){
//delete playlist
$db->query("DELETE FROM ".DB_PREFIX."playlists where id='".$id."'");
//delete data
$db->query("DELETE FROM ".DB_PREFIX."playlist_data where playlist='".$id."'");
} else {
//make sure it's his playlist
$db->query("DELETE FROM ".DB_PREFIX."playlists where id='".$id."' and owner ='".user_id()."'");
if($db->rows_affected > 0) {
//delete data only on success
$db->query("DELETE FROM ".DB_PREFIX."playlist_data where playlist='".$id."'");
}
}
}
}
// Playlist forwarding
function start_playlist(){
global $db;
$list = token();
if($list) {
$videox = $db->get_row("SELECT id ,title from ".DB_PREFIX."videos where id in(select video_id from ".DB_PREFIX."playlist_data where playlist=$list ) order by id desc");
if($videox){
return video_url($videox->id, $videox->title,$list );
}
}
return site_url();
}
//Get the media file
function get_file($input, $token){
$filename = ABSPATH.'/'.get_option('mediafolder')."/".$input;
if (file_exists($filename)) {
return is_image($input) ? 'localimage/'.$input : 'localfile/'.$input;
} else{
return get_by_token($token);
}
}
function get_by_token($token){
global $db;
$video = $db->get_row("SELECT path from ".DB_PREFIX."videos_tmp where name='".toDb($token)."'");
if($video){
return is_image($video->path) ? 'localimage/'.$video->path : 'localfile/'.$video->path;
} else{
return null;
}
}
function is_image($url) {
$pieces_array = explode('.', $url);
$ext = end($pieces_array);
$file_supported = array("jpg", "jpeg", "png", "gif");
if(in_array($ext, $file_supported)) {
return true;
}
return false;
}
//durations -> seconds
function toSeconds($str){
  $str=explode(':',$str);
  switch( count($str) )
  {
    case 2: return $str[0]*60 + $str[1];
    case 3: return $str[0]*3600 + $str[1]*60 + $str[2];
  }
return 0;
}
//validate remote
function validateRemote($url){
$pieces_array = explode('.', $url);
		$ext = end($pieces_array);
$file_supported = array("mp4", "flv", "webm", "ogv", "m3u8", "ts", "tif");
if(in_array($ext, $file_supported) || is_image($url)) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    // don't download content
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if(curl_exec($ch)!==FALSE)
    {
        return true;
    }
    else
    {
        return false;
    }
	} else {
	 return false;
	}
}
//fix cookie 
function cookiedomain() {
$parse = parse_url(site_url());
return '.'.str_replace('www.','', $parse['host']);
}
//delete playlist
function playlist_remove($play, $video) {
global $db;
if(is_array($video)) {
foreach ($video as $del) {
playlist_remove($play, $del);
}
} else {
if($video && $play) {
$db->query("DELETE FROM ".DB_PREFIX."playlist_data where playlist= '".intval($play)."' and video_id= '".intval($video)."' ");
}
}

}
//logo
function show_logo(){
if(get_option('site-logo')) {
return '<img src="'.thumb_fix(get_option('site-logo')).'"/>';
} else {
return '<span>'.get_option('site-logo-text').'</span>';
}
}
?>