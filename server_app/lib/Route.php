<?php
	class Route {
		private $url;
		private $urlArray = array();
		private $controllerName;
		private $actionName;
		private $queryParams;

		function __construct () {
			$this->url = $_GET['url'];
			$this->urlArray = explode('/', $_GET['url']);			

			//controller
			$this->controllerName = (sizeof($this->urlArray) > 0) ? ucfirst($this->urlArray[0]) : null;
			//action
			$this->actionName = (sizeof($this->urlArray) > 1) ? $this->urlArray[1] : null;
			//queryParams
			$this->queryParams = $_GET;
			unset($this->queryParams['url']);			
			//$this->queryParams = (sizeof($this->urlArray) > 2) ? implode('/', array_slice($this->urlArray, 2, (sizeof($this->urlArray)) - 2)) : null;			
		}

		public function getUrl() {
			return $this->url;
		}

		public function getControllerName() {
			return $this->controllerName;
		}

		public function getActionName() {
			return $this->actionName;
		}

		public function getQueryParams() {
			return $this->queryParams;
		}

		public function getUrlArray() {
			return $this->urlArray;
		}
	}