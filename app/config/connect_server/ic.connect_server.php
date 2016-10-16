<?php
	class InterCloud extends mysqli {
		public function __construct($host, $user, $pass, $db){
			@parent::__construct($host, $user, $pass, $db);
		}
	}

	$t = $_SERVER['DOCUMENT_ROOT']."/".explode("/", $_SERVER['REQUEST_URI'])[1]."/app/config/Config.tcb";

	if (!file_exists($t)){
		$t = $_SERVER['DOCUMENT_ROOT']."/app/config/Config.tcb";
	} 

	$error = false;

	if (file_exists($t)){
		$ArrayFileConfig = file($t);
		
		@$H = rtrim($ArrayFileConfig[0]);
		@$U = rtrim($ArrayFileConfig[1]);
		@$P = rtrim($ArrayFileConfig[2]);
		@$D = rtrim($ArrayFileConfig[3]);
		
		if (!isset($ArrayFileConfig[4]))
			$X = "";
		else
			$X = rtrim($ArrayFileConfig[4]);

		if (strlen($H) == 12){
			@$H = substr($H, 3);
		}

		@$TCB = new InterCloud($H, $U, $P, $D);
		
		if (@$TCB->connect_error){
			$error = true;
		} else {
			$error = false;
			
			if ($X != "")
				$X .= "_";
			
			if (!@$TCB->query("SET NAMES 'utf8'"))
				$error = true;
			else
				$error = false;
		}

	} else {
		$error = true;
	}
?>