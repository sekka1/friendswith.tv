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
			define('SDP_API_ID','148ca50aa64eca2701da74a219df81ff');
			define('SDP_API_KEY','4fa0766fbb059627');
			break;
			case 'fwt':
			define('SDP_API_ID','148ca50aa64eca2701da74a219df81ff');
			define('SDP_API_KEY','4fa0766fbb059627');
			break;
		case 'friendswith.tv':
		default:
			define('SDP_API_ID','e29409e7b76b58038d823df451878346');
			define('SDP_API_KEY','373f246dc3035dfe');
			break;
	}
	