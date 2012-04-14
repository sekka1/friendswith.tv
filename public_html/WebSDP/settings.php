<?php

require_once 'shared.php';

head('Settings');
navbar('settings');

function radio_button_row($name, $selected, $value, $content) {
    $row_class = $selected ? 'class="selected"' : '';
    $checked = $selected ? 'checked="checked"' : '';
    echo("<tr $row_class><td>&nbsp;&nbsp;&nbsp;<input type=\"radio\" name=\"$name\" $checked value=\"$value\">&nbsp;&nbsp;&nbsp;&nbsp;$content</td></tr>");
}

echo("<form action=\"settings.php\" method=\"get\"><table width=\"550\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\"><tr>");

echo('<tr class=""><td>Server</td></tr>');
$server_field = "<input name=\"websdp_server\" value=\"$customServer\" size=\"50\" placeholder=\"https://api.sdp.nds.com/v1\">";
radio_button_row('websdp_usecustomserver', $useCustomServer != '1', 0, 'default server');
radio_button_row('websdp_usecustomserver', $useCustomServer == '1', 1, $server_field);
echo('<tr><td>&nbsp;</td></tr>');

echo('<tr class=""><td>Household</td></tr>');
$household_field = "<input name=\"websdp_household\" value=\"$customHousehold\" size=\"4\" placeholder=\"1001\">";
radio_button_row('websdp_usecustomhousehold', $useCustomHousehold != '1', 0, 'default household for user');
radio_button_row('websdp_usecustomhousehold', $useCustomHousehold == '1', 1, $household_field);
echo('<tr><td>&nbsp;</td></tr>');

echo('<tr class=""><td>Device</td></tr>');
$device_field = "<input name=\"websdp_device\" value=\"$customDevice\" size=\"4\" placeholder=\"1001\">";
radio_button_row('websdp_usecustomdevice', $useCustomDevice != '1', 0, 'default device for household');
radio_button_row('websdp_usecustomdevice', $useCustomDevice == '1', 1, $device_field);
echo('<tr><td>&nbsp;</td></tr>');

if ($showAccessToken && isset($sdp->access_token)) {
	echo('<tr class=""><td>Access Token</td></tr>');
	echo("<tr><td><input name=\"websdp_numchannels\" value=\"{$sdp->access_token}\" size=\"50\" readonly=\"readonly\" placeholder=\"10\"></td></tr>");
	echo('<tr><td>&nbsp;</td></tr>');
}

echo('<tr class=""><td>Channels</td></tr>');
echo("<tr><td><input name=\"websdp_numchannels\" value=\"$numChannels\" size=\"2\" placeholder=\"10\"> channels per page</td></tr>");
echo("<tr><td><input name=\"websdp_numcolumns\" value=\"$numColumns\" size=\"2\" placeholder=\"10\"> columns</td></tr>");
echo("<tr><td><input name=\"websdp_numhours\" value=\"$numHours\" size=\"2\" placeholder=\"10\"> hours</td></tr>");
echo('<tr><td>&nbsp;</td></tr>');

echo('<tr><td align="center"><input type="submit" value="&nbsp;&nbsp;Save&nbsp;&nbsp;"></td></tr>');

echo('</table><input type="hidden" name="page" value="settings"></form>');

tail();

?>
