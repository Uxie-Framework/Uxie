<?php
namespace classes;
use classes;

class analyse
{
	private $db;
	private $id;
	private $ip;
	private $browser;
	private $target;
	private $track;
	private $hits;
	private $date;

	function __construct()
    {
		$this->db = new classes\DBsql();
		$this->id = uniqid(uniqid());
		$this->target = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$this->track = $_SERVER['HTTP_REFERER'];
		if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$this->ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$this->ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$this->ip = $_SERVER['REMOTE_ADDR'];
		}
		$this->browser = $_SERVER['HTTP_USER_AGENT'];
		$this->date = date("y/m/d H:i:s");
		$this->analyse1();
		$this->analyse2();
	}

	private function analyse1()
    {
		$query = "insert into analyse (ip,browser,target,track,date) VALUES ('$this->ip','$this->browser','$this->target','$this->track','$this->date')";
		$this->db->query($query);
	}

	private function analyse2()
    {
		if (isset($_COOKIE["visitor"])) {
			$this->id = $_COOKIE["visitor"];
			$query = "update analyse2 set hits=hits+1 where id='$this->id'";
			$this->db->query($query);
		}else {
			$this->id = uniqid();
			setcookie("visitor", $this->id, time()+3600*24*30*12);
			$this->db->insert("analyse2", "id,ip,time,hits", "'$this->id', '$this->ip', '$this->date', 0");
		}
	}
    
}
