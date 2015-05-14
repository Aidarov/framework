<?php
	class Controller {

		protected $route;

		private $header;
		
		private $body;
		
		protected $config;
		protected $session;
		protected $post;
		protected $get;

		function __construct() {

			$route = new Route();

			$this->session = new Session();
			
			$this->post = ($_POST) ? $_POST : null;

			$this->get = ($_GET) ? $_GET : null;

			$this->config = MainConfig::$params;

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
	}