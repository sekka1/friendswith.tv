<?php echo $this->Facebook->html(); ?>
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?> :: FriendsWith.TV
	</title>
	<?php
		echo $this->Html->script('SDPWeb');
		$rawOutput = Configure::read('debug');
		echo $this->Html->meta('icon'),"\n\t";
		echo $this->AssetCompress->css('all.css', $options=array('raw'=>$rawOutput)),"\n\t";
		//echo $this->Html->css('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css');
		echo $this->AssetCompress->includeCss();
		echo $this->AssetCompress->script('libs.js', $options=array('raw'=>$rawOutput)),"\n\t";
		echo $this->AssetCompress->includeJs(),"\n\t"; 
		echo $scripts_for_layout,"\n\t";
		echo $this->Js->writeBuffer(),"\n\t"; // Any Buffered Scripts
	?>
	<style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
</head>
<body>
 <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <!-- 
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
             -->
          </a>
          <a class="brand" href="/">FriendsWithTV</a>
          <div class="nav-collapse">
            <ul class="nav">
            	<!-- 
              <li class="active"><a href="/games">Games</a></li>
              <li><a href="/leaderboard">Leaderboard</a></li>
               -->
              <li><a href="<?php echo $this->webroot; ?>pages/about">About</a></li>
				<?php if ($this->Session->check('Auth.User')):?>
				<li><a href="/users/">HAI <?php echo strtoupper($this->Session->read('Auth.User.name'));?>!</a></li>
				<!-- 
				<li><a href="/users/logout">Log Out</a></li>
				 -->
				<?php else: ?>
				<li><a href="<?php echo $this->webroot; ?>users/login">Log In</a></li>
				<?php endif; ?>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
		<div id="content">
			<?php echo $this->Session->flash(); ?>
			<?php echo $content_for_layout; ?>
		</div>
    </div> <!-- /container -->
	<?php
		echo $this->Facebook->init();  
		if(env('REMOTE_ADDR')!='127.0.0.1') echo $this->element('js/owa');
		echo $this->element('sql_dump'); 
	?>
</body>
</html>