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

			$fullname 	= $this->post['fullname'];
			$address 	= $this->post['address'];
			$phone 		= $this->post['phone'];
			$gender 	= $this->post['gender'];
			$about 		= json_encode(array('fullname' 	=> $fullname,
											'address'	=> $address,
											'phone'		=> $phone,
											'gender'	=> $gender));

			$email				= $this->post['email'];
			$password			= $this->get['password'];
			$confirm_password	= $this->get['confirm_password'];
			$user_role 			= $this->post['user_role'];
			$registration_date 	= date("Y-m-d H:i:s", time());
			$confirm_hash 		= hash('sha256', $this->post['email'].time());
			$session_hash 		= hash('sha256', $this->post['email'].time());
			$ip_address			= null;

			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			    $ip_address = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
			    $ip_address = $_SERVER['REMOTE_ADDR'];
			}
			

			$this->model->email 			= $email;
			$this->model->password 			= $password;
			$this->model->about 			= $about;
			$this->model->status 			= 0;
			$this->model->user_role_code 	= $user_role;
			$this->model->registration_date = $registration_date;
			$this->model->confirm_hash 		= $confirm_hash;
			$this->model->session_hash 		= $session_hash;
			$this->model->ip_address 		= $ip_address;
			$this->model->login_expire_time = '';

			$this->model->setPasswordVerify('password', $confirm_password);

			if($this->model->validate()) {
				$this->password = hash('sha256', $password);
				$this->model->save();
			}
			else {
				print_r($this->model->getValidationErrors());
			}
		}

		public function delete() {
			$id = $this->post['id'];
			$result = $this->deleteByPk($id);			
		}

		public function update() {
			$id 	= $this->post['id'];

			$about 	= json_encode(array('fullname' 	=> $fullname,
										'address'	=> $address,
										'phone'		=> $phone,
										'gender'	=> $gender));

			$params = array('email' 			=> $this->post['id'],
							'about'				=> $about,
							'status' 			=> $this->post['status'],
							'user_role_code'	=> $this->post['user_role']
							);

			$result = $this->updateByPk($id, $params);			
		}
		
		public function login() {
			$login = 
		}

		public function logout() {

		}

	}