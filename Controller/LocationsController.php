<?php

App::uses('AppController', 'Controller');

/**
 * Locations Controller
 *
 * @property Location $Location
 */
class LocationsController extends ConfigurationsAppController {

	function beforeFilter() {
		parent::beforeFilter();
//		$this->Auth->deny();
		$this->Auth->allow(array('load'));
	}

//	public function isAuthorized() {
//
//		switch ($this->Auth->user('group_id')) {
//			case 1:
//			case 2:
//				return true;
//				break;
//			case 3:
//				return false;
//				break;
//			default:
//				return false;
//				break;
//		}
//	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function admin_index() {

		$this->paginate = array(
			'limit' => '20',
			//'order' => 'winner Desc, created Desc',
			//'conditions' => array('User.deleted' => '0000-00-00 00:00:00'),
		);
		$this->set('fluid', 'fluid');
		$this->Location->recursive = 2;
		$this->set('locations', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid location', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('location', $this->Location->read(null, $id));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function admin_add() {
		$locations = $this->Location->generateTreeList(null, null, null, '- ');
		$this->set(compact('locations'));

		if ($this->request->is('post')) {
			$this->Location->create();
			if ($this->Location->save($this->request->data)) {
				$this->Session->setFlash(__('The location has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The location could not be saved. Please, try again.'), 'flash/error');
			}
		}
		$parentLocations = $this->Location->ParentLocation->find('list');
		$this->set(compact('parentLocations'));
	}

	/**
	 * edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		$locations = $this->Location->generateTreeList(array("id <> $id"), null, null, '- ');
		$this->set(compact('locations'));
		$this->set('fluid', 'fluid');
		$this->Location->id = $id;
		if (!$this->Location->exists()) {
			throw new NotFoundException(__('Invalid location'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Location->save($this->request->data)) {
				$this->Session->setFlash(__('The location has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The location could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$this->request->data = $this->Location->read(null, $id);
		}
	}

	/**
	 * delete method
	 *
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Location->id = $id;
		if (!$this->Location->exists()) {
			throw new NotFoundException(__('Invalid location'));
		}
		if ($this->Location->delete()) {
			$this->Session->setFlash(__('Location deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Location was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}

	/* ---  END ADMIN --- */

	public function load($parent_id = null, $model = null, $counter = 1) {
		if (!is_numeric($parent_id) || $model == null || is_numeric($model) || !is_numeric($counter)) {
			throw new MethodNotAllowedException();
		}

		$locations = array(
			$counter => $this->Location->find('list', array(
				'fields' => array('Location.id', 'Location.name'),
				'conditions' => array(
					'Location.parent_id' => $parent_id
				)
			))
		);
		if (empty($locations[$counter])) {
			$this->autoRender = false;
		} else {
			$this->layout = false;
		}

		$this->set(compact('locations', 'model', 'counter'));
	}

}
