<?php
require_once 'shared.php';

head(null, 'class="clear"');

$params = array();
$q = isset($_GET['q']) ? $_GET['q'] : null;
if ($q) $params['q'] = $q;

$people = array();
try {
	$people = $sdp->getPeopleList($params, 15);
} catch (Exception $e) {
	echo("<p>Couldn't get the people list. Check the connection details in the Settings tab.</p>");
}

echo("<form action=\"people_list.php\" method=\"get\"><input type=\"search\" name=\"q\" value=\"$q\" size=\"50\" placeholder=\"Search\" autosave=\"content_search\" results=\"5\"/></form>");

echo('<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr class="alternating">
	<td>
		Name
	</td>
	<td width="50">
		Roles
	</td>
</tr>');

foreach ($people as $person) {
	$name = $person->name;
	$person_id = $person['id'];
	$roles = $person->roles;

	$roles_array = array();
	foreach ($person->roles->role as $role) $roles_array[] = $role;
	$roles_string = implode(', ', $roles_array);

	echo("<tr class=\"alternating\"><td><a target=\"people_detail\" href=\"people_detail.php?person=$person_id\">$name</a></td><td>$roles_string</td></tr>");
}

echo('</table>');

?>
</body>
</html>