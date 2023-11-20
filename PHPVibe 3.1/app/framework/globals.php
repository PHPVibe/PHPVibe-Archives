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




function SpecialChars($string){

  if ( is_array($string) ):

    return $string;

  else:

    return htmlspecialchars($string);

  endif;



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