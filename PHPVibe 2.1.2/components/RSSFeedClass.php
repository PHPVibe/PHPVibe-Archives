<?php

class Feed
{
	private $items 		= array( );
	private $channels 	= array( );
	/*
	 * Two (actually, three) ways of using this constructor.
	 * Zero (0) - Just create the Feed object with no channel proprieties
	 * First (1) - Use three arguments to create the required channel proprieties (title, link, description)
	 * Second (2) - Use an array to create the proprieties wanted like this:
	 *              array( 'title' => 'xpto', 'link' => 'http://domaincom/blog/' )
	 */ 
	public function __construct( )
	{
		$count 		= func_num_args();
		$parameters = func_get_args();

		if( $count == 3 )
		{
			$this->setFeedTitle( $parameters[0] );
			$this->setFeedLink( $parameters[1] );
			$this->setFeedDesc( $parameters[2] );
		}
		else if ( $count == 1 AND is_array( $parameters[0] ) )
			foreach( $parameters[0] as $key => $value )
				if( $key == 'title' )
					$this->setFeedTitle( $value );
				else if( $key == 'link' )
					$this->setFeedLink( $value );
				else if( $key == 'description' )
					$this->setFeedDesc( $value );
				else if( $key == 'generator' )
					$this->setFeedGenerator( $value );
				else if( $key == 'language' )
					$this->setFeedLang( $value );
				else if( $key == 'image' )
					$this->setFeedImage( $value[0], $value[1], $value[2] );
				else
					$this->setChannelElm( $key, $value );
	}

	/*
	 * Function responsible of treating the channel elements
	 * Responsible of making the conversion of arrays to tags
	 */
	private function meta_array( $array )
	{
		$output = '';
	
		foreach( $array as $key => $value )
			if( is_array( $value ) )
				$output .=  PHP_EOL . "<$key>" . $this->meta_array( $value ) . "</$key>" . PHP_EOL;
			else 
				$output .= PHP_EOL . "<$key>$value</$key>" . PHP_EOL;	

		return $output;
	}

	/*
	 * Sets any channel element
	 */	
	public function setChannelElm( $tagName, $content )
	{
		$this->channels[ $tagName ] = $content ;
	}

	/*
	 * Sets channel title
	 */
	public function setFeedTitle( $title )
	{
		$this->setChannelElm( 'title', $title );
	}

	/*
	 * Sets channel link
	 */
	public function setFeedLink( $link )
	{
		$this->setChannelElm( 'link', $link );
	}

	/*
	 * Sets channel description
	 */
	public function setFeedDesc( $desc )
	{
		$this->setChannelElm( 'description', $desc);
	}

	/*
	 * Sets channel language
	 */
	public function setFeedLang( $lang='en_en' )
	{
		$this->setChannelElm( 'language', $lang );
	}

	/*
	 * Sets channel image
	 */
	public function setFeedImage( $title, $imag, $link, $width = '', $height = '' )
	{
		$this->setChannelElm('image', array(
									'title' => $title,
									'link'=> $link,
									'url' => $imag,
									'width' => $width,
									'height' => $height
									) );
	}

	/*
	 * Sets channel Feed Generator Script
	 */
	private function setFeedGenerator( $desc = '' )
	{
		$this->setChannelElm('generator', $desc );
	}
	
	private function genHead( )
	{
		echo '<?xml version="1.0" encoding="utf-8"?>' . PHP_EOL . '<rss version="2.0">' . PHP_EOL;
	}

	/*
	 * Generate and print the channel's elements
	 */
	private function genChannel( )
	{
		echo '<channel>' . PHP_EOL;
		echo $this->meta_array( $this->channels );
	}

	/*
	 * Add each Item object to an array to be treated after
	 */
	public function addItem( $item )
	{
		if( is_array( $item ) ) 
			foreach( $item as $itm )
				$this->addItem( $itm );

		array_push( $this->items, $item );		
	}

	private function genBody( )
	{
		foreach( $this->items as $item )
			$item->parseItem( );
	}

	private function genBottom( )
	{
		echo '</channel>' . PHP_EOL . '</rss>';
	}
	
