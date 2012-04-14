<?php
require_once 'shared.php';

head(null, 'class="clear"');

$person_id = isset($_GET['person']) ? $_GET['person'] : null;

if ($person_id) {
	$person = $sdp->getPerson($person_id, array());

	$personImage = imageUrl($person);
	if (isset($personImage)) echo("<img src=\"$personImage\" height=\"200\"><br><br>");

	if ($person->name) echo("{$person->name}<br>");

	$contentList = $sdp->getPersonContent($person_id, array(), 10);

	if ($contentList->content) {
		echo('<p><table width="75%" border="0" cellspacing="0" cellpadding="3">
		<tr class="alternating">
			<td>
				Title
			</td>
			<td>
				Type
			</td>
		</tr>');

		$count = 0;
		foreach ($contentList->content as $content) {
			$episode_id = $content['id'];
			$title = $content->title;
			$series = $content->content;
			if ($series) $title = $series->title;
			$type = $content['type'];

			echo("<tr class=\"alternating\"><td>$title</td><td>$type</td></tr>");

			$count++;
			if ($count == 10) break;
		}

		echo('</table></p>');
	}

	if (isset($person->webRefs->webRef)) {
		foreach($person->webRefs->webRef as $webRef) {
			$uri = $webRef->uri;
			$description = $webRef->description;
			if (!$description) $description = $webRef['type'];

			if (strlen($uri)) echo("<a href=\"$uri\" target=\"_top\">$description</a><br>");
		}
	}
}

?>
</body>
</html>