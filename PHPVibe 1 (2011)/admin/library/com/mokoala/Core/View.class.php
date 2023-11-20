<?php

class MK_View extends MK_Config_Handler{
	
	protected $display_path;
	protected $template_path = 'default';
	
	protected $displays_directory;
	protected $templates_directory;
	protected $views_directory;
	protected $template_theme;
	
	protected $display_output = '';
	protected $template_output = '';
	
	protected $render = true;

	protected $meta_title = '';

	public $core_version;
	public $core_url;
	public $core_name;

	public $instance_version;
	public $instance_url;
	public $instance_name;

	protected $head;

	// Refactor <
	protected $controller;

	public function __construct(MK_Controller &$controller)
	{
		$config = MK_Config::getInstance();

		$this->core_version = $config->core->version;
		$this->core_url = $config->core->url;
		$this->core_name = $config->core->name;

		$this->instance_version = $config->instance->version;
		$this->instance_url = $config->instance->url;
		$this->instance_name = $config->instance->name;

		$this->controller = $controller;
		$this->views_directory = 'application/views/'.$config->template.'/';
		$this->displays_directory = $this->views_directory.'displays/';
		$this->templates_directory = $this->views_directory.'templates/';

		$this->template_theme = $config->template_theme;

		$this->head = new MK_View_Head();
	}

	// > Refactor

	public function getHead()
	{
		return $this->head;
	}

	public function renderTemplate(){

		if($this->getRender()){
			
			$template_file = $this->getTemplatesDirectory().$this->getTemplatePath().'.php';
			if( is_file($template_file) ){
				ob_start();
				require_once $template_file;
				$contents = ob_get_contents();
				ob_end_clean();
				$this->setTemplateOutput( $contents );
			}else{
				throw new MK_ViewException('Expected display file \''.$template_file.'\' not found');
			}
			
		}

	}
	
	public function renderDisplay()
	{

		if($this->getRender())
		{

			$display_file = $this->getDisplayDirectory().$this->getDisplayPath().'.php';
			if( is_file($display_file) )
			{
				ob_start();
				require_once $display_file;
				$contents = ob_get_contents();
				ob_end_clean();
				$this->setDisplayOutput( $contents );
			}
			else
			{
				throw new MK_ViewException('Expected display file \''.$display_file.'\' not found');
			}
			
		}

	}

	public function getThemeDirectory(){
		return $this->views_directory.'themes/'.$this->template_theme.'/';
	}

	public function setDisplayPath($display){
		$this->display_path = $display;
	}
	
	public function setTemplatePath($template){
		$this->template_path = $template;
	}
	
	public function getTemplatePath(){
		return $this->template_path;
	}

	public function getDisplayPath(){
		return $this->display_path;
	}
	
	public function getTemplatesDirectory(){
		return $this->templates_directory;
	}

	public function getDisplayDirectory(){
		return $this->displays_directory;
	}
	
	public function getTemplateOutput(){
		return $this->template_output;
	}

	public function getDisplayOutput(){
		return $this->display_output;
	}
	
	public function setTemplateOutput( $output ){
		$this->template_output = $output;
	}

	public function setDisplayOutput( $output ){
		$this->display_output = $output;
	}

	public function getRender(){
		return $this->render;
	}
	
	public function setRender( $option ){
		$this->render = $option;
	}
	
	/*
		Layout & Display Functions
	*/
	public static function redirect($params){
		$config = MK_Config::getInstance();
		header('Location:'.$config->site->base_href.self::uri($params), true, 302);
		exit;
	}

	public function back(){
		$config = MK_Config::getInstance();
		header('Location:'.$config->site->referer, true, 302);
		exit;
	}

	public function reload(){
		header('Location:'.$this->uri(), true, 302);
		exit;
	}

	public static function uri( $params = array(), $reset = true )
	{
		$config = MK_Config::getInstance();
		
		if( !empty($params['controller']) )
		{
			$controller = $params['controller'];
			$section = !empty($params['section']) ? $params['section'] : 'index';
		}
		else
		{
			$controller = MK_Request::getParam('controller');
			$section = MK_Request::getParam('section');
		}

		unset($params['controller'], $params['section']);
		$uri = "$controller/$section";

		foreach( $params as $param => $value)
		{
			$uri .= '/'.$param.'/'.$value;
		}

		if( !$config->core->clean_uris )
		{
			$uri = '?module_path='.$uri;
		}

		return $uri;
	}

	public function getOutput(){
		return $this->display_output;	
	}
	
	public function getTitle(){
		$config = MK_Config::getInstance();
		return ( !empty($this->meta_title) ? $this->meta_title.' &laquo; ' : '' ).$this->getSiteName();	
	}
	
	public function setTitle($title){
		$this->meta_title = $title;
	}
	
	public function getSiteName(){
		$config = MK_Config::getInstance();
		return !empty($config->site->name) ? $config->site->name : $config->core->name;	
	}
	
	public function getCoreName(){
		$config = MK_Config::getInstance();
		return $config->core->name;	
	}
	
	public function getBaseHref(){
		$config = MK_Config::getInstance();
		return $config->site->base_href;
	}
	
	public function getExecutionTime($format = false){
		$config = MK_Config::getInstance();
		if($format === true){
			return number_format($config->server->execution_time, 5);
		}else{
			return $config->server->execution_time;
		}
	}

	public function getServerTime(){
		$config = MK_Config::getInstance();
		return date( $config->site->date_format, $config->server->time );
	}
	
	public function getUser(){
		return MK_Authorizer::authorize();
	}
	
	public function getTemplateDirectory(){
		$config = MK_Config::getInstance();
		return $config->template->dir;
	}
	
}

?>