<?php

abstract class MK_Utility{

	public static function getUserIp()
	{
		return !empty($_SERVER['HTTP_X_FORWARD_FOR']) ? $_SERVER['HTTP_X_FORWARD_FOR'] : $_SERVER['REMOTE_ADDR'];
	}
	
	public static function getHash( $string )
	{
		return sha1( $string );
	}

	public static function escapeText($string, $encoding = 'UTF-8')
	{
		return htmlentities(html_entity_decode($string, ENT_QUOTES, $encoding), ENT_QUOTES, $encoding);
	}
	
	public static function unescapeText($string, $encoding = 'UTF-8')
	{
		return html_entity_decode($string, ENT_QUOTES, $encoding);
	}
	
	public static function serverUrl($local_url)
	{
		$config = MK_Config::getInstance();
		return $config->site->base_href.ltrim($local_url, "/");
	}

	public static function getSlug($string)
	{
		$string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
		$string = strip_tags($string);
		$string = trim(preg_replace("#[^a-zA-Z0-9 '/-]#", "", $string));
		$string = str_replace(array(' ', '/', '\''), '-', $string);
		$string = preg_replace('#-+#', '-', $string);
		$string = strtolower($string);
		return $string;
	}

	public static function cleanString($string)
	{
		$string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
		$string = strip_tags($string);
		$string = trim(preg_replace("#[^a-zA-Z0-9 '/-]#", "", $string));
		$string = str_replace(array(' ', '/', '\''), ' ', $string);
		$string = preg_replace('#\s+#', ' ', $string);
		$string = strtolower($string);
		return $string;
	}

	public static function encodeUrl($string) {
		$entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
		$replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
		return str_replace($entities, $replacements, urlencode($string));
	}

	public static function getAttributes( $attributes ){
		$attribute_list = array();
		if(!empty($attributes) && is_array($attributes))
		{
			foreach($attributes as $attribute => $value)
			{
				$attribute_list[] = $attribute.'="'.form_data($value).'"';
			}
		}
		return count($attribute_list) > 0 ? ' '.implode(' ', $attribute_list) : '';
	}

	public static function formatBytes($bytes)
	{
		if($bytes <= 1000000)
		{
			return round($bytes / 1000, 2) . " Kb";
		}
		elseif($byteSize <= 1000000000)
		{
			return round($bytes / 1000000, 2) . " Mb";
		}
		elseif($byteSize > 1000000000)
		{
			return round($bytes / 1000000000, 2) . " Gb";
		}
	}

	public static function tidyTrim($string, $max_length, $hellip = true){
		$string = trim($string);
		$string = strip_tags($string);
		if(strlen($string) > $max_length){
			return substr($string, 0, $max_length).($hellip?'&hellip;':null);
		}else{
			return $string;	
		}
	}

	public static function stripTags($string, $allowable_tags){
		return strip_tags($string, '<'.implode('><', $allowable_tags).'>');
	}

	public static function getRandomString($length = 8, $type = 'alpha_numerical')
	{
		return self::getRandomPassword($length, $type);
	}

	public static function getRandomPassword($length = 8, $type = 'alpha_numerical')
	{

		$alpha = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
								'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
		$numerical = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
			
		if($type == 'alpha'){
			$active_characters = $alpha;
		}elseif($type == 'numerical'){
			$active_characters = $numerical;
		}else{
			$active_characters = array_merge($numerical, $alpha);
		}
		
		$total_characters = sizeof($active_characters);
		$counter = 0;
		for($c = 0; $c < $length; $c++){
			$counter++;
			$character_index = rand(0, $total_characters-1);
			$char = $active_characters[$character_index];
			(array) $password[] = $char;
		}
		
		return implode('', $password);

	}

	public static function stringToReference($string)
	{
		$string = str_replace(array('-', '_') , ' ', $string);
		$string = ucwords($string);
		$string = str_replace(' ', '', $string);
		return $string;
	}

	public static function writeConfig($config_data)
	{
		if( is_array( $config_data ) )
		{
			$config = parse_ini_file('config.ini.php');
			write_ini_file(array_merge_replace($config, $config_data), 'config.ini.php');
		}
	}
	
