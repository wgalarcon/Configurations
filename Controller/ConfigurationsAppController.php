<?php

App::uses('AppController', 'Controller');

class ConfigurationsAppController extends AppController {
	public function beforeFilter() {
		parent::beforeFilter();
		if(Configure::read('debug') > 1) {
			$this->Auth->allow();
		}
	}
}
