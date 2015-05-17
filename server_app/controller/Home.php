<?php
	class Home extends Controller{
	
		function __construct() {
			/**
			*
			* always call parent controller constructor
			*/
			parent::__construct();			
		}

		function index() {
			$authModel = new Auth();
			
			$authModel->code ='kunya1';
			$authModel->descr = 'description';
			if($authModel->validate()) {
				$authModel->save();			
			} else {
				print_r($authModel->getValidationErrors());
			}
			
			
			
			$this->view('index', array('controlle'=>'home'));
		}
	}