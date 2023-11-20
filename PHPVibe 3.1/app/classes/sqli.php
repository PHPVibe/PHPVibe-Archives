<?php /*** MySql Caching for videos ***/
class sqli {
	protected $dir		= '././cache/videos/';		// Storage
	protected $filename	= '';			// Current identifier for file
	protected $sql		= '';			// Current query
	protected $data		= '';			// Queried data 
		
	/**
	 * Default settings
	 * @param array  Config vars
	 */
	function __construct($config = array()) {
		// Overwrite default settings
		if (count($config) > 0) {
			foreach ($config as $key => $val) {
				$this->$key = $val;
			}
		}
	}
	/**
	 * Connection to the database
	 * 
	 * @return  bool
	 */

	/**
	 * Terminates connection 
	 * 
	 * @return  void
	 */
	public function disconnect() {
		if ($this->conn) {
			mysql_close($this->conn);
		}
	}
	/**
	 * Handle the query
	 * @return  array
	 */
	public function query($sql = '', $expire = 0, $cachename = '') {
		// Stop if empty
		if (!$sql) {
			return false;
		}
		$this->sql  = $sql;
		$this->data = '';
		// Check if an expiration length was given, if empty data needs to be refreshed
		if ($expire == '0') {
			$this->data = $this->_get_db();
			return $this->data;
		} else {
			// Check if cachename is set == 0
			if (!strlen(trim($cachename))) {
				$cachename = md5($this->sql);
			}
			$this->filename = $this->dir . $cachename;
			// Check timestamp of cachefile
			$timestamp = file_exists($this->filename) ? filemtime($this->filename) : 0;
			// Check if the cache file is set to expire once a day
			if ($expire == 'daily') {
				// If timestamp doesn't match current day refresh data
				if (date('Y-m-d', $timestamp) != date('Y-m-d', time())) {
					$this->data = $this->_get_db();
					// Save the data to the cache file
					if (!$this->_save_cache($this->data)) {
						return false;
					}
					return $this->data;
				} else { // If we get here, the cache is still good
					$this->data = $this->_get_cache();
					return $this->data;
				}
			// Check cache's lifespan against timestamp
			} else {
				// Check if cache is older than cache's lifespan
				if ((time() - $timestamp) >= $expire) {
					$this->data = $this->_get_db();
					// Save the data to the cache file
					if (!$this->_save_cache($this->data)) {
						return false;
					}
					return $this->data;
				} else { // If we get here, the cache is still good
					$this->data = $this->_get_cache();
					return $this->data;
				}
			}
		}
	}
	public function singlequery($sql = '', $expire = 0, $cachename = '') {
		// Stop if empty
		if (!$sql) {
			return false;
		}
		$this->sql  = $sql;
		$this->data = '';
		// Check if an expiration length was given, if empty data needs to be refreshed
		if ($expire == '0') {
			$this->data = $this->_get_db_row();
			return $this->data;
		} else {
			// Check if cachename is set == 0
			if (!strlen(trim($cachename))) {
				$cachename = md5($this->sql);
			}
			$this->filename = $this->dir . $cachename;
			// Check timestamp of cachefile
			$timestamp = file_exists($this->filename) ? filemtime($this->filename) : 0;
			// Check if the cache file is set to expire once a day
			if ($expire == 'daily') {
				// If timestamp doesn't match current day refresh data
				if (date('Y-m-d', $timestamp) != date('Y-m-d', time())) {
					$this->data = $this->_get_db_row();
					// Save the data to the cache file
					if (!$this->_save_cache($this->data)) {
						return false;
					}
					return $this->data;
				} else { // If we get here, the cache is still good
					$this->data = $this->_get_cache();
					return $this->data;
				}
			// Check cache's lifespan against timestamp
			} else {
				// Check if cache is older than cache's lifespan
				if ((time() - $timestamp) >= $expire) {
					$this->data = $this->_get_db_row();
					// Save the data to the cache file
					if (!$this->_save_cache($this->data)) {
						return false;
					}
					return $this->data;
				} else { // If we get here, the cache is still good
					$this->data = $this->_get_cache();
					return $this->data;
				}
			}
		}
	}
	/**
	 * Finds the number of rows affected by query
	 * 
	 * @return  interger
	 */
	public function rows_affected() {
		return mysql_affected_rows();
	}
	/**
	 * Get last inserted id
	 * 
	 * @return  interger
	 */
	public function last_id() {
		return mysql_insert_id();
	}
	/**
	 * Handles inserts, updates and deletes
	 * 
	 * @param	string SQL query
	 * @return  integer
	 */
	public function exec($sql = '') {
		// Checks to see if query was given, don't need to go on if empty
		if (!$sql) {
			return false;
		}
	
		// Perform the query
		if (!$query = mysql_query($sql)) {
			return false;
		}
		// Return number of rows affected
		return $this->rows_affected();
	}
	/**
	 * Refreshes data if the cache is expired or cache is disabled
	 * 
	 * @return  array
	 */
	protected function _get_db() {
		
		
		// Perform the query
		if (!$query = @mysql_query($this->sql)) {
			return false;
		}
		while ($row = mysql_fetch_array($query)) {
			$this->data[] = $row;
		}
		return $this->data;
	}
	
	protected function _get_db_row() {
		
		
		// Perform the query
		if (!$query = @mysql_query($this->sql)) {
			return false;
		}
		$row = @mysql_fetch_assoc($query);
			$this->data = $row;
		
		return $this->data;
	}
	/**
	 * Retrieves the query data from cache file
	 * 
	 * @return  array
	 */
	protected function _get_cache() {
		if (!$data = json_decode(file_get_contents($this->filename), true)) {
			return false;
		}
		return $data;
	}
	/**
	 * Takes the array generated from get_db() and saves it to a file in JSON form
	 * 
	 * @param	array Query data
	 * @return  bool
	 */
	protected function _save_cache($data) {
		if (!file_put_contents($this->filename, json_encode($data))) {
			return false;
		}
		return true;
	}
	/**
	 * Deletes cache file manually
	 * 
	 * @param	string Filename of cache file
	 * @param	bool   Decides if the given filename should be used as a wildcard
	 * @return  void
	 */
	public function delete_cache($filename, $wildcard = false) {
		$filename = $this->dir . $filename;
		// If wildcard is set, delete anything file with a prefix of $filename
		if ($wildcard) {
			foreach (glob($filename.'*') as $file) {
				unlink($file);
			}
		} else { // Just deletes file with filename
			if (file_exists($filename)) {
				unlink($filename);
			}
		}
	}
}
?>