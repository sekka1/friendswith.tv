<?php 
	switch(env('HTTP_HOST')){
		case 'local.friendswith.tv':
			define('FB_API_ID','313145155419797');
			define('FB_API_KEY','a18377a2305ab2abd87885595315e027');
			define('SDP_API_ID','f0fec7c7794af1c22d98ba3180f99d24');
			define('SDP_API_KEY','ff2c2444ecfe0adf');
			break;
		case 'd1.friendswith.tv':
			define('FB_API_ID','123164717814646');
			define('FB_API_KEY','3115580346c4217835ba79686a11aaf7');
			define('SDP_API_ID','d8c6c08b878a93b644ca542cc149fe21');
			define('SDP_API_KEY','bc0f6e841764c545');
			break;
		case 'fwt':
			define('SDP_API_ID','148ca50aa64eca2701da74a219df81ff');
			define('SDP_API_KEY','4fa0766fbb059627');
			break;
		case 'local.friendswith.tv':
			define('SDP_API_ID','1f3512086500cadf98490979a5a1b9fd');
			define('SDP_API_KEY','6c61bd3dd2aec6f1');
			break;	
		case 'friendswith.tv':
		case 'www.friendswith.tv':
			default:
			define('FB_API_ID','329575197105604');
			define('FB_API_KEY','961faf874fcda19d27b862e9a66e8287');
			define('SDP_API_ID','e29409e7b76b58038d823df451878346');
			define('SDP_API_KEY','373f246dc3035dfe');
			break;
	}
	