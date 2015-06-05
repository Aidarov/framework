<?php
	class Userrole extends Controller{

		private $model;
	
		function __construct() {
			/**
			*
			* always call parent controller constructor
			*/
			parent::__construct();
			$this->model = new UserRoleModel();
		}

		function index() {
			echo $this->get['id'];
			var_dump($this->post);
			//$this->model->selectByPk();
		}

		function insert() {
			$this->model->code = 'super_user';			
			$this->model->description = 'Super User';			
			$this->model->status = 1;

			if($this->model->validate()) {
				$this->model->save();	
			} else {
				print_r($this->model->getValidationErrors());
			}			
		}

		function delete() {
			$result = false;

			if(isset($this->get['id'])) {
				$result = $this->model->deleteByPk($this->get['id']);
			}
		}

		function update() {

			$id = is_int($this->get['id']) ? $this->get['id'] : 0;

			$result = $this->model->updateByPk(
				$id,
				array(
					'code' => 'updated_code',
					'description' => 'updated desription',
					'status' => '3'
				)
			);
		}
	}