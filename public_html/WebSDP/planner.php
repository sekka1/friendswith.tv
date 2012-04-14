<?php

require_once 'shared.php';

head('Planner');
navbar('planner');

foreach($sdp->devices() as $device) {
	$name = $device->name;
	if (!isset($name)) $name = $device->deviceId;

	echo("<table width=\"$pageWidth\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">");
	echo("<tr class=\"alternating\">
	<td width=\"70\">$name</td>
	<td width=\"110\">Channel</td>
	<td width=\"80\">Date</td>
	<td width=\"80\">Time</td>
	<td width=\"330\">Title</td>
	<td width=\"50\">Keep</td>
	<td width=\"80\">State</td>
	<td width=\"50\">&nbsp;</td>
	<td width=\"50\">&nbsp;</td>
	</tr>");

	$currentPlannerItemId = 0;

    try {
        $playout = $device->playout();
        $plannerInstance = $playout->plannerInstance;
        if (isset($plannerInstance)) $currentPlannerItemId = $plannerInstance['id'];
    } catch (Exception $e) {

    }

	$plannerInstances = array();
	try {
	    $plannerInstances = $device->planner();
	} catch (Exception $e) {
	    echo("<p>Couldn't get the planner for device " . $deviceId . ". Make sure it is turned on.</p>");
	}

	foreach ($plannerInstances as $planner) {
	    $plannerId = $planner['id'];
	    $selected = "$plannerId" == "$currentPlannerItemId";
	    $rowClass = $selected ? 'selected' : 'alternating';
	    $scheduleInstance = $planner->scheduleInstance;
	    $title = $scheduleInstance->content->title;
	    // for episodes, show the title of the series and episode
	    if (isset($scheduleInstance->content->content->title)) {
	        $title = $scheduleInstance->content->content->title . "<br>" . $title;
	    }
	    $channel_name = $scheduleInstance->channel->name;
	    $imageUrl = imageUrl($scheduleInstance->channel);
        $channelImage = "<img border=\"0\" width=\"64\" height=\"32\" src=\"$imageUrl\">";

	    $keep = $planner->keep == 'true' ? 'yes' : 'no';
	    $changeKeep = $planner->keep == 'true' ? 'false' : 'true';
	    $state = $planner->state;

	    $startDateTime = $scheduleInstance->broadcastDateTime;
	    $dateTime = strtotime($startDateTime);
	    $date = date('M j', $dateTime);
	    $time = date('g:i A', $dateTime);

	    $play = javascriptLink("playPlannerItem('$deviceId','$plannerId')", "<img width=\"28\" width=\"28\" src=\"images/planner_play.png\">");
	    $delete = javascriptLink("deleteFromPlanner('$deviceId','$plannerId')", "<img width=\"28\" width=\"28\" src=\"images/planner_delete.png\">");
	    $keepLink = javascriptLink("changePlannerItemKeep('$deviceId','$plannerId', '$changeKeep')", "$keep");
	    echo("<tr class=\"$rowClass\"><td>$channelImage</td><td>$channel_name</td><td>$date</td><td>$time</td><td>$title</td><td>$keepLink</td><td>$state</td><td>$play</td><td>$delete</td></tr>");
	}

	echo('</table><br><br>');
}

tail();

?>
