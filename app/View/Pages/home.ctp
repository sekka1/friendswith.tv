<h1>Home</h1>
<ul>
	<!-- 
	<li><a href="#">Log into App</a></li>
	 -->
	<?php if (!$sdpLoggedIn): ?>
	<li><a href="https://api.sdp.nds.com/oauth/authorize?client_id=<?php echo SDP_API_ID; ?>">Log into Settop Box</a></li>
	<?php else: ?>
	<li><a href="#">Log Out of Settop Box</a></li>
	<li><a href="/device/context">Now Playing</a></li>
	<li><a href="/recs">My Reccomendations</a></li>
	<?php endif;?>
</ul>