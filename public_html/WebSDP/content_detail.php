<?php
require_once 'shared.php';

head(null, 'class="clear"');

$series_id = isset($_GET['series']) ? $_GET['series'] : null;
$episode_id = isset($_GET['episode']) ? $_GET['episode'] : null;
$device_id = $sdp->deviceId();

if ($series_id || $episode_id) {
        $episode = null;
        if ($episode_id) {
            $episode = $sdp->getPlatformContent($episode_id, array());

            if ($episode_id && !$series_id) {
                    $series_id = $episode->content['id'];
            }
        }

	$series = $sdp->getPlatformContent($series_id, array());
	$contentImage = imageUrl($episode);

	if (isset($contentImage)) echo("<img src=\"$contentImage\" height=\"200\">");
	
	$content_id = $episode_id ? $episode_id : $series_id;
	echo("<img src=\"http://chart.apis.google.com/chart?cht=qr&chs=420x420&chld=L&choe=UTF-8&chl=http%3A%2F%2Fbookthis.tv%2Fcontentid%3D$content_id\" height=\"200\">");
	
	echo("<br><br>");
	if ($series->title) echo("{$series->title}<br>");
	if ($episode && $episode->title && strpos($episode->title, 'EPISODE:') !== 0) echo("{$episode->title}<br>");

        if ($episode) {
            $season_number = $episode['seasonNumber'];
            $episode_number = $episode['episodeNumber'];
            if ($season_number && $episode_number) echo("season $season_number, episode $episode_number<br>");
        }

	$schedules = $sdp->getPlatformContentAvailability($content_id, array('duration' => '20000'), 10);

	if ($schedules->scheduleInstance) {
		echo('<p><table width="75%" border="0" cellspacing="0" cellpadding="3">
		<tr class="alternating">
			<td>
				Channel
			</td>
			<td>
				Name
			</td>
			<td>
				Date
			</td>
			<td>
				Time
			</td>
			<td>
				&nbsp;
			</td>
		</tr>');

		foreach ($schedules->scheduleInstance as $schedule) {
			$schedule_id = $schedule['id'];
			$channel = $schedule->channel;
			$channel_id = $channel['id'];
			$channel_number = $channel['number'];
			$channel_name = $channel->name;
			$duration = $schedule->duration;

			$broadcastDateTime = $schedule->broadcastDateTime;
			$dateTime = strtotime($broadcastDateTime);
			$date = date('M j', $dateTime);
			$time = date('g:i A', $dateTime);

			$record = javascriptLink("addToPlanner('$device_id', '$schedule_id', '$channel_id', '$channel_number', '$channel_name', '$broadcastDateTime', '$duration')", 'record');
			echo("<tr class=\"alternating\"><td><a href=\"foo.php\">$channel_number</a></td><td>$channel_name</td><td>$date</td><td>$time</td><td>$record</td></tr>");
		}

		echo('</table></p>');
	}

	if ($series->synopsis) echo("<p>{$series->synopsis}</p>");
	if ($episode && $episode->synopsis) echo("<p>{$episode->synopsis}</p>");

	if (isset($series->webRefs->webRef)) {
		foreach($series->webRefs->webRef as $webRef) {
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