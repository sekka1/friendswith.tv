<table>
<thead>
<tr>
	<th>
		Channel
	</th>
	<th>
		30
	</th>
	<th>
		60
	</th>
	<th>
		90
	</th>
	<th>
		120
	</th>
</tr>
</thead>
<tbody>
<?php 
foreach($gridschedule['GridChannels'] as $channel){
	//debug($channel);
	echo'<tr><td>';
	echo $channel['Channel'].' '.$channel['DisplayName'];
	foreach($channel['Airings'] as $airing){
		echo'</td><td>';
		//debug($airing);
		echo $this->Html->link($airing['Title'],'#',array('onclick'=>"GridSchedule.clickProgram('{$airing['ProgramId']}');return false;"));
	}
	echo'</td></tr>';
}
?>
</tbody>
</table>
