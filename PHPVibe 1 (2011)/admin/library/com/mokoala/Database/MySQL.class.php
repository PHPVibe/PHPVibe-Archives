<?php

class MK_MySQL
{
	
	public static function connect()
	{
		$config = MK_Config::getInstance();
		if( !empty($config->db->host) )
		{
			$db_con = mysql_connect($config->db->host, $config->db->username, $config->db->password);
			if($db_con)
			{
				if(mysql_select_db($config->db->name, $db_con))
				{
					if( function_exists('mysql_set_charset') )
					{
						mysql_set_charset($config->db->charset, $db_con);
					}
					else
					{
						mysql_query("SET NAMES '".$config->db->charset."'", $db_con);
					}
				}
			}
		}
		else
		{
			$db_con = null;
		}
		
		$config_data['db']['con'] = $db_con;
		
		MK_Config::loadConfig($config_data);
		
	}
	
	public static function disconnect()
	{
		$config = MK_Config::getInstance();
		if($config->db->con)
		{
			mysql_close($config->db->con);
		}
	}
	
}

?>