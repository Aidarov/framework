<?php
	class User extends Controller{

		private $model;
	
		public function __construct() {
			/**
			*
			* always call parent controller constructor
			*/
			parent::__construct();	
			$this->model = new UserModel();
		}

		public function index() {
			echo 'index';
		}

		public function insert() {			
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

		public function delete() {
			echo 'delete';
		}

		public function update() {
			echo 'update';
		}
		
		public function login() {
		
			$this->session->startSession();
			
			$email = $this->post['email'];
			$password = hash('sha256', $this->post['password']);
			$offset = $this->get['offset'];
			$session_hash = $this->session->getSessionId();			
			$passwordExpireTime = ($this->get['savePassword'] === '1') ? $this->config['session']['lifeTimeMax'] : $this->config['session']['lifeTimeMin'];
			
			$ip_address = '';
			
			
			
			
			
			/*$result = $this->model->selectWithClause(
						array('id', 'email'), 
						array('email' => 'sabit91@mail.ru',
							  'password' => 'e8358c9cf215cf24afbaacb0408f7cfefa2989f48c2bf654e990470e6d9a3178'),
						$offset = 0,
						array(),
						'ASC'
					);*/
			
			$result = $this->model->updateByClause(
					array(
						'session_hash' 		=> $session_hash,
						'ip_address' 		=> $ip_address,
						'login_expire_time'	=> date("Y-m-d H:i:s", strtotime("+$passwordExpireTime seconds"))
					),
					array(
						'email' => $email,
						'password' => $password
					)
				);
		}
		
		public function isLoggedIn() {
			
		}
		
		public function logout() {
		
		}
	}