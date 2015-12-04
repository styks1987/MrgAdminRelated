<?php
App::uses('AppController', 'Controller');
/**
 * SalvageDrivetrains Controller
 *
 * @property SalvageDrivetrain $SalvageDrivetrain
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class MrgAdminRelationsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'RequestHandler');

	/**
	 * This will import the model needed and delete the appropriate entry
	 *
	 * Date Added: Mon, Mar 24, 2014
	 */

	public function admin_delete($model = null, $id = null) {
		if($this->request->is('ajax')){
			if(App::import('Model', $model)){
				$this->$model = new $model();
				if (!$this->$model->hasAny(['id'=>$id])) {
					echo json_encode(['status'=>0, 'message'=>'We could not find that item.']);
					exit;
				}
				$this->request->onlyAllow('post', 'delete');
				if ($this->$model->delete($id)) {
					echo json_encode(['status'=>1, 'message'=>'The item has been deleted']);
					exit;
				}
				echo json_encode(['status'=>1, 'message'=>'We could not delete the item.']);
					exit;
			}else{
				echo json_encode(['status'=>0, 'message'=>'We could not load that model.']);
			}
		}
		exit;
	}}
