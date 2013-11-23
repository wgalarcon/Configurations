<?php

App::uses('AccountsAppModel', 'Accounts.Model');

/**
 * Location Model
 *
 * @property Location $ParentLocation
 * @property Location $ChildLocation
 * @property User $User
 */
class Location extends ConfigurationsAppModel {

	public $name = 'Location';
	public $actsAs = array('Tree');

	public $sequence = "loc_sq";

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			//'message' => 'Your custom message here',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_capital' => array(
			'boolean' => array(
				'rule' => array('boolean'),
			//'message' => 'Your custom message here',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_node' => array(
			'boolean' => array(
				'rule' => array('boolean'),
			//'message' => 'Your custom message here',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'ParentLocation' => array(
			'className' => 'Location',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'Profile' => array(
			'className' => 'Profile',
			'foreignKey' => 'location_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ChildLocation' => array(
			'className' => 'Location',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public function sections(array $locations = null) {
		if ($locations == null || !is_array($locations) || empty($locations)) {
			return false;
		}
		$this->recursive = -1;
		$result = array();
		foreach ($locations as $key => $value) {
			if ($key == 0) {
				$result[] = $this->ParentLocation->find('list', array(
					'fields' => array('ParentLocation.id', 'ParentLocation.name'),
					'conditions' => array(
						'ParentLocation.parent_id' => null
					)
				));
			} else {
				$result[] = $this->ParentLocation->find('list', array(
					'fields' => array('ParentLocation.id', 'ParentLocation.name'),
					'conditions' => array(
						'ParentLocation.parent_id' => $locations[($key - 1)]
					)
				));
			}
		}
		return $result;
	}

	public function load_parent($location_id, $with_sections = false, $counter = 0) {
		$this->recursive = -1;
		$result = array();
		$data_begin = $this->find('first', array(
			'fields' => array('Location.id', 'Location.parent_id'),
			'conditions' => array(
				'Location.id' => $location_id,
			)
		));

		$result[$counter] = $data_begin['Location']['id'];
		if ($data_begin['Location']['parent_id'] !== null) {
			$result = array_merge($result, $this->load_parent($data_begin['Location']['parent_id'], false, $counter + 1));
		}

		if ($with_sections) {
			return $this->sections($result);
//			return $result;
		} else {
			return $result;
		}
	}

}
