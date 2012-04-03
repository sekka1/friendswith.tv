<?php 
	try {
		// get the channel list
	    $channels = $sdp->getPlatformChannels(null, 20, 0);

		foreach ($channels as $channel) {
			// check if this channel is the current one
			// note that the IDs are compared as strings
		    $channelId = $channel['id'];
		    $selected = isset($currentChannel) && "$channelId" == "$currentChannel"; 
		    $class = $selected ? 'selected' : 'normal';

			// get the channel name and image
		    $name = $channel->name;
		    $imageUrl = imageUrl($channel);
			$image = "<img border=\"0\" width=\"64\" height=\"32\" src=\"$imageUrl\">";

			// this link calls a function to change channels
			$link = "changeChannel('$deviceId','$channelId')";

			// print the table row
		    echo("<tr id=\"channel-$channelId\" class=\"$class\">");
			echo("<td width=\"68\"><a href=\"#\" onClick=\"$link\">$image</a></td>");
			echo("<td><a href=\"#\" onClick=\"$link\">$name</a></td></tr>");
		}
	} catch (Exception $e) { 
		
	}	

?>