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

		public function setSessionValue($key, $value, $lifetime = null) {
			if($this->getSessionId()) {
				$_SESSION[$key] = $value;				
			}
			else {
				$this->startSession($lifetime);
				$_SESSION[$key] = $value;
			}
		}

		public function deleteSessionValue($key) {
			unset($_SESSION[$key]);
		}

	}