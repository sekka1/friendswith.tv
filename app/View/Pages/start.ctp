<?php
	echo $this->Form->create('Provider'); 
	echo $this->Form->input('Provider.zip');
	echo $this->Form->hidden('Provider.service_id');
	echo $this->Form->hidden('Provider.msoid');
	echo $this->Form->end('Search');
?>

<a href="https://api.sdp.nds.com/oauth/authorize?client_id=<?php echo SDP_API_ID; ?>">SDP Enabled?</a>