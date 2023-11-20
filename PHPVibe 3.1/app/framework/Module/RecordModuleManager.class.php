<?php

/**
 * Manages access to modules
 * 
 * @author Matt Lowden
 * @version 1.0
 *
 */

class MK_RecordModuleManager{

	protected static $modules = array();
	protected static $module_slugs = array();
	protected static $module_types = array();

	/**
	 * Finds module based on given slug
	 *
	 * @param string $slug
	 * @throws MK_ModuleException
	 * @return MK_Module
	 */
	public static function getFromSlug($slug){
		$config = MK_Config::getInstance();

		if( !empty( self::$module_slugs[$slug] ) ){
			return self::$modules[ self::$module_slugs[$slug] ];
		}else{

			$get_module = mysql_query("SELECT `id`, `slug` FROM `modules` WHERE `slug` = '".mysql_real_escape_string($slug, $config->db->con)."'", $config->db->con);
			if( mysql_num_rows( $get_module ) > 0 ){
				$res_module = mysql_fetch_assoc( $get_module );
				mysql_free_result($get_module);
				self::$module_slugs[ $res_module['slug'] ] = $res_module['id'];
				self::$modules[ $res_module['id'] ] = new MK_RecordModule( $res_module['id'] );
				return self::$modules[ $res_module['id'] ];
			}else{
				throw new MK_ModuleException('Module could not be found using slug; '.$slug);
			}
			
		}
		
	}
	
	/**
	 * Finds module based on given type
	 *
	 * @param string $type
	 * @throws MK_ModuleException
	 * @return MK_Module
	 */
	public static function getFromType($type){
		$config = MK_Config::getInstance();

		if( !empty( self::$module_types[$type] ) ){
			return self::$modules[ self::$module_types[$type] ];
		}else{

			$get_module = mysql_query("SELECT `id`, `type` FROM `modules` WHERE `type` = '".mysql_real_escape_string($type, $config->db->con)."'", $config->db->con);
			if( mysql_num_rows( $get_module ) > 0 ){
				$res_module = mysql_fetch_assoc( $get_module );
				mysql_free_result($get_module);
				self::$module_types[ $res_module['type'] ] = $res_module['id'];
				self::$modules[ $res_module['id'] ] = new MK_RecordModule( $res_module['id'] );
				return self::$modules[ $res_module['id'] ];
			}else{
				throw new MK_ModuleException('Module could not be found using type; '.$type);
			}
			
		}
		
	}
	
	/**
	 * Finds module based on given id
	 *
	 * @param integer $slug
	 * @throws MK_ModuleException
	 * @return MK_Module
	 */
	public static function getFromId($id){
		
		$config = MK_Config::getInstance();

		if(!empty(self::$modules[$id])){
			return self::$modules[$id];
		}else{

			$get_module = mysql_query("SELECT `slug`, `id` FROM `modules` WHERE `id` = '".mysql_real_escape_string($id, $config->db->con)."'", $config->db->con);
			if( $res_module = mysql_fetch_assoc( $get_module ) ){
	
				mysql_free_result($get_module);
	
				self::$module_slugs[ $res_module['slug'] ] = $res_module['id'];
				self::$modules[ $res_module['id'] ] = new MK_RecordModule( $res_module['id'] );
				return self::$modules[ $res_module['id'] ];
	
			}else{
				throw new MK_ModuleException('Module could not be found using id; '.$id);
			}
		}
		
	}
	
}

?>