<?php
	class User extends Controller{

		private $model;
	
		function __construct() {
			/**
			*
			* always call parent controller constructor
			*/
			parent::__construct();	
			$this->model = new UserModel();
		}

		function index() {
			echo 'index';
		}

		function insert() {			
			$this->model->email = 'sabit91@mail.ru';
			$this->model->password = 'e8358c9cf215cf24afbaacb0408f7cfefa2989f48c2bf654e990470e6d9a3178';
			$this->model->about = '{}';
			$this->model->status = 0;
			$this->model->user_role_code = 'super_user';
			$this->model->registration_date = date("Y-m-d H:i:s", time());
			$this->model->confirm_hash = 'c03f006ce118530d22ab5841b60770d9d6c6f2e67e1a6ae2847c3930c58d50f1';
			$this->model->session_hash = 'c03f006ce118530d22ab5841b60770d9d6c6f2e67e1a6ae2847c3930c58d50f1';
			$this->model->ip_address = '10.20.3.78';
			$this->model->login_expire_time = '';
			if($this->model->validate()) {
				$this->model->save();
			}
			else {
				print_r($this->model->getValidationErrors());
			}
		}

		function delete() {
			echo 'delete';
		}

		function update() {
			echo 'update';
		}
	}