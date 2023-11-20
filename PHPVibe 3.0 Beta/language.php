<?php

	/*
		PHP Language Class
	*/

	class Language {
		
        /*
			Automatically detects browser default language and use that as default site language if the language file exists,
			if the language file does not exist the browser will use the default language configured on setup file
		*/
		 
		public function browserLanguage() 
		{
			global $DEFAULT_LANGUAGE;
			if ($_SERVER['HTTP_ACCEPT_LANGUAGE']) 
			{
				$this->languages = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
				$this->language = substr($this->languages,0,2);
				return $this->language;
			}
			else if ($_SERVER['HTTP_USER_AGENT']) 
			{
                $this->user_agent = explode(";" , $_SERVER['HTTP_USER_AGENT']);

				for ($i=0; $i < sizeof($this->user_agent); $i++) 
				{
					$this->languages = explode("-",$this->user_agent[$i]);
					if (sizeof($this->languages) == 2) {
						if (strlen(trim($this->languages[0])) == 2) 
						{
							$size = sizeof($this->language);
							$this->language[$size]=trim($this->languages[0]);
						}
					}
				}
				return $this->language[0];
			}
			else {
				$this->language = $DEFAULT_LANGUAGE;
				return $this->language;
			}
		}
		
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
				$session->LANGUAGE = $this->browserLanguage();
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