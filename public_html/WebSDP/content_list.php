<?php
require_once 'shared.php';

head(null, 'class="clear"');

$selected_series = isset($_GET['series']) ? $_GET['series'] : null;

$params = array(/*"filter" => "type~series",*/ "q" => "top");
$q = isset($_GET['q']) ? $_GET['q'] : null;
if ($q) $params['q'] = urlencode ($q);

$contentList = array();
try {
	$contentList = $sdp->getPlatformContentList($params, 10, 0);
} catch (Exception $e) {
	echo("<p>Couldn't get the content list. Check the connection details in the Settings tab.</p>");
}

echo("<form action=\"content_list.php\" method=\"get\"><input type=\"search\" name=\"q\" value=\"$q\" size=\"50\" placeholder=\"Search\" autosave=\"content_search\" results=\"5\"/></form>");

echo('<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr class="alternating">
	<td>
		Title
	</td>
	<td width="50">
		Type
	</td>
</tr>');

foreach ($contentList as $series) {
	$title = $series->title;
	$series_id = $series['id'];
	$type = $series['type'];

	if ($type == 'series') {
		echo("<tr class=\"alternating\"><td><a href=\"content_list.php?q=$q&series=$series_id\">$title</a></td><td width=\"50\">$type</td>");

		if ($selected_series == $series_id) {
			try {
				$contentList = $sdp->getPlatformContentChildrenList($series_id, array(), 10, 0);
			} catch (Exception $e) {

			}

			if (count($contentList->content)) {
				foreach ($contentList as $episode) {
					$title = $episode->title;
					$episode_id = $episode['id'];
					$type = $episode['type'];

					echo("<tr class=\"alternating\"><td><a target=\"content_detail\" href=\"content_detail.php?series=$series_id&episode=$episode_id\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$title</a></td><td width=\"50\">$type</td></tr>");
				}
			}
		}
	} else if ($type == 'episode') {
		echo("<tr class=\"alternating\"><td><a target=\"content_detail\" href=\"content_detail.php?episode=$series_id\">$title</a></td><td width=\"50\">$type</td></tr>");
	} else {
		echo("<tr class=\"alternating\"><td><a target=\"content_detail\" href=\"content_detail.php?series=$series_id\">$title</a></td><td width=\"50\">$type</td></tr>");
	}
}

echo('</table>');

?>
</body>
</html>