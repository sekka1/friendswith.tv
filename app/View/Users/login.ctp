<div class="users form">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User',array('url'=>'/users/login'));?>
    <?php
        echo $this->Form->input('email');
        echo $this->Form->input('password');
    ?>
<?php echo $this->Form->end(__('Login'));?>
<?php echo $this->Facebook->login(array('perms' => 'email,publish_stream')); ?>
<?php echo $this->Facebook->logout(array('redirect' => 'users/logout')); ?>
<a href="/users/register">Click here to Register</a>
</div>