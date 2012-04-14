<?php

require_once 'shared.php';

head('Devices');
navbar('devices');

echo("<table width=\"$pageWidth\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">");
echo('<tr class="alternating">
<td>ID</td>
<td>Profile</td>
<td>Status</td>
<td>Time</td>
<td>Features</td></tr>');

$devices = array();

try {
    $devices = $sdp->devices();
} catch (Exception $e) {
    echo("<p>Couldn't get the devices. Check the connection details in the Settings tab. $e</p>");
}

foreach ($devices as $device) {
    $deviceId = $device->deviceId;
    $name = $device->name;
	$status = $device->status;
	$time = $device->time;
	$timezone = $device->timezone;
	$features = implode(', ', $device->features());

    echo("<tr class=\"alternating\"><td>$deviceId</td><td>$name</td><td>$status</td><td>$time $timezone</td><td>$features</td></tr>");
}

echo('</table>');

tail();

?>
