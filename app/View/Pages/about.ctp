<?php if (!$sdpLoggedIn): ?>
<center>
<img src="<?php echo $this->webroot; ?>img/splash_logo.png">
<br />
<br />
<a href="https://api.sdp.nds.com/oauth/authorize?client_id=<?php echo SDP_API_ID; ?>"><img src="<?php echo $this->webroot; ?>img/login_btn.png" onmouseover="javascript:this.src='<?php echo $this->webroot; ?>img/login_btn_hover.png'" onmouseout="javascript:this.src='<?php echo $this->webroot; ?>img/login_btn.png'"></a>
<br />
<br />
<img src="<?php echo $this->webroot; ?>img/testpattern_bottom.jpg">
</center>
<?php else: ?>
<h1>Home</h1>
<ul>
	<li><a href="/mobile">Mobile App</a></li>
	<li><a href="/device/context">Now Playing</a></li>
	<li><a href="/recs">My Reccomendations</a></li>
</ul>
<?php endif;?>