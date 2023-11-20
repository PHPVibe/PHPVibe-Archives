<?php

class MK_View_Head{

	protected $meta = array();
	protected $title = array();
	protected $title_separator = ' / ';
	protected $script = array();
	protected $link = array();
	protected $base;

	public function setMeta( $name, $content, $http_equiv = null ){
		$new_meta = array(
			'name' => $name,
			'content' => $content,
			'http_equiv' => $http_equiv
		);
		
		$this->meta[] = array_filter($new_meta);
		
		return $this;
	}
	
	public function setScript( $link ){
		$this->script[] = $link;
		return $this;
	}
	
	public function setBase( $link ){
		$this->base = $link;
		return $this;
	}
	
	public function setLink( $link ){
		$this->link[] = $link;
		return $this;
	}
	
	public function appendTitle( $title ){
		array_push($this->title, $title);
		return $this;
	}
	
	public function prependTitle( $title ){
		array_unshift($this->title, $title);
		return $this;
	}
	
	public function render(){
		
		$html = '';
		
		if($this->base)
		{
			$html.='<base href="'.$this->base.'" />';
		}
		
		foreach($this->link as $link)
		{
			$attributes = MK_Utility::getAttributes($link);
			$html.='<link'.$attributes.' />';
		}
		
		foreach($this->script as $script)
		{
			$html.='<script language="javascript" type="text/javascript" src="'.$script.'"></script>';
		}
		
		foreach($this->meta as $meta)
		{
			$attributes = MK_Utility::getAttributes($meta);
			$html.='<meta'.$attributes.' />';
		}
		
		$html.='<title>'.implode($this->title_separator, $this->title).'</title>';
		
		return $html;
		
	}
	
}

?>