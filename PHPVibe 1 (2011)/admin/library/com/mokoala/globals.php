<?php
if( !function_exists('array_fill_keys') )
{
	function array_fill_keys($keys, $value)
	{
		$return_array = array();
		foreach($keys as $key)
		{
			$return_array[$key] = $value;
		}
		return $return_array;
	}
}

function str_replace_first($search, $replace, $data)
{
    $res = strpos($data, $search);
    if($res === false)
	{
        return $data;
    }
	else
	{
        $left_seg = substr($data, 0, strpos($data, $search));
        $right_seg = substr($data, (strpos($data, $search) + strlen($search)));
        return $left_seg . $replace . $right_seg;
    }
}  
function array_remove_null(&$array, $maintian_keys=true){
	$new_array = array();
	if(is_array($array)){
		foreach($array as $k=>$v){
			if($v&&$maintian_keys) $new_array[$k]=$v;
			elseif($v) $new_array[]=$v;
		}
	}
	$array=$new_array;
	return $array;
}

function array_key_index($key, $array){
	$counter=0;
	foreach($array as $k=>$v){
		if($k==$key){
			return $counter;
		}
		$counter++;
	}
}

function form_data($string, $encoding='UTF-8'){
	return htmlentities(html_entity_decode($string, ENT_QUOTES, $encoding), ENT_QUOTES, $encoding);
}

function slug($string){
	$string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
	$string = strip_tags($string);
	$string = trim(preg_replace("#[^a-zA-Z0-9 '/-]#", "", $string));
	$string = str_replace(array(' ', '/', '\''), '-', $string);
	$string = preg_replace('#-+#', '-', $string);
	$string = strtolower($string);
	return $string;
}

function render_content( $string ){
	$string = str_replace('<hr />', '<div class="hr-light hr-spacing"></div>', $string);
	return $string;
}

function clean_string($string){
	$string = slug($string);
	$string = str_replace('-', ' ', $string);
	return $string;
}

function file_size_format($bytes)
{
	if($bytes <= 1000000){
		return round($bytes / 1000, 2) . " Kb";
	}elseif($byteSize <= 1000000000){
		return round($bytes / 1000000, 2) . " Mb";
	}elseif($byteSize > 1000000000){
		return round($bytes / 1000000000, 2) . " Gb";
	}
}

function nice_trim($string, $max_length, $hellip=true){
	$string = trim($string);
	if(strlen($string) > $max_length){
		return substr($string, 0, $max_length).($hellip?'&hellip;':null);
	}else{
		return $string;	
	}
}

function path_clean($path){
	return preg_replace("#/+#", "/", $path);
}

function get($query_string){
	$get = array();
	foreach(explode('&', $query_string) as $get_full){
		list($key, $value)=explode('=', $get_full);
		if(preg_match('@(.+?)\[(.+?)\]@', $key, $matches)){
			$get[$matches[1]][$matches[2]]=$value;
		}else{
			$get[$key]=$value;
		}
	}
	return $get;
}

function array_merge_replace(array $base_array, array $merge_array, $depth = 0)
{
	$new_array = array();

	$key_list = array_unique( array_merge( array_keys( $base_array ), array_keys( $merge_array) ) );

	foreach($key_list as $k)
	{
		if( !array_key_exists($k, $base_array) && array_key_exists($k, $merge_array) )
		{
			$new_array[$k] = $merge_array[$k];
		}
		elseif( array_key_exists($k, $base_array) && !array_key_exists($k, $merge_array) )
		{
			$new_array[$k] = $base_array[$k];
		}
		elseif( array_key_exists($k, $base_array) && array_key_exists($k, $merge_array) )
		{
			if( ( $depth !== 1 ) && is_array($base_array[$k]) && is_array($merge_array[$k]) )
			{
				$new_array[$k] = array_merge_replace($base_array[$k], $merge_array[$k], $depth - 1 );
			}
			else
			{
				$new_array[$k] = $merge_array[$k];
			}
		}

	}
	
	return $new_array;

}

function write_ini_file($assoc_arr, $path, $has_sections = false) { 
    $content = ""; 
    if ($has_sections) { 
        foreach ($assoc_arr as $key=>$elem) { 
            $content .= "[".$key."]\n"; 
            foreach ($elem as $key2=>$elem2) { 
                if(is_array($elem2)) 
                { 
                    for($i=0;$i<count($elem2);$i++) 
                    { 
                        $content .= $key2."[] = \"".MK_Utility::escapeText($elem2[$i])."\"\n"; 
                    } 
                } 
                else if($elem2=="") $content .= $key2." = \n"; 
                else $content .= $key2." = \"".MK_Utility::escapeText($elem2)."\"\n"; 
            } 
        } 
    } 
    else { 
        foreach ($assoc_arr as $key=>$elem) { 
            if(is_array($elem)) 
            { 
                for($i=0;$i<count($elem);$i++) 
                { 
                    $content .= $key."[] = \"".MK_Utility::escapeText($elem[$i])."\"\n"; 
                } 
            } 
            else if($elem=="") $content .= $key." = \n"; 
            else $content .= $key." = \"".MK_Utility::escapeText($elem)."\"\n"; 
        } 
    } 

    if (!$handle = fopen($path, 'w')) { 
        return false; 
    } 

    if (!fwrite($handle, $content)) { 
        return false; 
    } 
    fclose($handle);
    return true; 
}