	/*
	 * Generates the Feed
	 */
	public function genFeed( )
	{
		

		$this->genHead( );
		$this->genChannel( );
		$this->genBody( );
		$this->genBottom( );
	}
}

class Item
{
	private $elements = array( );

	/*
	 * Two (actually, three) ways of using this constructor.
	 * Zero (0) - Just create the Item object with no proprieties
	 * First (1) - Use three arguments to create the required item proprieties (title, link, description)
	 * Second (2) - Use an array to create the proprieties wanted like this:
	 *              array( 'title' => 'xpto', 'link' => 'http://joaopedropereira.com/blog/' )
	 */ 
	public function __construct( ) {
		$count 		= func_num_args();
		$parameters = func_get_args();

		if( $count == 3 ) {
			$this->setItemTitle( $parameters[0] );
			$this->setItemLink( $parameters[1] );
			$this->setItemDesc( $parameters[2] );
		}
		else if ( $count == 1 AND is_array( $parameters[0] ) )
			foreach( $parameters[0] as $key => $value )
				if( $key == 'title' )
					$this->setItemTitle( $value );
				else if( $key == 'link' )
					$this->setItemLink( $value );
				else if( $key == 'desc' )
					$this->setItemDesc( $value );
				else if( $key == 'date' )
					$this->setItemDate( $value );
				else if( $key == 'author' )
					$this->setItemAuthor( $value );
				else if( $key == 'category' )
					if( is_array( $value ) )
						$this->setItemCat( $value[0], $value[1] );
					else
						$this->setItemCat( $value );
				else if( $key == 'comments' )
					$this->setItemComm( $value );
				else if( $key == 'source' )
					$this->setItemSource( $value );
				else if( $key == 'enclosure' )
					$this->setItemEnclosure( $value[0], $value[1], $value[2] );
				else
					if( is_array( $value ) )
						$this->setItemElm( $key, $value[0], $value[1] );
					else
						$this->setItemElm( $key, $value );
	}

	/*
	 * Sets any item element
	 */
	public function setItemElm( $tagName, $content, $attributes = '' )
	{
		$this->elements[ $tagName ] = array ( $tagName, $content , $attributes );
	}

	/*
	 * Sets item title
	 */
	public function setItemTitle( $title )
	{
		$this->setItemElm( 'title', $title );
	}

	/*
	 * Sets item link
	 */
	public function setItemLink( $link )
	{
		$this->setItemElm( 'link', $link );
	}

	/*
	 * Sets item description
	 */
	public function setItemDesc( $desc )
	{
		$this->setItemElm( 'description', $desc );
	}

	/*
	 * Sets item author
	 */
	public function setItemAuthor( $author )
	{
		$this->setItemElm( 'author', $author );
	}

	/*
	 * Sets item category
	 */
	public function setItemCat( $cat, $link = '' )
	{
		if( !empty( $link ) ) $link = ' ' . $link;
		$this->setItemElm( 'category', $cat, $link );
	}

	/*
	 * Sets item comments page
	 */
	public function setItemComm( $comm )
	{
		$this->setItemElm( 'comments', $comm );
	}

	/*
	 * Sets item publication date
	 */
	public function setItemDate( $date )
	{
		$this->setItemElm( 'pubDate', $date );
	}

	/*
	 * Sets item source
	 */
	public function setItemSource( $source )
	{
		$this->setItemElm( 'source', $source );
	}

	/*
	 * Sets item enclosure
	 */
	public function setItemEnclosure( $link, $lenght='auto', $type )
	{
		$attributes = ' url="' . $link . '" lenght="' . $lenght . '" type="' . $type . '"';
		$this->setItemElm( 'enclosure', '', $attributes );
	}

	/*
	 * Parses the Item elements defined by the user and prints it on the output
	 */
	public function parseItem( )
	{
		echo '<item>' . PHP_EOL;

		foreach( $this->elements as $elm )
			echo '<' . $elm[0] . $elm[2] . '>' . $elm[1] . '</' . $elm[0] . '>' . PHP_EOL;
		
		echo '</item>' . PHP_EOL;
	}
}
   
?>
