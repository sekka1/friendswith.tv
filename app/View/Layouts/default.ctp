<!doctype html>
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?> :: FriendsWith.TV
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('style');
		echo $this->Html->script('SDPWeb');
		echo $scripts_for_layout;
		//6495ED
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $this->Html->link('FriendsWith.TV', '/'); ?></h1>
			<!-- 
			<ul>
				<li><a href="#">Log into App</a></li>
				<li><a href="#">Log into Settop Box</a></li>
			</ul>
			 -->
		</div>
		<div id="content">
			<?php echo $this->Session->flash(); ?>
			<?php echo $content_for_layout; ?>
		</div>
		<div id="footer">
			<?php //echo $this->Html->link($this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),'http://www.cakephp.org/',	array('target' => '_blank', 'escape' => false)	);	?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>