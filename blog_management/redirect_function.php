<?php 
	function redirect($redirect_to){
		header("location:".$redirect_to);
		exit;
	}
?>