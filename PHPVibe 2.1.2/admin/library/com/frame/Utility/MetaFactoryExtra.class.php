<?php

/**
 * Controls magic `get`, `set` & `is` methods. This extension
 * allows non-predefined meta values to be set
 *
 * @author Matt Lowden <matt@mattlowden.com>
 * @version 1.0
 * @package Utility
 */
class MK_MetaFactoryExtra extends MK_MetaFactory
{
    /**
     * Stores additional meta data
	 *
     * @access protected
     * @var array
     */
	protected $meta_extra = array();

	public function getMetaValue( $key )
	{
		if( array_key_exists( $key, $this->meta ) )
		{
			return $this->meta[$key];
		}
		elseif( array_key_exists( $key, $this->meta_extra ) )
		{
			return $this->meta_extra[$key];
		}
	}
	
	public function setMetaValue( $key, $value )
	{
		if( array_key_exists( $key, $this->meta ) )
		{
			$this->meta[$key] = $value;
			return $this;
		}
		else
		{
			$this->meta_extra[$key] = $value;
			return $this;
		}
		
	}
	
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
		elseif( array_key_exists( $key, $this->meta_extra ) )
		{
			if( isset($value) )
			{
				$this->meta_extra[$key] = (boolean) $value;
				return $this;
			}
			else
			{
				return (boolean) $this->meta_extra[$key];
			}
		}
		else
		{
			return false;	
		}
		
	}

}

?>