<?php

abstract class MK_Authorizer
{

	protected static $user;

	public static function authorizeByEmailPass( $email, $password )
	{
		if( empty($password) || empty($password) )
		{
			throw new MK_Exception("Either username and password is blank");
		}
	
		$config = MK_Config::getInstance();

		$password = MK_Utility::getHash( $password );

		$user_module = MK_RecordModuleManager::getFromType('user');
		$search = array(
			array('literal' => "`email` = '".mysql_real_escape_string($email, $config->db->con)."' AND ( `password` = '".mysql_real_escape_string($password, $config->db->con)."' OR `temporary_password` = '".mysql_real_escape_string($password, $config->db->con)."' )"),
			array('field' => 'type', 'value' => MK_RecordUser::TYPE_CORE)
		);
		
		$results = $user_module->searchRecords( $search );

		if( count($results) === 1 && ( $user = array_pop( $results ) ) )
		{
			self::authorizeById( $user->getId() );
		}
		
		return self::authorize();

	}

	public static function authorizeByFacebookId( $facebook_id )
	{
		$user_module = MK_RecordModuleManager::getFromType('user');

		$search = array(
			array('field' => 'facebook_id', 'value' => $facebook_id),
		);

		$search_results = $user_module->searchRecords( $search );
		!$user = array_pop( $search_results ); 

		if( !empty($user) )
		{
			return self::authorizeById( $user->getId() );
		}
		else
		{
			throw new MK_Exception("User with Facebook ID $facebook_id doesn't exist");
		}
		
	}

	public static function authorizeByFacebookEmail( $facebook_email )
	{
		$user_module = MK_RecordModuleManager::getFromType('user');

		$search = array(
			array('field' => 'email', 'value' => $facebook_email),
		);

		$search_results = $user_module->searchRecords( $search );
		$user = array_pop( $search_results );

		if( !empty($user) )
		{
			return self::authorizeById( $user->getId() );
		}
		else
		{
			throw new MK_Exception("User with Email $facebook_email doesn't exist");
		}
		
	}

	public static function authorizeByTwitterId( $twitter_id )
	{
		$user_module = MK_RecordModuleManager::getFromType('user');

		$search = array(
			array('field' => 'twitter_id', 'value' => $twitter_id),
		);

		$search_results = $user_module->searchRecords( $search );
		$user = array_pop( $search_results );

		if( !empty($user) )
		{
			return self::authorizeById( $user->getId() );
		}
		else
		{
			throw new MK_Exception("User with Twitter ID $twitter_id, doesn't exist");
		}
		
	}

	public static function authorizeById( $id )
	{
		
		$config = MK_Config::getInstance();

		$user_module = MK_RecordModuleManager::getFromType('user');
		
		try
		{
			self::$user = MK_RecordManager::getFromId( $user_module->getId(), $id );
			self::$user
				->setLastip( MK_Utility::getUserIp() )
				->setLastlogin( date('Y-m-d H:i:s') )
				->setTemporaryPassword('')
				->save(false);
		}
		catch(Exception $e){}

		return self::authorize();

	}
	
	public static function authorize()
	{
		
		if( empty(self::$user) )
		{
			$user_module = MK_RecordModuleManager::getFromType('user');
			self::$user = MK_RecordManager::getNewRecord( $user_module->getId() );
		}

		return self::$user;

	}
	
}

?>