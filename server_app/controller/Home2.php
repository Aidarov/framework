<?php
	class Home2 extends Controller{
		function __construct() {
			//parent::__construct();
			print_r($this->config);
		}

		function index() {
			echo 2;
		}
	}