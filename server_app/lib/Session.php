<?php
	class Session {
		
		function __construct() {			
			//$session_id = $this->startSession();
		}

		public function getSessionId() {
			return session_id();
		}

		public function stopSession() {			
			session_destroy();
		}

		public function startSession($lifetime = null) {
			$lifetime = ($lifetime) ? $lifetime : MainConfig::$params['session']['lifeTimeMin'];			
			session_set_cookie_params($lifetime,"/");
			session_start();
		}

		public function setSessionValue($key, $value) {			
			$_SESSION[$key] = $value;			
		}
		
		public function getSessionValue($key) {
			return $_SESSION[$key];
		}

		public function deleteSessionValue($key) {
			unset($_SESSION[$key]);
		}

	}