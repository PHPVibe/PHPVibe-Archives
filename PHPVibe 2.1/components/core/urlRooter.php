<?php 

/**
 * ModRewriter class
 */
class ModRewriter
{
	
	/**
	 * Do the routing
	 * 
	 * @access 		public
	 * @param		string $path
	 * @return 		array
	 */
	public static function Route($path){

		// Check if the file exists
		if(is_array($path)){
			$routes = $path;
		}else{
			if(file_exists($path)){
				$routes = parse_ini_file($path);
			}else{
				trigger_error("Routing file " . $path . " not found.", E_USER_ERROR);
			}
		}
		
		if(!isset($_GET['route'])){
			return new ModRewriteInfo(array(), array());
		}
		
		$url = htmlspecialchars($_GET['route']);
		
		// Strip last slash
		if(substr($url, -1) == "/"){
			$url = substr($url, 0, -1);
		}
		
		$url_parts 		= explode("/", $url);
		$array_result 	= array();

		// If url is empty, return with no variables
		if(empty($url)){
			return new ModRewriteInfo(array(), array());
		}

		// Loop through routes
		$array_result = "";
		$array_index_result = "";
		foreach($routes as $key => $route){
			
			$route_parts = explode("/", $route);
			$index = 0;
			$match = TRUE;
			
			// Reset array_result
			$array_result = "";
			
			foreach($route_parts as $route_part)
			{
				if(substr($route_part,0,1) != "$"){
					if(isset($url_parts[$index])){
						if($route_parts[$index]!=$url_parts[$index]) $match = FALSE;
					}else{
						$match = FALSE;
					}
				}else{
					if(isset($url_parts[$index])){
						$array_result[substr($route_parts[$index],1)] = $url_parts[$index];
					}
				}
				if(isset($url_parts[$index])){
					$array_index_result[$index] = $url_parts[$index];
					$index++;
				}
			}

			if($match && (count($route_parts) == count($url_parts)))
			{
				$Info = new ModRewriteInfo($array_result, $array_index_result);
				return $Info;
			}
			
		}
		
		// No match found
		return FALSE;
		
	}
	
	/**
	 * Filter string to use in a URL
	 * 
	 * @access 		public
	 * @param 		string $string
	 * @return 		string
	 */
	public static function UrlFilter($string){
		
		$find = array(" ", ",", ":", "/", ";", "?", "!", "(", ")", "é", "è", "$", "&", "\"", "'", "#", "|", ".", "--");
		$replace = array("-", "-", "-", "-", "-", "", "", "-", "-", "e", "e", "", "-", "-", "-", "", "-", "", "-");
		return urlencode(strtolower(str_replace($find, $replace, $string)));
		
	}
	
	/**
	 * Get current url
	 * 
	 * @access public
	 * @return string
	 */
	public function GetCurrentUrl(){
		return 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	}
	
}

/**
 * ModRewriteInfo
 * 
 * Class that holds the information from the url
 */
class ModRewriteInfo{
	
	/**
	 * Array that holds the named parameters
	 * 
	 * @var array
	 */
	private $_named = array();
	
	/**
	 * Array that holds the numbered parameters
	 * 
	 * @var array
	 */
	private $_numbered = array();

	/**
	 * Constructor
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct($named="", $numbered=""){
		if(!empty($named)){
			$this->_named = $named;
		}
		if(!empty($numbered)){
			$this->_numbered = $numbered;
		}
	}
	
	/**
	 * Get parameter by name or number
	 * 
	 * @access public
	 * @param int|string $key
	 * @return string
	 */
	public function Get($key){
		if(is_numeric($key)){
			if(isset($this->_numbered[$key])){
				return urldecode($this->_numbered[$key]);
			}
			return false;
		}else{
			if(isset($this->_named[$key])){
				return urldecode($this->_named[$key]);
			}
			return false;
		}
	}
	
	/**
	 * Add a parameter
	 * 
	 * @access public
	 * @param string $key
	 * @param string $value
	 * @return bool
	 */
	public function Set($value, $key=""){
		if(!empty($key)){
			$this->_named[$key] = $value;
		}
		$this->_numbered[] = $value;
	}
	
}

?>