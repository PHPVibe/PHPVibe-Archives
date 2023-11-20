<?php

	/**
	 * SEOUrl
	 *
	 *
	 */
	class SEOUrl {
		
		/**
		 *@var int The maximum length allowed for the description element.
		 */
		const DESC_MAX_LENGTH = 64;

		/**
		 *@var string The regular expression used to strip unsafe characters.
		 */
		const STRIP_PATTERN = "/[^\d\w\s!\-\.\,()\[\]]/";

		
		public static function make($id, $desc) {
			$url = '';
			$desc = str_replace(' ', '-', $desc);
			$desc = preg_replace(self::STRIP_PATTERN, '', $desc);

			if(strlen($desc) > self::DESC_MAX_LENGTH)
				$desc = substr($desc, 0, self::DESC_MAX_LENGTH);
			
			return htmlspecialchars($id . '-' . trim($desc));
		}

		/**
		 * Takes a URL created by this class, and returns the
		 * identifier element from it.
		 *
		 *@access public
		 *@param string $url The url string from which to extract the identifier.
		 *@return string|false The identifier element from the given URL, or false if not a valid URL.
		 */
		public static function get($url) {
			// Check for any URL that can be resolved as false:
			if(!$url)
				return false;

			$find = strpos($url, '-');
			// The description section can be omitted, aswell:
			if($find === false)
				return rawurldecode($url);

			$id = substr($url, 0, $find);
			if($id)
				return rawurldecode($id);

			return false;
		}
	}