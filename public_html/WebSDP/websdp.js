function scheduleDidChange(deviceId, oldSchedule, newSchedule) {
	console.log('scheduleDidChange('+deviceId+','+oldSchedule+','+newSchedule+')');
}

function plannerDidChange(deviceId, oldPlanner, newPlanner) {
	console.log('plannerDidChange('+deviceId+','+oldPlanner+','+newPlanner+')');
}

function channelDidChange(deviceId, oldChannel, newChannel, channelNumber, channelName, channelImage) {
	console.log('channelDidChange('+deviceId+','+oldChannel+','+newChannel+','+channelNumber+','+channelName+','+channelImage+')');

	// replace the channel logo
	document.getElementById('channelImage-'+deviceId).src = channelImage;	
}

function contentDidChange(deviceId, oldChannel, newChannel, contentTitle, seriesTitle, contentImage) {
	console.log('contentDidChange('+deviceId+','+oldChannel+','+newChannel+','+contentTitle+','+seriesTitle+','+contentImage+')');

	// replace the content image
	if (!contentImage) contentImage = 'images/generic.jpg';
	document.getElementById('contentTable-'+deviceId).style.backgroundImage = 'url('+contentImage+')';	

	// replace the content title
	if (seriesTitle && seriesTitle != contentTitle) contentTitle += '<br>'+seriesTitle;
	document.getElementById('contentTitle-'+deviceId).innerHTML = contentTitle;	
}

function positionDidChange(deviceId, oldPosition, newPosition) {
	console.log('positionDidChange('+deviceId+','+oldPosition+','+newPosition+')');

	// update the position
    var positionSpan = document.getElementById('position-'+deviceId);
	if (positionSpan) positionSpan.innerHTML = formattedTime(newPosition);
}

function playbackSpeedDidChange(deviceId, oldPlaybackSpeed, newPlaybackSpeed) {
	console.log('playbackSpeedDidChange('+deviceId+','+oldPlaybackSpeed+','+newPlaybackSpeed+')');

	var speed = 'playing';
	if (newPlaybackSpeed == 0) speed = 'paused';
	else if (newPlaybackSpeed > 1) speed = 'fast forward '+newPlaybackSpeed+'x';
	else if (newPlaybackSpeed < 0) speed = 'reverse '+(newPlaybackSpeed * -1)+'x';
	
	// update the speed
	var playbackSpeedSpan = document.getElementById('playbackSpeed-'+deviceId);
	if (playbackSpeedSpan) playbackSpeedSpan.innerHTML = speed;
	
	// update the play/pause button
	var playPauseButton = document.getElementById('playPause-'+deviceId);
	if (playPauseButton) playPauseButton.src = (newPlaybackSpeed == 1) ? 'images/pause.png' : 'images/play.png';
}

