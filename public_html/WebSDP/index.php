<?php

require_once 'shared.php';

head();
navbar('home');

if (!$sdp->loggedIn()) {
    $loginUrl = $sdp->loginUrl();
    echo("<p>Welcome to WebSDP.</p><p><a href=\"$loginUrl\">To get started, please sign in.</a></p>");
} else {
    echo("<p>You are now signed in.</p><p>Click one of the links above to continue.</p>");
}

tail();

?>
