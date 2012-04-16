<?php
	$this->layout = false;
	
	$login_info		= $sdp->subscribeScript(true);
	$token_info		= array(
		'access_token'	=> $sdp->access_token,
		'refresh_token' => isset($_COOKIE['refresh_token']) ? $_COOKIE['refresh_token'] : null
	);
	
	echo json_encode(array_merge($login_info, $token_info));
?>