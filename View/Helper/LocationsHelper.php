<?php

App::uses('AppHelper', 'View/Helper');

/**
 * Description of LocationsHelper
 *
 * @author developer02
 */
class LocationsHelper extends AppHelper {

	public $helpers = array('Html', 'Session', 'Paginator', 'Js' => array('Jquery'), 'Form', 'Time');

	public function input($model_local = null, array $locations = null, $counter = 0) {

		if (isset($this->request->data[$model_local]['location_id']) && is_array($this->request->data[$model_local]['location_id'])) {
			$input_locations = 'empty';
			krsort($this->request->data[$model_local]['location_id']);
			foreach ($this->request->data[$model_local]['location_id'] as $key => $value) {
				$input_locations = $this->print_input($model_local, $locations, $key, $value, $input_locations);
			}
			return $input_locations;
		} else {
			return $this->print_input($model_local, $locations, $counter);
		}
	}

	private function print_input($model_local = null, array $locations = null, $counter = 0, $value = '', $loop = 'empty') {
		$id = rand(0, 999999);
		$locations_name = array(
			0 => __('Country'),
			1 => __('State'),
			2 => __('City'),
		);

		$script = '
			$("#location_' . $id . '").bind("change",function(){
				var field = $(this);
				if(field.find("option:selected").val() !== ""){
					var loading = $("' . addslashes($this->Html->image('../configurations/img/loading.gif')) . '");
					field.after(loading);
					var location = field.find("option:selected").val()+"/' . $model_local . '/' . ($counter + 1) . '";
					$.ajax({
						url:"' . $this->Html->url(array('plugin' => 'configurations', 'controller' => 'locations', 'action' => 'load', 'admin' => false)) . '/"+location,
			//			dataType:"html",
						type:"POST",
						success:function (data, textStatus) {
							$("#location_' . $counter . '").html(data);
							loading.remove();
						}
					});
				}else{
					$("#location_' . $counter . '").html("");
				}

			});
		';

		$this->Js->buffer($script, true);
		if ($loop === 'empty') {

			if (isset($locations_name[$counter])) {
				$label = $locations_name[$counter];
			} else {
				$label = __('Location');
			}

			return
				'<div >
				<label for="location_' . $label . '">' . $label . '</label>' .
				$this->Form->input($model_local . '.location_id.', array(
					'after' => $this->Form->error($model_local . '.location_id'),
					'id' => 'location_' . $id,
					'empty' => __('Select'),
					'value' => $value,
					'options' => $locations[$counter],
//				'label'		=> (isset($locations_name[$counter])) ? $locations_name[$counter] : __('Location')
					'label' => false,
					'required'=>false
				)) . '<div id="location_' . $counter . '"></div></div>';
		} else {

			if (isset($locations_name[$counter])) {
				$label = $locations_name[$counter];
			} else {
				$label = __('Location');
			}

			return
				'<div >
				<label for="location_' . $label . '">' . $label . '</label>' .
				$this->Form->input($model_local . '.location_id.', array(
					'id' => 'location_' . $id,
					'empty' => __('Select'),
					'value' => $value,
					'options' => $locations[$counter],
//				'label'		=> (isset($locations_name[$counter])) ? $locations_name[$counter] : __('Location')
					'label' => false,
					'required'=>false
				)) . '<div id="location_' . $counter . '">' . $loop . '</div></div>';
		}
	}

}