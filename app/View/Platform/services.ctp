<?php 
	//debug($services);
	if(!empty($services)){
		echo '<table>';
		echo '<thead>';
		echo '<th>Provider</th>';
		echo '<th>City</th>';
		echo '<th>Type</th>';
		echo '</thead>';
		foreach($services as $service){
			echo '<tr>';
			echo '<td>';
			echo $service['Name'];
			echo '</td>';
			echo '<td>';
			echo $service['City'];
			echo '</td>';
			echo '<td>';
			echo $service['Type'];
			echo '</td>';
			echo '</tr>';
		}
		echo '</table>';
	}
	
?>