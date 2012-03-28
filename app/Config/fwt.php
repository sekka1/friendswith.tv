<?php 
	switch(env('HTTP_HOST')){
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
	