<?php

require_once 'shared.php';

head('Schedule');
navbar('schedule');


$channels = array();
$schedules = array();

try {
	$channels = $sdp->getPlatformChannels(null, 100);
} catch (Exception $e) {
	if (strpos($e, 'ServiceOperationIdentificationFailure')) {
		echo("<div><a href=\"$loginUrl\">Couldn't get the channel list. Please sign in first.</a></div>");
	} else {
		echo("<div>Couldn't connect to the SDP server.</div>");
	}
} 

$deviceId = $sdp->deviceId();

$count = 0;

if (count($channels)) {
	$channelIds = array();
	foreach ($channels as $channel) {
		$channelId = $channel['id'];
		$channelNumber = $channel['number'];
		$channelName = $channel->name;
		$channelIds[] = $channelId;

		$count++;
		if ($count == $numChannels) break;
	}
	$channelsParam = implode($channelIds, ',');

	$parameters = array('channels' => $channelsParam, 'duration' => $numHours * 60);

	try {
		$schedules = $sdp->getPlatformSchedule($parameters, 255, 0);
	} catch (Exception $e) {
		if (strpos($e, 'timed out')) {
			echo("<div>Couldn't get the schedule because the request timed out.</div>");
		} else {
			echo("<div>Couldn't get the schedule.</div>");
		}
	}	 
}

$imageHeight = 200;
$imageWidth = 267;
$spacerHeight = 10;

$spacer = "<img src=\"images/spacer.gif\" width=\"50\" height=\"$spacerHeight\">";

// holds the channel IDs of channels whose live content has been displayed
// the second schedule instance of a channel is a future instance
$used_channels = array();
$used_content = array();

if (count($schedules)) {
	foreach ($schedules as $schedule) {
		$scheduleId = $schedule['id'];
		$channel = $schedule->channel;
		$content = $schedule->content;
		$contentId = $schedule->content['id'];
		$channelId = $channel['id'];
		$selected = isset($currentChannelId) && "$channelId" == "$currentChannelId";
		$rowClass = $selected ? 'selected' : 'alternating';
		$channelName = $channel->name;
		$channelNumber = $channel['number'];
        $broadcastDateTime = $schedule->broadcastDateTime;
        $duration = $schedule->duration;

		$channelImage = imageUrl($channel);
		if (!$channelImage) {
			$channelImage = "images/channels/$channelId.png";
			if (!file_exists($channelImage)) continue;
		}
		$channelImage = "<img border=\"0\" src=\"$channelImage\" width=\"64\" height=\"32\">";

		$videoUrl = null;
		$playoutService = $channel->playoutService;
		if ($playoutService) $videoUrl = $playoutService->service->uri;
		
		$live = array_search("$channelId", $used_channels) === false;
		if ($live) $used_channels[] = "$channelId";

		// don't display duplicate content
		if (array_search("$contentId", $used_content) !== false) continue;
		$used_content[] = "$contentId";
		
		// date and time
		$broadcastDateTime = $schedule->broadcastDateTime;
		$dateTime = strtotime($broadcastDateTime);
		$time = date('g:i A', $dateTime);
		$duration = $schedule->duration;

		$title = $content->title;
		
		if ($title == 'Close') continue;
		if ($title == 'Paid Programming') continue;

		// for episodes, show the title of the series in place of the title of the episode
		if ($content['type'] == 'episode') {
			if (strpos($title, 'EPISODE') === 0 || strpos($title, '/20') != false) $title = null;

		    $seriesTitle = $content->content->title;
		    if (isset($seriesTitle) && strlen($seriesTitle) && "$seriesTitle" != "$title") {
		        $title = $title ? "$seriesTitle<br>$title" : $seriesTitle;
		    }
		}

		$contentImage = "images/content/$contentId.jpg";
		if (!file_exists($contentImage)) {
			$contentImage = imageUrl($content);
			if (!$contentImage) $contentImage = "images/generic.jpg";
		} 
		
		$badge = null;
		$link = null;
		if ($live) {
			if ($videoUrl) {
				$link = $videoUrl;
				// $badge = "<img border=\"0\" src=\"images/badges/stream.png\" width=\"64\" height=\"32\">";
			} else {
				$link = "javascript:changeChannel('$deviceId','$channelId')";
				// $badge = "<img border=\"0\" src=\"images/badges/live.png\" width=\"64\" height=\"32\">";
			}
		} else if (!$videoUrl) {
			$link = "javascript:addToPlanner('$deviceId', '$scheduleId', '$channelId', '$channelNumber', '$channelName', '$broadcastDateTime', '$duration')";
			$badge = null;
		}

		$contentTable = "<table class=\"schedule\" style=\"background-image:url('$contentImage'); background-width:60;\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\" width=\"$imageWidth\" height=\"$imageHeight\">";
		$contentTable .= "<tr><td valign=\"top\" height=\"95%\">$channelImage</td>";
		$contentTable .= "<td valign=\"top\" align=\"right\">$badge</td></tr>";
		$contentTable .= "<tr><td colspan=\"2\" class=\"schedule\" align=\"left\" valign=\"bottom\"><div class=\"title\">$title</div></td></tr></table>";
		
		if ($link) $contentTable = "<a href=\"$link\">$contentTable</a>";

		echo($contentTable);
	}
}

tail();

?>
