<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true"></script>
<?php echo $this->Html->script(array($this->plugin.'.maps',$this->plugin.'main_2')); ?>
<div class="span3 well ">
	<ul class="nav nav-list">
		<li class="nav-header"><?php echo __('Actions'); ?></li>
		<li><?php echo $this->Html->link('<i class="icon-list"></i>' . __('List Locations'), array('action' => 'index'), array('escape' => FALSE)); ?></li>
	</ul>
</div>
<div class="span8 admin_options">
	<div class="span3">
		<?php echo $this->Form->create('Location'); ?>
		<fieldset>
			<legend><?php echo __('Edit Location'); ?></legend>
			<?php
			echo $this->Form->input('id');
			echo $this->Form->input('parent_id', array('empty' => true, 'options' => $locations));
			echo $this->Form->input('name');
			echo '<span>De clic sobre el marcador en el mapa para editar la latitud y longitud.</span>';
			echo '<span>' . $this->Html->image('http://www.google.com/intl/en_us/mapfiles/ms/micons/red-dot.png', array('alt' => 'Marcador Rojo')) . '</span>';
			echo $this->Form->input('latitude', array('type' => 'text', 'class' => 'latitude','readonly' => 'readonly'));
			echo $this->Form->input('longitude', array('type' => 'text', 'class' => 'longitude', 'readonly' => 'readonly'));
			echo $this->Form->input('is_capital');
			echo $this->Form->input('is_node');
			?>
		</fieldset>
		<?php echo $this->Form->end(array('label' => __('Edit'), 'class' => 'btn btn-primary')); ?>
	</div>
	<div class="span9">
		<div id="map_canvas" style="width:100%; height:475px" ><script type="text/javascript">initialize();</script></div>
	</div>
</div>
