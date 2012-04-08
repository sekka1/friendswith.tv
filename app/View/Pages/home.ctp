<?php $this->layout = false; ?>
<html lang="en">
<head>
	<title>FriendsWith.TV | Social TV</title>
	<?php 
		echo $this->Html->meta('icon'),"\n\t";
		echo $this->AssetCompress->css('splash_page.css'),"\n\t";
		echo $this->fetch('css');
	?>
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body>
	<header>
		<hgroup>
			<h1>FriendsWith.TV</h1>
			<h2>A completely integrated social TV experience</h2>
		</hgroup>
		<p>
			FriendsWith.TV is the winner of the Codefor.tv Hackathon sponsored by NDS and Citizen Space. FriendsWith.TV was created by a group of individuals who want to create a better set of tools for watching TV with your friends.
		</p>
	</header>
	<ul>
		<li class="share">
			<h3>Share your favorite movies, shows &amp; clips</h3>
			<p>Share TV shows and Scenes with friends. Shared content can be retrieved instantly on compatible set top boxes.</p>
		</li>
		<li class="control">
			<h3>Control TV from your tablet or smartphone</h3>
			<p>No need for the thousand button remote, with realtime TV controls, including pause, fast forward, rewind and more.</p>
		</li>
		<li class="sync">
			<h3>Realtime TV synching</h3>
			<p>Synchronizes your Handheld device with your cable set top box so you can receive real-time information and updates about what you are watching.</p>
		</li>
		<li class="connect">
			<h3>Connect with global fan communities</h3>
			<p>View status updates from your friends and the global TV audience about what you are watching.</p>
		</li>	
	</ul>
	<footer>
		<div>
			<img src="img/friends_with_tv_logo_splash.png" />
			<h4>Coming Soon to your TV</h4>
			<p>Media inquiries contact <a href="mailto:media@friendswith.tv">media@friendswith.tv</a></p>
			<small>&copy; 2012 Friendswith.TV. All Rights Reserved</small>
		</div>
	</footer>
</body>
</html>