<?php  function seo_clean_url($string) {
	$specialchars = array(
	"À"=>"A",
	"Á"=>"A",
	"Â"=>"A",
	"Ã"=>"A",
	"Ä"=>"AE",
	"Å"=>"A",
	"Ā"=>"A",
	"Ă"=>"A",
	"Ą"=>"A",
	"Ǟ"=>"A",
	"Ǡ"=>"A",
	"Ǻ"=>"A",
	"Ȁ"=>"A",
	"Ȃ"=>"A",
	"Ȧ"=>"A",
	"Ḁ"=>"A",
	"Ả"=>"A",
	"Ấ"=>"A",
	"Ầ"=>"A",
	"Ẩ"=>"A",
	"Ẫ"=>"A",
	"Ậ"=>"A",
	"Ắ"=>"A",
	"Ằ"=>"A",
	"Ẳ"=>"A",
	"Ẵ"=>"A",
	"Ặ"=>"A",
	"Å"=>"A",
	"Æ"=>"AE",
	"Ǽ"=>"AE",
	"Ǣ"=>"AE",
	"Ḃ"=>"B",
	"Ɓ"=>"B",
	"Ḅ"=>"B",
	"Ḇ"=>"B",
	"Ƃ"=>"B",
	"Ƅ"=>"B",
	"Ć"=>"C",
	"Ĉ"=>"C",
	"Ċ"=>"C",
	"Č"=>"C",
	"Ƈ"=>"C",
	"Ç"=>"C",
	"Ḉ"=>"C",
	"Ḋ"=>"D",
	"Ɗ"=>"D",
	"Ḍ"=>"D",
	"Ḏ"=>"D",
	"Ḑ"=>"D",
	"Ḓ"=>"D",
	"Ď"=>"D",
	"Đ"=>"D",
	"Ɖ"=>"D",
	"È"=>"E",
	"É"=>"E",
	"Ê"=>"E",
	"Ẽ"=>"E",
	"Ē"=>"E",
	"Ĕ"=>"E",
	"Ė"=>"E",
	"Ë"=>"E",
	"Ẻ"=>"E",
	"Ě"=>"E",
	"Ȅ"=>"E",
	"Ȇ"=>"E",
	"Ẹ"=>"E",
	"Ȩ"=>"E",
	"Ę"=>"E",
	"Ḙ"=>"E",
	"Ḛ"=>"E",
	"Ề"=>"E",
	"Ế"=>"E",
	"Ễ"=>"E",
	"Ể"=>"E",
	"Ḕ"=>"E",
	"Ḗ"=>"E",
	"Ệ"=>"E",
	"Ḝ"=>"E",
	"Ǝ"=>"E",
	"Ɛ"=>"E",
	"Ḟ"=>"F",	
	"Ƒ"=>"F",
	"Ǵ"=>"G",
	"Ĝ"=>"G",
	"Ḡ"=>"G",
	"Ğ"=>"G",
	"Ġ"=>"G",
	"Ǧ"=>"G",
	"Ɠ"=>"G",
	"Ģ"=>"G",
	"Ǥ"=>"G",
	"Ĥ"=>"H",
	"Ḣ"=>"H",
	"Ḧ"=>"H",
	"Ȟ"=>"H",
	"Ƕ"=>"H",
	"Ḥ"=>"H",
	"Ḩ"=>"H",
	"Ḫ"=>"H",
	"Ħ"=>"H",	
	"Ì"=>"I",
	"Í"=>"I",
	"Î"=>"I",
	"Ĩ"=>"I",
	"Ī"=>"I",
	"Ĭ"=>"I",
	"İ"=>"I",
	"Ï"=>"I",
	"Ỉ"=>"I",
	"Ǐ"=>"I",
	"Ị"=>"I",
	"Į"=>"I",
	"Ȋ"=>"I",
	"Ḭ"=>"I",
	"Ḭ"=>"I",
	"Ɨ"=>"I",
	"Ḯ"=>"I",
	"Ĳ"=>"J",
	"Ĵ"=>"J",
	"Ḱ"=>"K",
	"Ǩ"=>"K",
	"Ḵ"=>"K",
	"Ƙ"=>"K",
	"Ḳ"=>"K",
	"Ķ"=>"K",
	"Ḻ"=>"L",
	"Ḷ"=>"L",
	"Ḷ"=>"L",
	"Ļ"=>"L",
	"Ḽ"=>"L",
	"Ľ"=>"L",
	"Ŀ"=>"L",
	"Ł"=>"L",
	"Ḹ"=>"L",
	"Ḿ"=>"M",
	"Ṁ"=>"M",
	"Ṃ"=>"M",
	"Ɯ"=>"M",
	"Ǹ"=>"N",
	"Ń"=>"N",
	"Ñ"=>"N",
	"Ṅ"=>"N",
	"Ň"=>"N",
	"Ŋ"=>"N",
	"Ɲ"=>"N",
	"Ṇ"=>"N",
	"Ņ"=>"N",
	"Ṋ"=>"N",
	"Ṉ"=>"N",
	"Ƞ"=>"N",
	"Ö"=>"OE",
	"Ò"=>"O",
	"Ó"=>"O",
	"Ô"=>"O",
	"Õ"=>"O",
	"Ō"=>"O",
	"Ŏ"=>"O",
	"Ȍ"=>"O",
	"Ȏ"=>"OE",
	"Ơ"=>"O",
	"Ǫ"=>"O",
	"Ọ"=>"O",
	"Ɵ"=>"O",
	"Ø"=>"OE",
	"Ồ"=>"O",
	"Ố"=>"O",
	"Ỗ"=>"O",
	"Ổ"=>"O",
	"Ȱ"=>"O",
	"Ȫ"=>"O",
	"Ȭ"=>"O",
	"Ṍ"=>"O",
	"Ṏ"=>"O",
	"Ṑ"=>"O",
	"Ṓ"=>"O",
	"Ờ"=>"O",
	"Ớ"=>"O",
	"Ỡ"=>"O",
	"Ở"=>"O",
	"Ǭ"=>"O",
	"Ộ"=>"O",
	"Ǿ"=>"OE",
	"Ɔ"=>"O",
	"Œ"=>"OE",
	"Ṕ"=>"P",
	"Ṗ"=>"P",
	"Ƥ"=>"P",
	"Ŕ"=>"R",
	"Ṙ"=>"R",
	"Ř"=>"R",
	"Ȑ"=>"R",
	"Ȓ"=>"R",
	"Ṛ"=>"R",
	"Ŗ"=>"R",
	"Ṟ"=>"R",
	"Ṝ"=>"R",
	"Ʀ"=>"R",
	"Ś"=>"S",
	"Ŝ"=>"S",
	"Ṡ"=>"S",
	"Š"=>"S",
	"Ṣ"=>"S",
	"Ș"=>"S",
	"Ş"=>"S",
	"Ṥ"=>"S",
	"Ṧ"=>"S",
	"Ṩ"=>"S",
	"Ṫ"=>"T",
	"Ť"=>"T",
	"Ƭ"=>"T",
	"Ʈ"=>"T",
	"Ṭ"=>"T",
	"Ț"=>"T",
	"Ţ"=>"T",
	"Ṱ"=>"T",
	"Ṯ"=>"T",
	"Ŧ"=>"T",
	"Ù"=>"U",
	"Ú"=>"U",
	"Û"=>"U",
	"Ũ"=>"U",
	"Ū"=>"U",
	"Ŭ"=>"U",
	"Ü"=>"UE",
	"Ủ"=>"U",
	"Ů"=>"U",
	"Ű"=>"U",
	"Ǔ"=>"U",
	"Ȕ"=>"U",
	"Ȗ"=>"U",
	"Ư"=>"U",
	"Ụ"=>"U",
	"Ṳ"=>"U",
	"Ų"=>"U",
	"Ṷ"=>"U",
	"Ṵ"=>"U",
	"Ṹ"=>"U",
	"Ṻ"=>"U",
	"Ǜ"=>"U",
	"Ǘ"=>"U",
	"Ǖ"=>"U",
	"Ǚ"=>"U",
	"Ừ"=>"U",
	"Ứ"=>"U",
	"Ữ"=>"U",
	"Ử"=>"U",
	"Ự"=>"U",
	"Ṽ"=>"V",
	"Ṿ"=>"V",
	"Ʋ"=>"V",
	"Ẁ"=>"W",
	"Ẃ"=>"W",
	"Ŵ"=>"W",
	"Ẇ"=>"W",
	"Ẅ"=>"W",
	"Ẉ"=>"W",
	"Ẋ"=>"X",
	"Ẍ"=>"X",
	"Ỳ"=>"Y",
	"Ý"=>"Y",
	"Ŷ"=>"Y",
	"Ỹ"=>"Y",
	"Ȳ"=>"Y",
	"Ẏ"=>"Y",
	"Ÿ"=>"Y",
	"Ỷ"=>"Y",
	"Ƴ"=>"Y",
	"Ỵ"=>"Y",
	"Ź"=>"Z",
	"Ẑ"=>"Z",
	"Ż"=>"Z",
	"Ž"=>"Z",
	"Ȥ"=>"Z",
	"Ẓ"=>"Z",
	"Ẕ"=>"Z",
	"Ƶ"=>"Z",
	"à"=>"a",
	"á"=>"a",
	"â"=>"a",
	"ã"=>"a",
	"ā"=>"a",
	"ă"=>"a",
	"ȧ"=>"a",
	"ä"=>"ae",
	"ả"=>"a",
	"å"=>"a",
	"ǎ"=>"a",
	"ȁ"=>"a",
	"ȃ"=>"a",
	"ạ"=>"a",
	"ḁ"=>"a",
	"ẚ"=>"a",
	"ầ"=>"a",
	"ấ"=>"a",
	"ẫ"=>"a",
	"ẩ"=>"a",
	"ằ"=>"a",
	"ắ"=>"a",
	"ẵ"=>"a",
	"ẳ"=>"a",
	"ǡ"=>"a",
	"ǟ"=>"a",
	"ǻ"=>"a",
	"ậ"=>"a",
	"ặ"=>"a",
	"ǽ"=>"a",
	"ḃ"=>"b",
	"ɓ"=>"b",
	"ḅ"=>"b",
	"ḇ"=>"b",
	"ƀ"=>"b",
	"ƃ"=>"b",
	"ƅ"=>"b",
	"c"=>"c",
	"ć"=>"c",
	"ĉ"=>"c",
	"ċ"=>"c",
	"č"=>"c",
	"ƈ"=>"c",
	"ç"=>"c",
	"ḉ"=>"c",
	"ḍ"=>"d",
	"ḏ"=>"d",
	"ḑ"=>"d",
	"ḓ"=>"d",
	"ď"=>"d",
	"đ"=>"d",
	"ƌ"=>"d",
	"ȡ"=>"d",
	"è"=>"e",
	"é"=>"e",
	"ê"=>"e",
	"ẽ"=>"e",
	"ē"=>"e",
	"ĕ"=>"e",
	"ė"=>"e",
	"ë"=>"e",
	"ě"=>"e",
	"ȅ"=>"e",
	"ȇ"=>"e",
	"ẹ"=>"e",
	"ȩ"=>"e",
	"ę"=>"e",
	"ḙ"=>"e",
	"ề"=>"e",
	"ế"=>"e",
	"ễ"=>"e",
	"ể"=>"e",
	"ḕ"=>"e",
	"ḗ"=>"e",
	"ệ"=>"e",
	"ḝ"=>"e",
	"ǝ"=>"e",
	"ɛ"=>"e",
	"ḟ"=>"f",
	"ƒ"=>"f",
	"ǵ"=>"g",
	"ĝ"=>"g",
	"ḡ"=>"g",
	"ğ"=>"g",
	"ġ"=>"g",
	"ǧ"=>"g",
	"ɠ"=>"g",
	"ģ"=>"g",
	"ǥ"=>"g",
	"ĥ"=>"h",
	"ḣ"=>"h",
	"ḧ"=>"h",
	"ȟ"=>"h",
	"ƕ"=>"h",
	"ḥ"=>"h",
	"ḩ"=>"h",
	"ḫ"=>"h",
	"ẖ"=>"h",
	"ħ"=>"h",
	"ì"=>"i",
	"í"=>"i",
	"î"=>"i",
	"ĩ"=>"i",
	"ī"=>"i",
	"ĭ"=>"i",
	"ı"=>"i",
	"ï"=>"i",
	"ỉ"=>"i",
	"ǐ"=>"i",
	"ị"=>"i",
	"į"=>"i",
	"ȉ"=>"i",
	"ȋ"=>"i",
	"ḭ"=>"i",
	"ɨ"=>"i",
	"ḯ"=>"i",
	"ĳ"=>"i",
	"ĵ"=>"j",
	"ǰ"=>"j",
	"ḱ"=>"k",
	"ǩ"=>"k",
	"ḵ"=>"k",
	"ƙ"=>"k",
	"ḳ"=>"k",
	"ķ"=>"k",
	"ĺ"=>"l",
	"ḻ"=>"l",
	"ḷ"=>"l",
	"ļ"=>"l",
	"ḽ"=>"l",
	"ľ"=>"l",
	"ŀ"=>"l",
	"ł"=>"l",
	"ƚ"=>"l",
	"ḹ"=>"l",
	"ȴ"=>"l",
	"ḿ"=>"m",
	"ṁ"=>"m",
	"ṃ"=>"m",
	"ɯ"=>"m",
	"ǹ"=>"n",
	"ń"=>"n",
	"ñ"=>"n",
	"ṅ"=>"n",
	"ň"=>"n",
	"ŋ"=>"n",
	"ɲ"=>"n",
	"ṇ"=>"n",
	"ņ"=>"n",
	"ṋ"=>"n",
	"ṉ"=>"n",
	"ŉ"=>"n",
	"ƞ"=>"n",
	"ȵ"=>"n",
	"ò"=>"o",
	"ó"=>"o",
	"ô"=>"o",
	"õ"=>"o",
	"ō"=>"o",
	"ŏ"=>"o",
	"ȯ"=>"o",
	"ö"=>"oe",
	"ỏ"=>"o",
	"ő"=>"o",
	"ǒ"=>"o",
	"ȍ"=>"o",
	"ȏ"=>"o",
	"ơ"=>"o",
	"ǫ"=>"o",
	"ọ"=>"o",
	"ɵ"=>"o",
	"ø"=>"oe",
	"ồ"=>"o",
	"ố"=>"o",
	"ỗ"=>"o",
	"ổ"=>"o",
	"ȱ"=>"o",
	"ȫ"=>"o",
	"ȭ"=>"o",
	"ṍ"=>"o",
	"ṏ"=>"o",
	"ṑ"=>"o",
	"ṓ"=>"o",
	"ờ"=>"o",
	"ớ"=>"o",
	"ỡ"=>"o",
	"ở"=>"o",
	"ợ"=>"o",
	"ǭ"=>"o",
	"ộ"=>"o",
	"ǿ"=>"o",
	"ɔ"=>"o",
	"œ"=>"oe",
	"ṕ"=>"p",
	"ṗ"=>"p",
	"ƥ"=>"p",
	"ŕ"=>"p",
	"ṙ"=>"p",
	"ř"=>"p",
	"ȑ"=>"p",
	"ȓ"=>"p",
	"ṛ"=>"p",
	"ŗ"=>"p",
	"ṟ"=>"p",
	"ṝ"=>"p",
	"ś"=>"s",
	"ŝ"=>"s",
	"ṡ"=>"s",
	"š"=>"s",
	"ṣ"=>"s",
	"ș"=>"s",
	"ş"=>"s",
	"ṥ"=>"s",
	"ṧ"=>"s",
	"ṩ"=>"s",
	"ß"=>"ss",
	"ſ"=>"t",
	"ẛ"=>"t",
	"ṫ"=>"t",
	"ẗ"=>"t",
	"ť"=>"t",
	"ƭ"=>"t",
	"ʈ"=>"t",
	"ƫ"=>"t",
	"ṭ"=>"t",
	"ț"=>"t",
	"ţ"=>"t",
	"ṱ"=>"t",
	"ṯ"=>"t",
	"ŧ"=>"t",
	"ȶ"=>"t",
	"ù"=>"u",
	"ú"=>"u",
	"û"=>"u",
	"ũ"=>"u",
	"ū"=>"u",
	"ŭ"=>"u",
	"ü"=>"ue",
	"ủ"=>"u",
	"ů"=>"u",
	"ű"=>"u",
	"ǔ"=>"u",
	"ȕ"=>"u",
	"ȗ"=>"u",
	"ư"=>"u",
	"ụ"=>"u",
	"ṳ"=>"u",
	"ų"=>"u",
	"ṷ"=>"u",
	"ṵ"=>"u",
	"ṹ"=>"u",
	"ṻ"=>"u",
	"ǖ"=>"u",
	"ǜ"=>"u",
	"ǘ"=>"u",
	"ǖ"=>"u",
	"ǚ"=>"u",
	"ừ"=>"u",
	"ứ"=>"u",
	"ữ"=>"u",
	"ử"=>"u",
	"ự"=>"u",
	"ṽ"=>"v",
	"ṿ"=>"u",
	"ẁ"=>"w",
	"ẃ"=>"w",
	"ŵ"=>"w",
	"ẇ"=>"w",
	"ẅ"=>"w",
	"ẘ"=>"w",
	"ẉ"=>"w",
	"ẋ"=>"x",
	"ẍ"=>"x",
	"ỳ"=>"y",
	"ý"=>"y",
	"ŷ"=>"y",
	"ỹ"=>"y",
	"ȳ"=>"y",
	"ẏ"=>"y",
	"ÿ"=>"y",
	"ỷ"=>"y",
	"ẙ"=>"y",
	"ƴ"=>"y",
	"ỵ"=>"y",
	"ź"=>"z",
	"ẑ"=>"z",
	"ż"=>"z",
	"ž"=>"z",
	"ȥ"=>"z",
	"ẓ"=>"z",
	"ẕ"=>"z",
	"ƶ"=>"z",
	"Г"=>"G",
    "Д"=>"D",
    "Ж"=>"Zh",
	"Й"=>"J",
	"П"=>"P",
	"Ф"=>"F",
	"Ц"=>"C",
    "Ч"=>"Ch",
    "Ш"=>"Sh",
    "Щ"=>"Sh",
    "Э"=>"E",
    "Ю"=>"Yu",
    "Я"=>"Ya",
	"ы"=>"y",
	"/"=>"-",
	","=>"-",
	","=>"-",
	";"=>"-",	
	" "=>"-");
	$string = strtr($string,$specialchars);
	$string = preg_replace("/&([a-zA-Z])(uml|acute|grave|circ|tilde|ring),/","",$string);
	$string = preg_replace("/[^a-zA-Z0-9_.-]/","",$string);
	$string = str_replace(array('---','--'),'-', $string);
	$string = str_replace(array('..','.'),'', $string);
	if(!empty($string)){
	return strtolower($string); 
	} else {
	$alter = "video";
	return $alter;
	}
}  ?>