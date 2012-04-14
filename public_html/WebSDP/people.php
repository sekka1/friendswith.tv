<?php

require_once 'shared.php';

head('People');
navbar('people');

echo("<table width=\"$pageWidth\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\"><tr>");

echo("<td width=\"350\"><iframe name=\"people_list\" id=\"people_list\" width=\"350\" height=\"600\" frameborder=\"0\" src=\"people_list.php?q=george\"></iframe></td>");

echo("<td width=\"30\"><img src=\"images/spacer.gif\" width=\"30\" height=\"10\"></td>");

echo("<td><iframe width=\"100%\" name=\"people_detail\" id=\"people_detail\" height=\"600\" frameborder=\"0\" src=\"people_detail.php\"></iframe></td>");

echo('</tr></table>');

tail();

?>
