<?php

require_once 'shared.php';

head('Channels');
navbar('channels');

$deviceId = $sdp->deviceId();

if ($deviceId) {
    try {
        $playout = $sdp->getPlayout($deviceId);
        if (isset($playout))
            $scheduleInstance = $playout->scheduleInstance;
        if (isset($scheduleInstance))
            $currentChannel = $scheduleInstance->channel;
        if (isset($currentChannel))
            $currentChannelId = $currentChannel['id'];
    } catch (Exception $e) {
        echo("<p>Couldn't get the current channel. Check the connection details in the Settings tab, and make sure your set-top box is turned on.</p>");
    }
}

echo("<table width=\"$pageWidth\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">");

$channels = array();
$page = isset($_GET['page']) ? $_GET['page'] : 0;

try {
    $channels = $sdp->getPlatformChannels(null, $numChannels, $page * $numChannels);
} catch (Exception $e) {
   echo("<p>Couldn't get the channel list.</p>");
}

if (count($channels)) {
    $start = $channels['start'];
    $startDisplay = $start + 1;
    $count = $channels['count'];
    $end = $start + $count;
    $total = $channels['total'];

    $colspan = $numColumns + 2;
    echo("<tr class=\"alternating\"><td colspan=\"$colspan\" height=\"40\">&nbsp;&nbsp;&nbsp;");
    echo("Showing channels $startDisplay through $end.");
    echo('</td><td align="right">');
    if ($start > 0)
        echo("<a href=\"channels.php?page=" . ($page - 1) . "\">previous</a>");
    if ($start > 0 && $end < $total)
        echo(' | ');
    if ($end < $total)
        echo("<a href=\"channels.php?page=" . ($page + 1) . "\">next</a>");
    echo('&nbsp;&nbsp;&nbsp;</td></tr>');

    $channelIds = array();
    foreach ($channels as $channel) {
        $channelId = $channel['id'];
        $channelNumber = $channel['number'];
        $channelName = $channel->name;
		$channelImage = imageUrl($channel);

        if (!$channelImage && $hideChannelsWithNoLogo)
            continue; // only use logo stations

        $channelIds[] = $channelId;
    }
    $channelsParam = implode($channelIds, ',');

    $parameters = array('channels' => $channelsParam, 'duration' => $numHours * 60);

    $schedules = array();
    try {
        $schedules = $sdp->getPlatformSchedule($parameters, 255, 0);
    } catch (Exception $e) {
        if (strpos($e, 'ServiceOperationIdentificationFailure')) {
            echo("<p>Couldn't get the schedule for all channels because the SDP server does not support the /platform/schedule API.</p>");
        } else if (strpos($e, 'timed out')) {
            echo("<p>Couldn't get the schedule because the request timed out.</p>");
        } else {
            echo("<p>Couldn't get the schedule.</p>");
        }
    }

    if (count($schedules)) {
        foreach ($channels as $channel) {
            $episodes = array();

            $channelId = $channel['id'];
            $selected = isset($currentChannelId) && "$channelId" == "$currentChannelId";
            $rowClass = $selected ? 'selected' : 'alternating';
            $channelName = $channel->name;
            $channelNumber = $channel['number'];
            $channelShortName = substringToString($channelName, ' (');

            foreach ($schedules as $schedule) {
                $scheduleId = $schedule['id'];
                $scheduleChannel = $schedule->channel;

                if (intval($channel['number']) == intval($scheduleChannel['number'])) {
                    // date and time
                    $broadcastDateTime = $schedule->broadcastDateTime;
                    $dateTime = strtotime($broadcastDateTime);
                    $time = date('g:i A', $dateTime);
                    $duration = $schedule->duration;

                    $content = $schedule->content;
                    $title = $content->title;

                    // for episodes, show the title of the series in place of the title of the episode
                    if ($content['type'] == 'episode') {
                        $seriesTitle = $content->content->title;
                        if (isset($seriesTitle) && strlen($seriesTitle) && "$seriesTitle" != "$title") {
                            $seasonEpisode = '';
                            if (isset($content['seasonNumber']) && isset($content['episodeNumber']))
                                $seasonEpisode = sprintf("S%02dE%02d ", $content['seasonNumber'], $content['episodeNumber']);
                            $title = "$seriesTitle<br>$seasonEpisode$title";
                        }
                    }

                    if ($hideChannelsWithNoSchedule && $title == 'Close')
                        continue;

                    // make name shorter
                    $title = substringToString($title, ' -');

                    $titleLink = javascriptLink("addToPlanner('$deviceId', '$scheduleId', '$channelId', '$channelNumber', '$channelName', '$broadcastDateTime', '$duration')", "$time<br>$title");

                    $episodes[] = "<td>$titleLink&nbsp;&nbsp;&nbsp;</td>";
                    if (count($episodes) == $numColumns)
                        break;
                }
            }

            if (count($episodes) || !$hideChannelsWithNoSchedule) { // only show channels that have a schedule
                echo("<tr height=\"32\" class=\"$rowClass\">");

                echo('<td width="85" align="center">');
                $imageUrl = imageUrl($channel);
                if ($imageUrl) {
                    echo(javascriptLink("changeChannel('$deviceId','$channelId')", "<img border=\"0\" width=\"64\" height=\"32\" src=\"$imageUrl\">"));
                }
                echo('</td>');

                $channelNumber = javascriptLink("changeChannel('$deviceId','$channelId')", $channelNumber);
                echo("<td>$channelNumber&nbsp;&nbsp;&nbsp;</td>");

                $channelShortName = javascriptLink("changeChannel('$deviceId','$channelId')", $channelShortName);
                echo("<td>$channelShortName&nbsp;&nbsp;&nbsp;</td>");

                foreach ($episodes as $episode)
                    echo $episode;

                // add extra empty cells
                for ($extra = count($episodes); $extra < $numColumns; $extra++)
                    echo("<td>&nbsp;</td>");

                echo('</tr>');
            }
        }
    } else { // couldn't get schedules, so just show channels
        foreach ($channels as $channel) {
            $episodes = array();

            $channelId = $channel['id'];
            $selected = isset($currentChannelId) && "$channelId" == "$currentChannelId";
            $rowClass = $selected ? 'selected' : 'alternating';
            $channelName = $channel->name;
            $channelNumber = $channel['number'];
            $channelShortName = substringToString($channelName, ' (');

            echo("<tr height=\"32\" class=\"$rowClass\">");

            echo('<td width="85" align="center">');
			$imageUrl = imageUrl($channel);
            if ($imageUrl) {
                echo(javascriptLink("changeChannel('$deviceId','$channelId')", "<img border=\"0\" width=\"64\" height=\"32\" src=\"$imageUrl\">"));
            }
            echo('</td>');

            $channelNumber = javascriptLink("changeChannel('$deviceId','$channelId')", $channelNumber);
            echo("<td>$channelNumber&nbsp;&nbsp;&nbsp;</td>");

            $channelShortName = javascriptLink("changeChannel('$deviceId','$channelId')", $channelShortName);
            echo("<td>$channelShortName&nbsp;&nbsp;&nbsp;</td>");

            for ($extra = 0; $extra < $numColumns; $extra++)
                echo("<td>&nbsp;</td>");

            echo('</tr>');
        }
    }
}

echo('</table>');

echo('<p>Click a channel to watch now. Click a show to add it to the planner.</p>');

tail();
?>
