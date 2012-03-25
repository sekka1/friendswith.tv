<div class="users form">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User',array('url'=>'/users/login'));?>
    <fieldset>
    	<!-- 
        <legend><?php echo __('Please enter your username and password'); ?></legend>
         -->
    <?php
        echo $this->Form->input('email');
        echo $this->Form->input('password');
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Login'));?>
	<a href="/users/register">Click here to Register</a>
</div>