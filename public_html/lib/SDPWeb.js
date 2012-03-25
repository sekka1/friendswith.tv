/*

Functions in this script call a PHP proxy called /device/action that should have one method call:

	$sdp->perform_action();

The application can optionally implement the following JavaScript functions to receive notification callbacks:

	function scheduleDidChange(deviceId, oldSchedule, newSchedule)
	function plannerDidChange(deviceId, oldPlanner, newPlanner)
	function channelDidChange(deviceId, oldChannel, newChannel, channelNumber, channelName, channelImage)
	function contentDidChange(deviceId, oldChannel, newChannel, contentTitle, seriesTitle, contentImage)
	function positionDidChange(deviceId, oldPosition, newPosition)
	function playbackSpeedDidChange(deviceId, oldPlaybackSpeed, newPlaybackSpeed)

*/

var longpollUrl;
var unsubscribeUrl;
var longpollRequest;
var devices;
var lastModified = null;
var etag = null;
var shouldUnsubscribe = true;

function newRequest() {
    if (window.XMLHttpRequest) {
        return new XMLHttpRequest();
    } else {
        return new ActiveXObject("Microsoft.XMLHTTP");
    }
}

function changeChannel(deviceId, channelId) {
    link = '/device/action?action=watch&deviceId=' + deviceId + '&channelId=' + channelId;

    request = newRequest();
    request.open('GET', link, true);
    request.send();
}

function setPosition(deviceId, position) {
    link = '/device/action?action=scrub&deviceId=' + deviceId + '&position=' + position;

    request = newRequest();
    request.open('GET', link, true);
    request.send();
}

function stepBackward(deviceId) {
        var device = devices[deviceId];
	setPosition(deviceId, device['position'] - 30);
}

function stepForward(deviceId) {
        var device = devices[deviceId];
	setPosition(deviceId, device['position'] + 30);
}

function addToPlanner(deviceId, scheduleId, channelId, channelNumber, channelName, dateTime, duration) {
    link = '/device/action?action=record&deviceId=' + deviceId + '&scheduleId=' + scheduleId + '&channelId=' + channelId + '&channelNumber=' + channelNumber + '&channelName=' + channelName + '&dateTime=' + dateTime + '&duration=' + duration;

    request = newRequest();
    request.open('GET', link, true);
    request.send();
}

function playPlannerItem(deviceId, plannerId) {
    link = '/device/action?action=play&deviceId=' + deviceId + '&plannerId=' + plannerId;

    request = newRequest();
    request.open('GET', link, true);
    request.send();
}

function playPause(deviceId) {
	var device = devices[deviceId];
	if (device['playbackSpeed'] == 1) {
		pause(deviceId);
	} else {
		resume(deviceId);
	}
}

function pause(deviceId) {
    link = '/device/action?action=pause&deviceId=' + deviceId;

    request = newRequest();
    request.open('GET', link, true);
    request.send();
}

function resume(deviceId) {
    link = '/device/action?action=resume&deviceId=' + deviceId;

    request = newRequest();
    request.open('GET', link, true);
    request.send();
}

function speed(deviceId, speed) {
    link = '/device/action?action=speed&deviceId=' + deviceId + '&speed=' + speed;

    request = newRequest();
    request.open('GET', link, true);
    request.send();
}

function stop(deviceId) {
    link = '/device/action?action=stop&deviceId=' + deviceId;

    request = newRequest();
    request.open('GET', link, true);
    request.send();
}

function changePlannerItemKeep(deviceId, plannerId, keep) {
    link = '/device/action?action=keep&deviceId=' + deviceId + '&plannerId=' + plannerId + '&keep=' + keep;

    request = newRequest();
    request.open('GET', link, true);
    request.send();
}

function deleteFromPlanner(deviceId, plannerId) {
    link = '/device/action?action=delete&deviceId=' + deviceId + '&plannerId=' + plannerId;

    request = newRequest();
    request.open('GET', link, true);
    request.send();
}

