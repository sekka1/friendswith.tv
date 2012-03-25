<!-- app/View/Users/add.ctp -->
<div class="users form">
<?php echo $this->Form->create('User',array('url'=>'/users/register'));?>
    <fieldset>
        <legend><?php echo __('Register'); ?></legend>
    <?php
        echo $this->Form->input('email');
        echo $this->Form->input('password');
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>