<?php

require_once 'shared.php';

head('Content');
navbar('content');

echo("<table width=\"$pageWidth\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\"><tr>");

echo("<td width=\"350\"><iframe name=\"content_list\" id=\"content_list\" width=\"350\" height=\"600\" frameborder=\"0\" src=\"content_list.php?q=top\"></iframe></td>");

echo("<td width=\"30\"><img src=\"images/spacer.gif\" width=\"30\" height=\"10\"></td>");

echo("<td><iframe width=\"100%\" name=\"content_detail\" id=\"content_detail\" height=\"600\" frameborder=\"0\" src=\"content_detail.php\"></iframe></td>");

echo('</tr></table>');

tail();

?>
