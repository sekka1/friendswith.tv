<script id="contactTemplate" type="text/template">
    <img src="<%= photo %>" alt="<%= name %>" />
    <h1><%= name %><span><%= type %></span></h1>
    <div><%= address %></div>
    <dl>
        <dt>Tel:</dt><dd><%= tel %></dd>
        <dt>Email:</dt><dd><a href="mailto:<%= email %>"><%= email %></a></dd>
    </dl>
</script>
<script id="deviceTemplate" type="text/template">
    <table class="schedule" width="267" border="0" cellspacing="0" cellpadding="3">
      <tr class="header">
        <td>
           Device <%= id %>
        </td>
        <td align="right">
          Live 
        </td>
      </tr>
      <tr>
        <td class="nopadding" colspan="2">
          <table id="contentTable-<%= id %>" style="background-image:url('http://j.static-locatetv.com/images/content/4/45035_without_a_trace.jpg');" border="0" cellspacing="0" cellpadding="5" width="267" height="200">
            <tr>
              <td valign="top" height="95%">
                <img id="channelImage-<%= id %>" border="0" src="http://j.static-locatetv.com/images/channel/cbs.png" width="64" height="32">
              </td>
            </tr>
            <tr>
              <td class="schedule" align="left" valign="bottom">
                <div id="contentTitle-<%= id %>" class="title">
                  <a href="/platform/content/<%= contentId %>"><%= contentTitle %>
                </div>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr class="header">
        <td>
           <span id="position-<%= id %>"></span>
        </td>
        <td align="right">
          <span id="playbackSpeed-<%= id %>"></span> 
        </td>
      </tr>
      <tr>
        <td class="nopadding" colspan="2" height="50" align="center" valign="middle">
          <table width="267" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center">
                <a href="#" onclick="stepBackward('<%= id %>')"><img id="skip_backward" src="/img/skip_backward.png" width="30" height="30"></a>
              </td>
              <td align="center">
                <a href="#" onclick="speed('<%= id %>', '-2')"><img id="reverse" src="/img/reverse.png" width="30" height="30"></a>
              </td>
              <td align="center">
                <a href="#" onclick="playPause('<%= id %>')"><img id="playPause-<%= id %>" src="/img/pause.png" width="30" height="30"></a>
              </td>
              <td align="center">
                <a href="#" onclick="speed('<%= id %>', '2')"><img id="forward" src="/img/forward.png" width="30" height="30"></a>
              </td>
              <td align="center">
                <a href="#" onclick="stepForward('<%= id %>')"><img id="skip_forward" src="/img/skip_forward.png" width="30" height="30"></a>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
</script>
<!-- 
<?php 

function controlButton($link, $image, $id) {
	return "<td align=\"center\">" . javascriptLink($link, "<img id=\"$id\" src=\"/img/$image.png\" width=\"30\" height=\"30\">") . "</td>";
}

foreach ($sdp->devices() as $deviceId => $device) {
	$context = $device->context();
	$deviceName = (isset($device->name) && strlen("$device->name")) ? $device->name : "Device {$deviceId}";
	
    echo("<table class=\"schedule\" width=\"267\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">");
    echo("<tr class=\"header\"><td>&nbsp;$deviceName</td><td align=\"right\">{$context['type']}&nbsp;</td></tr>");

	if ($device->isOn()) {
		$contentId = $context['contentId'];
		$contentTitle = $context['contentTitle'];
		$seriesTitle = isset($context['seriesTitle']) ? $context['seriesTitle'] : null;
		if ($seriesTitle && $seriesTitle != $contentTitle) $contentTitle = $seriesTitle . "<br>" . $contentTitle;

		$contentImage = isset($context['contentImage']) ? $context['contentImage'] : '/img/generic.jpg';
		$channelImage = isset($context['channelImage']) ? $context['channelImage'] : '/img/spacer.png';

		$contentTable = "<table id=\"contentTable-$deviceId\" style=\"background-image:url('$contentImage');\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\" width=\"267\" height=\"200\">";
		$contentTable .= "<tr><td valign=\"top\" height=\"95%\"><img id=\"channelImage-$deviceId\" border=\"0\" src=\"$channelImage\" width=\"64\" height=\"32\"></td></tr>";
		$contentTable .= "<tr><td class=\"schedule\" align=\"left\" valign=\"bottom\"><div id=\"contentTitle-$deviceId\" class=\"title\"><a href=\"/platform/content/$contentId\">$contentTitle</a></div></td></tr>";
		$contentTable .= "</table>";
	    echo("<tr><td class=\"nopadding\" colspan=\"2\">$contentTable</td></tr>");

	    $timecode = formattedTime($context['position']);
	    $speed = formattedSpeed($context['playbackSpeed']);
		echo("<tr class=\"header\"><td>&nbsp;<span id=\"position-$deviceId\">$timecode</span></td>");
		echo("<td align=\"right\"><span id=\"playbackSpeed-$deviceId\">$speed</span>&nbsp;</td></tr>");

		$playPauseImage = $context['playbackSpeed'] == 1 ? 'pause' : 'play';
		$controlTable = "<table width=\"267\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr>";
		$controlTable .= controlButton("stepBackward('$deviceId')", "skip_backward", "skip_backward");
		$controlTable .= controlButton("speed('$deviceId', '-2')", "reverse", "reverse");
		$controlTable .= controlButton("playPause('$deviceId')", $playPauseImage, "playPause-$deviceId");
		$controlTable .= controlButton("speed('$deviceId', '2')", "forward", "forward");
		$controlTable .= controlButton("stepForward('$deviceId')", "skip_forward", "skip_forward");
		$controlTable .= "</tr></table>";
		echo("<tr><td class=\"nopadding\" colspan=\"2\" height=\"50\" align=\"center\" valign=\"middle\">$controlTable</td></tr>");
	} else {
	    echo("<tr><td class=\"nopadding\" colspan=\"2\"><img width=\"267\" height=\"200\" src=\"/img/generic.jpg\"></td></tr>");
		echo("<tr class=\"header\"><td>&nbsp;</td><td align=\"right\">&nbsp;</td></tr>");
		echo("<tr><td class=\"nopadding\" colspan=\"2\" height=\"50\">&nbsp;</td></tr>");
	}
	
	echo("</table>");
	
}
?>
 -->