function longpoll() {
	if (longpollUrl) {
	    link = '/device/action?action=longpoll&url=' + longpollUrl;
	    if (etag) {
	        link += '&etag=' + etag;
	    }
	    if (lastModified) {
	        link += '&lastModified=' + lastModified;
	    }

        Ext.Ajax.request({
           url: link, 
           method: 'GET',
           success: function(request) {
               longpollRequest = request;
               didLongpoll();
               longpoll();
           },
           failure: function(request) {
               if (request.status === 403) {
                   alert('403 long poll error');
               } else {
                   longpoll();
               }
           }
        });
//	    longpollRequest = newRequest();
//	    longpollRequest.onreadystatechange = didLongpoll; // your app should implement this function
//	    longpollRequest.open('GET', link, true);
//	    longpollRequest.send();
	}
}

function didLongpoll() {
//    if (longpollRequest.readyState == 4) {
        if (longpollRequest.status == 200) {
			message = JSON.parse(longpollRequest.responseText);
            
            var deviceId = message['deviceId'];
			var newContext = message['context'];

			etag = message['etag'];
			lastModified = message['lastModified'];

			var device = devices[deviceId];

            if (device && newContext) {
				if (newContext['contentId'] && device['contentId'] != newContext['contentId']) {
	                device['contentId'] = newContext['contentId'];
	                Application.fireEvent('contentchange', deviceId, newContext, device);
	            }

	            if (newContext['scheduleId'] && device['scheduleId'] != newContext['scheduleId']) {
	                device['scheduleId'] = newContext['scheduleId'];
	                Application.fireEvent('schedulechange', deviceId, newContext, device);
	            }

	            if (newContext['plannerId'] && device['plannerId'] != newContext['plannerId']) {
	                device['plannerId'] = newContext['plannerId'];
	                Application.fireEvent('plannerchange', deviceId, newContext, device);
	            }

	            if (device['position'] != newContext['position']) {
	                Application.fireEvent('positionchange', deviceId, newContext, device);
	                device['position'] = newContext['position'];
	            }
	            
	            if (device['duration'] != newContext['duration']) {
	                Application.fireEvent('durationchange', deviceId, newContext, device);
	                device['duration'] = newContext['duration'];
	            }

	            if (device['playbackSpeed'] != newContext['playbackSpeed']) {
	                device['playbackSpeed'] = newContext['playbackSpeed'];
	                Application.fireEvent('playbackspeedchange', deviceId, newContext, device);
	            }
	            
	            if (newContext['channelId'] && device['channelId'] != newContext['channelId']) {
	                device['channelId'] = newContext['channelId'];
	                Application.fireEvent('channelchange', deviceId, newContext, device);
	            }
			}
        //}

        // if (longpollRequest.status != 403) {
        //          longpoll();
        // } else {
        //     alert('403!');
        // }
    }
}

function reloadPage() {
    shouldUnsubscribe = false;
    window.location.reload();
}

function unsubscribe() {
	if (shouldUnsubscribe) {
	    link = '/device/action?action=unsubscribe&url=' + unsubscribeUrl;

	    request = newRequest();
	    request.open('GET', link, false);
	    request.send();
	}
}

function incrementPosition() {
	for (var deviceId in devices) {
		var device = devices[deviceId];

		currentPlaybackSpeed = device['playbackSpeed'];
		currentPosition = device['position'];
		type = device['type'];

		if (type != 'Off' && currentPlaybackSpeed != 0) {
			var newPosition = currentPosition + currentPlaybackSpeed;
			device['position'] = newPosition;
			Application.fireEvent('positionchange', deviceId, device);
		}
	}

	setTimeout('incrementPosition()', 1000);
}

function formattedTime(position) {
    var hours = Math.floor(position / 3600) % 24;
    var minutes = Math.floor(position / 60) % 60;
    var seconds = Math.floor(position) % 60;

    var timecode = zeroPad(hours, 2) + ':' + zeroPad(minutes, 2) + ':' + zeroPad(seconds, 2);
    return timecode;
}

function zeroPad(num,count) {
    var numZeropad = num + '';
    while(numZeropad.length < count) {
        numZeropad = "0" + numZeropad;
    }
    return numZeropad;
}

Ext.define('SDPWeb', {
    singleton: true
});