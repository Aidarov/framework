<?php
	class Home extends Controller{
		function __construct() {
			//parent::__construct();
			print_r($this->config);
		}

		function index() {
			$this->view('index');
		}
	}