<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link('<i class="icon-list"></i>' . __('List Languages'), array('action' => 'index'), array('escape' => FALSE)); ?></li>
		</ul>
	</div>
</div>


<div class="span8">
	<?php echo $this->Form->create('Language'); ?>
	<fieldset>
		<legend><?php echo __('Edit Language'); ?></legend>
		<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('code');
		echo $this->Form->input('code2');
		echo $this->Form->input('website');
		?>
	</fieldset>
	<?php echo $this->Form->end(array('label'=>__('Save'),'class'=>'btn btn-primary')); ?>
</div>
