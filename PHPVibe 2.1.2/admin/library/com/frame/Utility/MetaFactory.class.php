<?php

/**
 * Controls magic `get`, `set` & `is` methods.
 *
 * @author Matt Lowden <matt@mattlowden.com>
 * @version 1.2
 * @package Utility
 */
class MK_MetaFactory
{

    /**
     * Stores meta data
	 *
     * @access protected
     * @var array
     */
	protected $meta = array();

	/**
	 * Handles magic `get`, `set` & `is` methods.
	 * 
	 * @param string $method
	 * @param mixed[] $arguments
	 * @return mixed
	 */
	public function __call( $method, $arguments )
	{
		preg_match('/[a-z][^A-Z]*/', $method, $type);
		$type = array_pop($type);

		preg_match_all('/[A-Z][^A-Z]*/', $method, $call);
		$call = trim( strtolower( implode( '_', array_pop($call) ) ) );
		
		return $this->__process( $type, $call, $arguments);
	}
	
	/**
	 * Handles magic `get`, `set` & `is` processing.
	 * 
	 * @param string $method
	 * @param string $call
	 * @param mixed[] $arguments
	 * @return mixed
	 */
	public function __process( $type, $call, $arguments )
	{
		if($type === 'get')
		{
			return $this->getMetaValue( $call, reset($arguments) ? array_shift($arguments) : null );
		}
		elseif($type === 'set')
		{
			$value = array_pop($arguments);
			return $this->setMetaValue($call, $value);
		}
		elseif($type === 'is')
		{
			$value = array_pop($arguments);
			return $this->isMetaValue($call, $value);
		}
	}

	/**
	 * Returns base meta value from $meta array, if key exists. Otherwise throws error
	 * 
	 * @param string|integer $key
	 * @throws MK_ModuleException
	 * @return mixed
	 */
	public function getMetaValue( $key )
	{
		if( array_key_exists( $key, $this->meta ) )
		{
			return $this->meta[$key];
		}
		else
		{
			throw new MK_ModuleException('Field \''.$key.'\' does not exist');
		}
		
	}
	
	/**
	 * Sets base meta value in $meta array, if key exists. Otherwise throws error
	 * 
	 * @param string|integer $key
	 * @param mixed $value
	 * @throws MK_ModuleException
	 * @return MK_MetaFactory
	 */
	public function setMetaValue( $key, $value )
	{
		if( array_key_exists( $key, $this->meta ) )
		{
			$this->meta[$key] = $value;
			return $this;
		}
		else
		{
			throw new MK_ModuleException('Field \''.$key.'\' does not exist');
		}
	}
	
	/**
	 * Sets/gets base meta value casted as boolean, if key exists. Otherwise throws error
	 * 
	 * @param string|integer $key
	 * @param mixed $value
	 * @throws MK_ModuleException
	 * @return boolean|MK_MetaFactory
	 */
	public function isMetaValue( $key, $value = null )
	{
		if( array_key_exists( $key, $this->meta ) )
		{
			if( isset($value) )
			{
				$this->meta[$key] = (boolean) $value;
				return $this;
			}
			else
			{
				return (boolean) $this->meta[$key];
			}
		}
		else
		{
			throw new MK_ModuleException('Field \''.$key.'\' does not exist');
		}
		
	}
	
}

?>