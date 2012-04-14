<?php

require_once('config.php');

$numChannels = getCookieValue('websdp_numchannels', 10);
$numColumns = getCookieValue('websdp_numcolumns', 2);
$numHours = getCookieValue('websdp_numhours', 2);

$sdp->perform_auth_action();

header("Content-type: text/html; charset=utf-8");

function head($title = null, $bodyExtras = '') {
	if ($title) $title = " - $title";
	echo("<html><head>");
        echo('<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>');
	echo('<link rel="stylesheet" type="text/css" href="styles.css" media="screen" />');
	echo('<link rel="icon" type="image/png" href="images/favicon.ico" />');
	echo('<script type="text/javascript" src="websdp.js"></script>');
	echo('<script type="text/javascript" src="./SDPWebFramework/SDPWeb.js"></script>');
        echo("<title>WebSDP$title</title>");
	echo("</head><body $bodyExtras>");
}

function navbar($page) {
	global $pageWidth;
	global $sdp;

    echo("<center><table width=\"$pageWidth\" height=\"90\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">");
    echo('<tr><td valign="middle"><div class="headline">WebSDP</div></td>');

    $pages = array(
        'devices' => 'Devices',
        'channels' => 'Channels',
        'schedule' => 'Schedule',
        'content' => 'Content',
        'people' => 'People',
        'planner' => 'Planner',
        'context' => 'Context',
        'settings' => 'Settings',
    );

    echo('<td align="middle"><table border="0" cellspacing="0" cellpadding="7"><tr>');

    foreach ($pages as $page_key => $page_name) {
        $selected = $page_key == $page;
        $class = $selected ? 'selected' : 'tabs';
        echo("<td class=\"$class\"><a href=\"$page_key.php\">$page_name</a></td>");
    }

    if (!$sdp->loggedIn()) {
        $loginUrl = $sdp->loginUrl();
        echo("<td nowrap class=\"tabs\"><a href=\"$loginUrl\">Sign In</a></td>");
    } else {
		$logoutUrl = $sdp->logoutUrl();
        echo("<td nowrap class=\"tabs\"><a href=\"$logoutUrl\">Sign Out</a></td>");
    }

    echo('</tr></table></td>');

    echo('<td align="right"><img src="images/logo_NDS.png" width="165" height="53"></td></tr></table>');
}

function tail() {
	echo('</center></body></html>');
}

?>