function Friendly_URL($video_id){
global $site_url;
  $new_url= $site_url.'/video/'.$video_id.'/';
    return $new_url;

}

function Get_Thumb($video_id){

 $thumb_url= 'http://i4.ytimg.com/vi/'.$video_id.'/2.jpg';

 return $thumb_url;

}

function SpecialChars($string){

  if ( is_array($string) ):

    return $string;

  else:

    return htmlspecialchars($string);

  endif;



}


function Security($string){



  $security_vulns = "DELETE |INSERT |UPDATE |RENAME |MYSQL |SQL ";

  

  $string_check = strtoupper($string);

  $do_it = explode("|", $security_vulns);

  

  static $isok = true;

  

  foreach($do_it as $vuln):

    if ( strstr($string_check, $vuln) ) { $isok = false; }

  endforeach;

  

  if ($isok) { return $string; } else { die(); }



}


/* Let's prepare an advanced functions wich can make text readable in the url for stranger characters*/

$vibe_charset = "UTF-8";
function seo_clean_url($text)
{
	global $vibe_charset;

	//	Do you know your ABCs?
	$characterHash = array (
		'a'	=>	array ('a', 'A', 'à', 'À', 'á', 'Á', 'â', 'Â', 'ã', 'Ã', 'ä', 'Ä', 'å', 'Å', 'ª', 'a', 'A', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', 'A', 'a', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?'),
		'ae'	=>	array ('æ', 'Æ'),
		'b'	=>	array ('b', 'B'),
		'c'	=>	array ('c', 'C', 'ç', 'Ç', 'c', 'C', 'c', 'C'),
		'd'	=>	array ('d', 'D', 'Ð', 'd', 'Ð', 'd', 'D'),
		'e'	=>	array ('e', 'E', 'è', 'È', 'é', 'É', 'ê', 'Ê', 'ë', 'Ë', 'e', 'E', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', 'e', '?', 'e', 'E'),
		'f'	=>	array ('f', 'F'),
		'g'	=>	array ('g', 'G', 'g', 'G'),
		'h'	=>	array ('h', 'H'),
		'i'	=>	array ('i', 'I', 'ì', 'Ì', 'í', 'Í', 'î', 'Î', 'ï', 'Ï', 'i', 'I', '?', '?', '?', '?', 'I', 'i', '?', '?'),
		'j'	=>	array ('j', 'J'),
		'k'	=>	array ('k', 'K', '?', '?', '?', '?'),
		'l'	=>	array ('l', 'L', 'l', 'L'),
		'm'	=>	array ('m', 'M', '?', '?', '?'),
		'n'	=>	array ('n', 'N', 'ñ', 'Ñ', 'n', 'N', 'n', 'N'),
		'o'	=>	array ('o', 'O', 'ò', 'Ò', 'ó', 'Ó', 'ô', 'Ô', 'õ', 'Õ', 'ö', 'Ö', 'ø', 'Ø', 'º', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', 'O', 'o', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?'),
		'p'	=>	array ('p', 'P'),
		'q'	=>	array ('q', 'Q'),
		'r'	=>	array ('r', 'R', 'r', 'R'),
		's'	=>	array ('s', 'S', 's', 'S', 's', 'S', 'š', 'Š'),
		'ss'	=>	array ('ß'),
		't'	=>	array ('t', 'T', '?', '?', 't', '?', 't', 'T', 't', 'T'),
		'u'	=>	array ('u', 'U', 'ù', 'Ù', 'ú', 'Ú', 'û', 'Û', 'ü', 'Ü', '?', '?', '?', '?', 'U', 'u', 'U', 'u', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', 'u', 'U'),
		'v'	=>	array ('v', 'V'),
		'w'	=>	array ('w', 'W'),
		'x'	=>	array ('x', 'X', '×'),
		'y'	=>	array ('y', 'Y', 'ý', 'Ý', 'ÿ', '?', '?', '?', '?', '?', '?', '?', '?'),
		'z'	=>	array ('z', 'Z', 'z', 'Z', 'z', 'Z', 'ž', 'Ž', '?'),
		'-'	=>	array ('-', ' ', '.', ','),
		'_'	=>	array ('_'),
		'!'	=>	array ('!'),
		'~'	=>	array ('~'),
		'*'	=>	array ('*'),
		"\x12"	=>	array ("'", '"'),
		'('	=>	array ('(', '{', '['),
		')'	=>	array (')', '}', ']'),
		'$'	=>	array ('$'),
		'0'	=>	array ('0'),
		'1'	=>	array ('1', '¹'),
		'2'	=>	array ('2', '²'),
		'3'	=>	array ('3', '³'),
		'4'	=>	array ('4'),
		'5'	=>	array ('5'),
		'6'	=>	array ('6'),
		'7'	=>	array ('7'),
		'8'	=>	array ('8'),
		'9'	=>	array ('9'),
	);


	//	Get or detect the database encoding, firstly from the settings or language files
	if (preg_match('~.~su', $text))
		$encoding = 'UTF-8';
	//	or sadly... we may have to assume Latin-1
	else
		$encoding = 'ISO-8859-1';

	//	If the database encoding isn't UTF-8 and multibyte string functions are available, try converting the text to UTF-8
	if ($encoding != 'UTF-8' && function_exists('mb_convert_encoding'))
		$text = mb_convert_encoding($text, 'UTF-8', $encoding);
	//	Or maybe we can convert with iconv
	else if ($encoding != 'UTF-8' && function_exists('iconv'))
		$text = iconv($encoding, 'UTF-8', $text);
	//	Fix Turkish
	else if ($encoding == 'ISO-8859-9')
	{
		$text = str_replace(array("\xD0", "\xDD", "\xDE", "\xF0", "\xFD", "\xFE"), array('g', 'i', 's', 'g', 'i', 's'), $text);
		$text = utf8_encode($text);
	}
	//	Latin-1 can be converted easily
	else if ($encoding == 'ISO-8859-1')
		$text = utf8_encode($text);

	//	Change the entities back to normal characters
	$text = str_replace(array('&amp;', '&quot;'), array('&', '"'), $text);
	$prettytext = '';

	//	Split up $text into UTF-8 letters
	preg_match_all("~.~su", $text, $characters);
	foreach ($characters[0] as $aLetter)
	{
		foreach ($characterHash as $replace => $search)
		{
			//	Found a character? Replace it!
			if (in_array($aLetter, $search))
			{
				$prettytext .= $replace;
				break;
			}
		}
	}
	//	Remove unwanted '-'s
	$prettytext = preg_replace(array('~^-+|-+$~', '~-+~'), array('', '-'), $prettytext);
	if (empty($prettytext)) { $prettytext = 'video'; }

	return $prettytext;
}

// Filtering Function

function filterBadWords($badWords,$str) {
  $badFlag = 0;
  if(!empty($badWords)) {  
  
    $badWordsArray = explode("|", $badWords);
  }
  foreach ($badWordsArray as $badWord) {
  
  //echo $badWord;
    if(!$badWord) continue; 
    else {
      $regexp = "/\b".$badWord."\b/i";
      if(preg_match($regexp,$str)) $badFlag = 1;
    }
  }
    if(preg_match("/\[url/",$str)) $badFlag = 1;
  return $badFlag;
}

function sec2hms ($sec, $padHours = false) {

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



$yt_err = '';
function grab_video($url)
{
	global $yt_err;
	
	$yt_data = array();
	$str 		= '';
	$yt_vid_id		= '';
	$yt_target = '';
	
	preg_match("/v=([^(\&|$)]*)/", $url, $matches);
	$yt_vid_id = $matches[1];
	
	$yt_target = "http://gdata.youtube.com/feeds/api/videos/" . $yt_vid_id;
	
	$error = 0;
	if(function_exists('curl_init'))
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $yt_target);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0');
		$yt_data = curl_exec($ch);
		$errormsg = curl_error($ch);
		curl_close($ch);
		
		if($errormsg != '')
		{
			echo '<div class="info_msg_err">'.$errormsg.'</div>';
			return false;
		}
	}
	else if(ini_get('allow_url_fopen') == 1)
	{
		$yt_data = @file($yt_target);
		if($yt_data === false)
			$error = 1;
	}
	if( ! is_array($yt_data))
	{
		$yt_data = explode("\n", $yt_data);
	}
	
	$str = implode("", $yt_data);
	$str = str_replace('><', ">\n<", $str);
	
	unset($yt_data);
	$yt_data = array();
	
	$yt_data = explode("\n", $str);
	
	return $yt_data;
}


// MySQL database functions
function dbquery($query)
{
	$result = @mysql_query($query);
	if (!$result) {
		echo mysql_error();
		return false;
	} else {
		return $result;
	}
}

function dbcount($field,$table,$conditions="")
{
	$cond = ($conditions ? " WHERE ".$conditions : "");
	$result = @mysql_query("SELECT Count(".$field.") FROM ".$table.$cond);
	if (!$result) {
		echo mysql_error();
		return false;
	} else {
		$rows = mysql_result($result, 0);
		return $rows;
	}
}

function dbrows($query)
{
	$result = @mysql_num_rows($query);
	return $result;
}

function dbarray($query)
{
	$result = @mysql_fetch_assoc($query);
	if (!$result) {
		echo mysql_error();
		return false;
	} else {
		return $result;
	}
}




?>