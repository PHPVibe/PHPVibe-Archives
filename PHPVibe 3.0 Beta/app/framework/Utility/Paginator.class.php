<?php

class MK_Paginator
{

	protected $page = 1;
	protected $per_page = 10;
	protected $total_records = 0;

	public function setPage( $page )
	{
		$this->page = $page;
		return $this;
	}
	
	public function setPerPage( $per_page )
	{
		$this->per_page = $per_page;
		return $this;
	}
	
	public function setTotalRecords( $total_records )
	{
		$this->total_records = $total_records;
		return $this;
	}
	
	public function getPage()
	{
		return $this->page;
	}
	
	public function getTotalPages()
	{
		return ceil($this->getTotalRecords() / $this->getPerPage());
	}
	
	public function getPerPage()
	{
		return $this->per_page;
		print $this->per_page;
	}
	
	public function getTotalRecords()
	{
		return $this->total_records;
	}
	
	public function getRecordStart()
	{
		return $this->per_page * ($this->page - 1);
	}
	
	public function getFirstRecord()
	{
		return $this->getRecordStart() + 1;
	}
	
	public function getLastRecord()
	{
		return $this->getFirstRecord() + $this->getPerPage() > $this->getTotalRecords() ? $this->getTotalRecords() : $this->getFirstRecord() + $this->getPerPage();
	}
	
	public function render($link, $options = array())
	{
	
		$link = urldecode( $link );
	
		$default_options = array(
			'paging_range' => 4,
			'first_last_link' => true,
			'first_character' => '&laquo; First',
			'last_character' => 'Last &raquo;',
		);
	
		$options = array_merge_replace($default_options, $options);
	
		$page_list = array();

		if($this->getTotalPages() > 1)
		{
	
			$first_display_page = $this->getPage() - $default_options['paging_range'];
			$first_display_page = $first_display_page < 1 ? 1 : $first_display_page;

			$last_display_page = $this->getPage() + $default_options['paging_range'];
			$last_display_page = $last_display_page > $this->getTotalPages() ? $this->getTotalPages() : $last_display_page;

			for($p = $first_display_page; $p <= $last_display_page; $p++){
				$page_data = array(
					'page' => $p,
					'text' => $p,
					'link' => ''
				);
	
	
				if($options['first_last_link'] === true && $first_display_page === $p && $first_display_page > 1){
					$page_data['text'] = $default_options['first_character'];
					$page_data['page'] = 1;
				}elseif($options['first_last_link'] === true && $last_display_page === $p && $this->getTotalPages() > $p){
					$page_data['text'] = $default_options['last_character'];
					$page_data['page'] = $this->getTotalPages();
				}
	
				$page_data['link'] = str_replace('{page}', $page_data['page'], $link);
	
				$page_list[] = $page_data;
	
			}
			
	
		}
	
		$pages = '<p class="text">Page '.number_format($this->getPage()).' of '.number_format($this->getTotalPages()).'</p>';
	
		if(count($page_list) > 0)
		{
			$pages .= '<ul class="list">';
			foreach($page_list as $single_page)
			{
				$pages .= '<li class="'.($single_page['page'] == $this->getPage() ? ' selected' : false ).'"><span><a href="'.urldecode( $single_page['link'] ).'">'.$single_page['text'].'</a></span></li>';
			}
			$pages .= '</ul>';
		}
			
	
		return $pages;
	}
	
}

?>