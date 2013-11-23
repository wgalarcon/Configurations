<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link('<i class="icon-list"></i>'.__('List Entities'),array('action'=>'index'), array('escape' => FALSE));?></li>
		</ul>
	</div>
</div>

<div class="span8">
	<?php echo $this->Form->create('Entity'); ?>
	<fieldset>
		<legend><?php echo __('Edit Entity'); ?></legend>
		<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('alias');
		echo $this->Form->input('folder');
		?>
	</fieldset>
	<?php echo $this->Form->end(array('label'=>__('Edit'),'class'=>'btn btn-primary')); ?>
</div>
