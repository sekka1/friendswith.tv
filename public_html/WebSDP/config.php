<?php

set_include_path(get_include_path() . ':../:../../');
require_once('SDPWebFramework/SDPWeb.php');

date_default_timezone_set('Europe/London');

$pageWidth = 900;
$numChannels = 10;
$numHours = 2; // the number of hours in the schedule grid
$numColumns = 2; // the number of columns in the schedule grid
$hideChannelsWithNoLogo = false;
$hideChannelsWithNoSchedule = false;
$showAccessToken = false; // shows the access token on the settings page

// create an SDPWeb object
$sdp = new SDPWeb();

// set the API key and API secret
// you can get an API key from the SDP developer portal at http://developer.sdp.nds.com
// make sure to set the Application URL for your app to the location of this page
// you will then receive the API key and API secret via email
$sdp->apiKey = '7a0ad1e693b333daeab93f1fc2b448e6';
$sdp->apiSecret = 'MISSING_API_SECRET';

?>