	public static function curlInstalled()
	{
		return function_exists('curl_version') == 'Enabled';
	}

	public static function getUniqueFileName($filename, $path)
	{
		$filename = parse_url($filename, PHP_URL_PATH);
		$file_parts = explode('/', $filename);
		$file_name = array_pop($file_parts);

		$file_name = explode('.', $file_name);
		$file_ext = array_pop($file_name);
		$file_name = implode('.', $file_name);
		
		$full_file_name = $path.$file_name.'.'.$file_ext;

		$counter = 1;
		while( is_file($full_file_name) )
		{
			$counter++;
			$full_file_name = $path.$file_name.'-'.$counter.'.'.$file_ext;
		}

		return $full_file_name;
	}

	public static function getResource($url)
	{
		$config = MK_Config::getInstance();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_REFERER, $config->site->base_href);
		curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;	
	}

	public static function SQLSplit($queries){
		$start = 0;
		$open = false;
		$open_char = '';
		$end = strlen($queries);
		$query_split = array();
		for($i=0;$i<$end;$i++) {
			$current = substr($queries,$i,1);
			if(($current == '"' || $current == '\'')) {
				$n = 2;
				while(substr($queries,$i - $n + 1, 1) == '\\' && $n < $i) {
					$n ++;
				}
				if($n%2==0) {
					if ($open) {
						if($current == $open_char) {
							$open = false;
							$open_char = '';
						}
					} else {
						$open = true;
						$open_char = $current;
					}
				}
			}
			if(($current == ';' && !$open)|| $i == $end - 1) {
				$query_split[] = substr($queries, $start, ($i - $start + 1));
				$start = $i + 1;
			}
		}

		return $query_split;
	}

	public static function getMonthList(){
		return array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
	}

	public static function getCurrencyList()
	{
		return array('EUR' => 'Euro - EUR', 'USD' => 'United States Dollars - USD', 'GBP' => 'United Kingdom Pounds - GBP', 'CAD' => 'Canada Dollars - CAD', 'AUD' => 'Australia Dollars - AUD', 'JPY' => 'Japan Yen - JPY', 'INR' => 'India Rupees - INR', 'NZD' => 'New Zealand Dollars - NZD', 'CHF' => 'Switzerland Francs - CHF', 'ZAR' => 'South Africa Rand - ZAR', 'DZD' => 'Algeria Dinars - DZD', 'USD' => 'America (United States) Dollars - USD', 'ARS' => 'Argentina Pesos - ARS', 'AUD' => 'Australia Dollars - AUD', 'BHD' => 'Bahrain Dinars - BHD', 'BRL' => 'Brazil Reais - BRL', 'BGN' => 'Bulgaria Leva - BGN', 'CAD' => 'Canada Dollars - CAD', 'CLP' => 'Chile Pesos - CLP', 'CNY' => 'China Yuan Renminbi - CNY', 'CNY' => 'RMB (China Yuan Renminbi) - CNY', 'COP' => 'Colombia Pesos - COP', 'CRC' => 'Costa Rica Colones - CRC', 'HRK' => 'Croatia Kuna - HRK', 'CZK' => 'Czech Republic Koruny - CZK', 'DKK' => 'Denmark Kroner - DKK', 'DOP' => 'Dominican Republic Pesos - DOP', 'EGP' => 'Egypt Pounds - EGP', 'EEK' => 'Estonia Krooni - EEK', 'EUR' => 'Euro - EUR', 'FJD' => 'Fiji Dollars - FJD', 'HKD' => 'Hong Kong Dollars - HKD', 'HUF' => 'Hungary Forint - HUF', 'ISK' => 'Iceland Kronur - ISK', 'INR' => 'India Rupees - INR', 'IDR' => 'Indonesia Rupiahs - IDR', 'ILS' => 'Israel New Shekels - ILS', 'JMD' => 'Jamaica Dollars - JMD', 'JPY' => 'Japan Yen - JPY', 'JOD' => 'Jordan Dinars - JOD', 'KES' => 'Kenya Shillings - KES', 'KRW' => 'Korea (South) Won - KRW', 'KWD' => 'Kuwait Dinars - KWD', 'LBP' => 'Lebanon Pounds - LBP', 'MYR' => 'Malaysia Ringgits - MYR', 'MUR' => 'Mauritius Rupees - MUR', 'MXN' => 'Mexico Pesos - MXN', 'MAD' => 'Morocco Dirhams - MAD', 'NZD' => 'New Zealand Dollars - NZD', 'NOK' => 'Norway Kroner - NOK', 'OMR' => 'Oman Rials - OMR', 'PKR' => 'Pakistan Rupees - PKR', 'PEN' => 'Peru Nuevos Soles - PEN', 'PHP' => 'Philippines Pesos - PHP', 'PLN' => 'Poland Zlotych - PLN', 'QAR' => 'Qatar Riyals - QAR', 'RON' => 'Romania New Lei - RON', 'RUB' => 'Russia Rubles - RUB', 'SAR' => 'Saudi Arabia Riyals - SAR', 'SGD' => 'Singapore Dollars - SGD', 'SKK' => 'Slovakia Koruny - SKK', 'ZAR' => 'South Africa Rand - ZAR', 'KRW' => 'South Korea Won - KRW', 'LKR' => 'Sri Lanka Rupees - LKR', 'SEK' => 'Sweden Kronor - SEK', 'CHF' => 'Switzerland Francs - CHF', 'TWD' => 'Taiwan New Dollars - TWD', 'THB' => 'Thailand Baht - THB', 'TTD' => 'Trinidad and Tobago Dollars - TTD', 'TND' => 'Tunisia Dinars - TND', 'TRY' => 'Turkey Lira - TRY', 'AED' => 'United Arab Emirates Dirhams - AED', 'GBP' => 'United Kingdom Pounds - GBP', 'USD' => 'United States Dollars - USD', 'VEB' => 'Venezuela Bolivares - VEB', 'VND' => 'Vietnam Dong - VND', 'ZMK' => 'Zambia Kwacha - ZMK');
	}

	public static function getTimezoneList(){
		return array(
			'Etc/GMT+12' => '(GMT-12:00) International Date Line West',
			'Pacific/Apia' => '(GMT-11:00) Midway Island, Samoa',
			'Pacific/Honolulu' => '(GMT-10:00) Hawaii',
			'America/Anchorage' => '(GMT-09:00) Alaska',
			'America/Los_Angeles' => '(GMT-08:00) Pacific Time (U& Canada); Tijuana',
			'America/Phoenix' => '(GMT-07:00) Arizona',
			'America/Denver' => '(GMT-07:00) Mountain Time (U& Canada)',
			'America/Chihuahua' => '(GMT-07:00) Chihuahua, La Paz, Mazatlan',
			'America/Managua' => '(GMT-06:00) Central America',
			'America/Regina' => '(GMT-06:00) Saskatchewan',
			'America/Mexico_City' => '(GMT-06:00) Guadalajara, Mexico City, Monterrey',
			'America/Chicago' => '(GMT-06:00) Central Time (U& Canada)',
			'America/Indianapolis' => '(GMT-05:00) Indiana (East)',
			'America/Bogota' => '(GMT-05:00) Bogota, Lima, Quito',
			'America/New_York' => '(GMT-05:00) Eastern Time (U& Canada)',
			'America/Caracas' => '(GMT-04:00) Caracas, La Paz',
			'America/Santiago' => '(GMT-04:00) Santiago',
			'America/Halifax' => '(GMT-04:00) Atlantic Time (Canada)',
			'America/St_Johns' => '(GMT-03:30) Newfoundland',
			'America/Buenos_Aires' => '(GMT-03:00) BuenoAires, Georgetown',
			'America/Godthab' => '(GMT-03:00) Greenland',
			'America/Sao_Paulo' => '(GMT-03:00) Brasilia',
			'America/Noronha' => '(GMT-02:00) Mid-Atlantic',
			'Atlantic/Cape_Verde' => '(GMT-01:00) Cape Verde Is.',
			'Atlantic/Azores' => '(GMT-01:00) Azores',
			'Africa/Casablanca' => '(GMT) Casablanca, Monrovia',
			'Europe/London' => '(GMT) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London',
			'Africa/Lagos' => '(GMT+01:00) West Central Africa',
			'Europe/Berlin' => '(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna',
			'Europe/Paris' => '(GMT+01:00) Brussels, Copenhagen, Madrid, Paris',
			'Europe/Sarajevo' => '(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb',
			'Europe/Belgrade' => '(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague',
			'Africa/Johannesburg' => '(GMT+02:00) Harare, Pretoria',
			'Asia/Jerusalem' => '(GMT+02:00) Jerusalem',
			'Europe/Istanbul' => '(GMT+02:00) Athens, Istanbul, Minsk',
			'Europe/Helsinki' => '(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius',
			'Africa/Cairo' => '(GMT+02:00) Cairo',
			'Europe/Bucharest' => '(GMT+02:00) Bucharest',
			'Africa/Nairobi' => '(GMT+03:00) Nairobi',
			'Asia/Riyadh' => '(GMT+03:00) Kuwait, Riyadh',
			'Europe/Moscow' => '(GMT+03:00) Moscow, St. Petersburg, Volgograd',
			'Asia/Baghdad' => '(GMT+03:00) Baghdad',
			'Asia/Tehran' => '(GMT+03:30) Tehran',
			'Asia/Muscat' => '(GMT+04:00) Abu Dhabi, Muscat',
			'Asia/Tbilisi' => '(GMT+04:00) Baku, Tbilisi, Yerevan',
			'Asia/Kabul' => '(GMT+04:30) Kabul',
			'Asia/Karachi' => '(GMT+05:00) Islamabad, Karachi, Tashkent',
			'Asia/Yekaterinburg' => '(GMT+05:00) Ekaterinburg',
			'Asia/Calcutta' => '(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi',
			'Asia/Katmandu' => '(GMT+05:45) Kathmandu',
			'Asia/Colombo' => '(GMT+06:00) Sri Jayawardenepura',
			'Asia/Dhaka' => '(GMT+06:00) Astana, Dhaka',
			'Asia/Novosibirsk' => '(GMT+06:00) Almaty, Novosibirsk',
			'Asia/Rangoon' => '(GMT+06:30) Rangoon',
			'Asia/Bangkok' => '(GMT+07:00) Bangkok, Hanoi, Jakarta',
			'Asia/Krasnoyarsk' => '(GMT+07:00) Krasnoyarsk',
			'Australia/Perth' => '(GMT+08:00) Perth',
			'Asia/Taipei' => '(GMT+08:00) Taipei',
			'Asia/Singapore' => '(GMT+08:00) Kuala Lumpur, Singapore',
			'Asia/Hong_Kong' => '(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi',
			'Asia/Irkutsk' => '(GMT+08:00) Irkutsk, Ulaan Bataar',
			'Asia/Tokyo' => '(GMT+09:00) Osaka, Sapporo, Tokyo',
			'Asia/Seoul' => '(GMT+09:00) Seoul',
			'Asia/Yakutsk' => '(GMT+09:00) Yakutsk',
			'Australia/Darwin' => '(GMT+09:30) Darwin',
			'Australia/Adelaide' => '(GMT+09:30) Adelaide',
			'Pacific/Guam' => '(GMT+10:00) Guam, Port Moresby',
			'Australia/Brisbane' => '(GMT+10:00) Brisbane',
			'Asia/Vladivostok' => '(GMT+10:00) Vladivostok',
			'Australia/Hobart' => '(GMT+10:00) Hobart',
			'Australia/Sydney' => '(GMT+10:00) Canberra, Melbourne, Sydney',
			'Asia/Magadan' => '(GMT+11:00) Magadan, Solomon Is., New Caledonia',
			'Pacific/Fiji' => '(GMT+12:00) Fiji, Kamchatka, Marshall Is.',
			'Pacific/Auckland' => '(GMT+12:00) Auckland, Wellington',
			'Pacific/Tongatapu' => '(GMT+13:00) Nukuz\'alofa'
		);
	}

}

?>