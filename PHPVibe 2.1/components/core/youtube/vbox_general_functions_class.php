<?php

class Vbox_general_functions_class {
	
	// Receive a duration in seconds, returns a formated string
	function formatDuration($duration) {
	  	$format = "%02d%s%02d";
		$minutes = floor($duration/60);
		$secondes = ($duration-(floor($duration/60)*60));
		return sprintf($format, $minutes, ':', $secondes);
	}

	// Cut a long word in a text string
	function cutLongWords($sentence,$nb=20) {
		$wordsTab = split(" +",trim($sentence));
		$sentence = "";
		foreach($wordsTab as $value) {
		$sentence .= $this->cutText($value,$nb)." ";
		}
		return $sentence;
	}
	
	// Cut a text that has a certain length
	function cutText($str,$nb=10) {
	    if (strlen($str) > $nb) {
	        $str = substr($str, 0, $nb);
	        $str = $str."... ";
	    }
	    return $str;
	}
	
	
	// ####################################
	// ########### START Security functions
	
	function filterFormValue($value) {
		$value = strip_tags(addslashes($value));
		return $value;
	}
	
	// ###################################
	// ########### END Security functions
	
	function removeSpaces($text) {
		$text = trim($text);
		$text = preg_replace("/ -+/","-",$text);
		$text = preg_replace("/- +/","-",$text);
		$text = preg_replace("/ +/","-",$text); // remplace les espaces par -
		return $text;
	}
	
	function cleanURLString($string) {
	    $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ';
	    $b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby';
	    $string = strtr($string, $a, $b);
	    $string = strtolower($string);
	    $string = eregi_replace("[^a-z0-9]",' ',$string);
	    $string = $this->removeSpaces($string);
	    return $string;
	}

}

?>
