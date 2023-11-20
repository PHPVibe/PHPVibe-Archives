<?php 	class Language {
		
 
		/*
 			Check if the language exists in the file directory and return booleans true if exists if not false
		*/
		 
		public function checkLanguage($lang) 
		{
			global $LANGUAGE_DIR;
			$language = $LANGUAGE_DIR . "/" . $lang . ".lang";
			if (file_exists($language))
			{
				return true;
			} else {
				return false;
			}
		}
		
		/*
		 	Set Language
		*/
		 
		public function setLanguage($language)
		{
			global $DEFAULT_LANGUAGE;
			global $LANGUAGE_DIR;
			if ($language) 
			{
				$session->LANGUAGE = $language;
			}
			
			if (!isset($session->LANGUAGE))
			{
				$session->LANGUAGE = $DEFAULT_LANGUAGE;
			}
			
            if ($this->checkLanguage($session->LANGUAGE)) 
			{
            	$lang = $session->LANGUAGE;
            	return $lang;
            } else {
            	return $DEFAULT_LANGUAGE;
            }
		}
		
		/*
         	Get Languages
		*/
		 
		public function getLanguage($language) 
		{
			global $LANGUAGE_DIR;
            $lang = $this->setLanguage($language);
			include_once($LANGUAGE_DIR . "/" . $lang . ".lang");
			return $lang;
		}
	}
	
?>