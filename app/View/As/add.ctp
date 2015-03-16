<?php echo $this->Form->create('A'); ?>
    <?php echo $this->Form->input('A.content'); ?>
    <?php echo $this->Form->input('B.0.content'); ?>
    <?php echo $this->Form->input('C.0.content'); ?>
<?php echo $this->Form->end('Submit'); ?>