<?php
	class Bootstrap {

		private $controller;

		function __construct() {

			$route = new Route();

			$this->config = Config::$params;

			$controllerName = $route->getControllerName();			

			$controller = file_exists(Config::$params['controllerUrl'].'/'.$controllerName.'.php') ? ucfirst(strtolower($controllerName)) : Config::$params['defaultController'];

			include_once(Config::$params['controllerUrl'].'/'.$controller.'.php');
			
			$this->controller = new $controller;

			$action = ($route->getActionName()) ? $route->getActionName() : Config::$params['defaultAction'];			

			method_exists($this->controller, $action) ? $this->controller->{$action}() : $this->controller->view('method_not_found', null, 'error');
			
		}
	}