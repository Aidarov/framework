<?php
	class Bootstrap {

		private $controller;

		function __construct() {

			$route = new Route();

			$this->config = MainConfig::$params;

			$controllerName = $route->getControllerName();			

			$controller = file_exists(MainConfig::$params['controllerUrl'].'/'.$controllerName.'.php') ? ucfirst(strtolower($controllerName)) : MainConfig::$params['defaultController'];

			include_once(MainConfig::$params['controllerUrl'].'/'.$controller.'.php');
			
			$this->controller = new $controller;

			$action = ($route->getActionName()) ? $route->getActionName() : MainConfig::$params['defaultAction'];			

			method_exists($this->controller, $action) ? $this->controller->{$action}() : $this->controller->view('method_not_found', null, 'error');
			
		}
	}