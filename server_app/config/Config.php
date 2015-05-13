<?php
	class Config {

		public static $params = array(
			'baseUrl' => 'localhost/sport',
			'controllerUrl' => 'server_app/controller',
			'appUrl'=>'server_app',
			'defaultController' => 'Home',
			'defaultAction' => 'index',
			'defaultView'=>'server_app/view/error/index',
			'errorController' => 'Error',
			'session' => array(
					'lifeTimeMin' => '300',
					'lifeTimeMax' => '86400'
				),
			'database' => array(
					'servername' => 'localhost',
					'username' => 'root',
					'password' => 'password',
					'dbname' => 'dbname'
				),
			'langs' => array(
					'all' => ['KAZ', 'RUS', 'ENG'],
					'default' => 'KAZ'
				)
		);
	}