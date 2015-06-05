<?php
	class Controller {

		protected $route;

		private $header;
		
		private $body;
		
		protected $config;
		protected $session;
		protected $post;
		protected $get;
		protected $userInfo;
		protected $userAccessRoleList = array();
		

		function __construct() {

			$route = new Route();

			$this->session = new Session();
			
			$this->post = ($_POST) ? $_POST : null;

			$this->get = ($_GET) ? $route->getQueryParams() : null;

			$this->config = MainConfig::$params;
			
			$this->includeModels();
			
			$this->identifyUser();
			
			$this->checkAccess();
		}

		public function view($viewName, $arguments = null, $controllerName = null) {	

			($arguments) ? extract($arguments) : $arguments;
			
			$defaultView =  $this->config['defaultView'].'.php';

			$controller = ($controllerName) ? $controllerName : get_class($this);

			$viewPath = 'server_app/view/'.strtolower($controller).'/'.$viewName.'.php';			

			$view = file_exists($viewPath) ? $viewPath : $defaultView;
			
			unset($arguments);
			unset($defaultView);
			unset($controller);
			
			include_once($view);
		}
		
		private function includeModels() {
			foreach (glob('server_app/model'.'/*.*') as $filename) {				
				include_once($filename);				
			}
		}
		
		private function checkAccess() {			
			if (in_array($this->getUserRole, $this->userAccessRoleList) || (sizeof($this->userAccessRoleList) === 0)) {
				echo 1;
			}
			else {				
				$this->view('forbidden', array('error' => array('result' => false, 'reason' => 'no_permission_to_page_'.strtolower(get_class($this)))), 'error');
				exit;
			}
			
		}
		
		private function identifyUser() {
			$model = new UserModel();
			$now =  date("Y-m-d H:i:s", time());
			$result = $model->selectWithClause(
						array('id', 'email', 'login_expire_time', 'user_role_code'), 
						array('email' => $this->session->getSessionValue('email'),
							  'session_hash' => $this->session->getSessionId()),
						$offset = 0,
						array(),
						'ASC',
						'AND login_expire_time >= now()'
					);
					
			$this->userInfo = (sizeof($result) === 1) ? $result[0] : array();
		}
		
		public function getUserRole() {
			return $this->userInfo['user_role_code'];			
		}
		
		public function getUserEmail() {
			return $this->userInfo['email'];
		}
		
		public function getUserId() {
			return $this->userInfo['id'];
		}
		
		public function getUserExpireTime() {
			return $this->userInfo['login_expire_time'];
		}
		
		public function getUserIp() {
			$ip_address = '';
			
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			    $ip_address = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
			    $ip_address = $_SERVER['REMOTE_ADDR'];
			}
			
			return $ip_address;
		}
	}