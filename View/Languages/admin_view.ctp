<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li class="nav-header"><h3><?php echo __('Actions'); ?></h3></li>
			<li><?php echo $this->Html->link('<i class="icon-list"></i>' . __('List Languages'), array('action' => 'index'), array('escape' => FALSE)); ?></li>
		</ul>
	</div>
</div>


<div class="span8">
	<h2><?php echo __('Language'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($language['Language']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($language['Language']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($language['Language']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Code2'); ?></dt>
		<dd>
			<?php echo h($language['Language']['code2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Website'); ?></dt>
		<dd>
			<?php echo h($language['Language']['website']); ?>
			&nbsp;
		</dd>
	</dl>
</div>


