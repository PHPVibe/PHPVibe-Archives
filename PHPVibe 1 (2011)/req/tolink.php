<?php
function toLink($text){
	$cuvinte=explode(' ',$text);
	$new_text='';
	foreach ($cuvinte as $item){
		$item=trim($item);
		$http = stristr($item, 'http://');
		$www = stristr($item, 'www.');
		if ($http==true) {
		$aitem = str_replace("http://", "", $item);
		$aitem = str_replace("www.", "", $aitem);
			$item='<a href="'.$item.'" target="_blank">'.substr($aitem,0,50).'</a>';
		}
		elseif ($www==true){
		$aitem = str_replace("http://", "", $item);
		$aitem = str_replace("www.", "", $aitem);
			$item='<a href="http://'.$item.'" target="_blank">'.substr($aitem,0,50).'</a>';
		}
		$new_text.=' '.$item.' ';
	}
	return $new_text;
}
?>