<?php
/**
  * Get an api_key and secret from facebook and fill in this content.
  * save the file to app/Config/facebook.php
  */
  $config = array(
  	'Facebook' => array(
  		'appId' => FB_API_ID,
  		'apiKey' => FB_API_KEY,
  		'secret' => 'YOUR_SECRET',
  		'cookie' => true,
  		'locale' => 'en_US',
  		)
  	);
?>