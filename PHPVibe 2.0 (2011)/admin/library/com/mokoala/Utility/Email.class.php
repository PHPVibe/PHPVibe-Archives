<?php

class MK_Email{
	
	protected $sender_name;
	protected $sender_email;
	protected $replyto;
	protected $subject;
	protected $message;
	
	public function setSender($email, $name = null)
	{
		$this->sender_email = $email;
		$this->sender_name = $name;
		return $this;
	}
	
	public function setReplyTo($email)
	{
		$this->replyto = $email;
		return $this;
	}
	
	public function setSubject($subject)
	{
		$this->subject = $subject;
		return $this;
	}
	
	public function setMessage($message)
	{
		$this->message = $message;
		return $this;
	}
	
	public function getSubject()
	{
		return $this->subject;
	}
	
	public function getMessage()
	{
		return $this->message;
	}
	
	public function getHeaders()
	{
		$headers = "Content-type: text/html; charset=utf-8\n";
		$headers .= "From: ".$this->sender_name." <".$this->sender_email.">\n";
		$headers .= "X-Sender: ".$this->sender_email."\n";
		$headers .= "X-Mailer: PHP\n";
		$headers .= "X-Priority: 3\n";
		$headers .= "Return-Path: ".(!empty($this->replyto) ? $this->replyto : $this->sender_email)."\n";
		$headers .= "Reply-To: ".(!empty($this->replyto) ? $this->replyto : $this->sender_email)."\n";
		return $headers;
	}
	
	public function send($email, $name = null){
		$headers = $this->getHeaders();
		mail("$name <$email>", $this->getSubject(), $this->getMessage(), $headers);
		return $this;
	}

}

?>