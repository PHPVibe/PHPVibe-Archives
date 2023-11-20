<?php

class MK_FileManager
{

	public static function uploadFileFromUrl( $url, $path )
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
		curl_exec($ch);
		$url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
		curl_close($ch);

		$image_data = MK_Utility::getResource($url);
		$local_path = '';

		if( $image_data )
		{
			$local_path = MK_Utility::getUniqueFileName( $url, $path );
			file_put_contents($local_path, $image_data);
		}

		return $local_path;
	}

}

?>