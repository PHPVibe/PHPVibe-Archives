<?php

class Calendar{

	private $today;
	private $d;
	private $m;
	private $y;
	private $order;
	private $week_offset = array(
		SUN_TO_SAT => 0,
		MON_TO_SUN => 1
	);
	
	public function __construct($d=null, $m=null, $y=null, $order=SUN_TO_SAT){
		$this->d=$d;
		$this->m=$m;
		$this->y=$y;
		$this->order=$order;

		if(!$this->m) $this->m=date('m');
		if(!$this->y) $this->y=date('Y');
		$this->today = mktime(12, 12, 12, $this->m, ($this->d?$this->d:date('d')), $this->y);
	}

	public function get_date_list(){
		$first_day_of_month = mktime(12, 12, 12, $this->m, 1, $this->y);
		$first_day_of_calendar_offset = date('w', $first_day_of_month)+$this->week_offset[$order];
		$first_day_of_calendar = $first_day_of_month-($first_day_of_calendar_offset*86400);
		$last_day_of_month = mktime(12, 12, 12, $this->m, date('t', mktime()), $this->y);
		$last_day_of_calendar_offset = date('w', $last_day_of_month)-$this->week_offset[$order];
		$last_day_of_calendar = $last_day_of_month+($last_day_of_calendar_offset*86400);
		
		$current_date = $first_day_of_calendar;

		$day_array=array();
		while($current_date<=$last_day_of_calendar){
			$day_array[]=array(
				'timestamp'=>$current_date,
				'current'=>($this->d==date('d',$current_date)||(!$this->d&&$this->m==date('m',$current_date))?true:false)
			);
			$current_date=strtotime('+1 days', $current_date);
		}

		return $day_array;
	}
	
	public function get_next_day(){
		return strtotime('+1 days', $this->today);
	}
	
	public function get_prev_day(){
		return strtotime('-1 days', $this->today);
	}
	
	public function get_next_month(){
		return strtotime('+1 months', $this->today);
	}
	
	public function get_prev_month(){
		return strtotime('-1 months', $this->today);
	}
		
	public function get_next_year(){
		return strtotime('+1 years', $this->today);
	}
	
	public function get_prev_year(){
		return strtotime('-1 years', $this->today);
	}

}

?>