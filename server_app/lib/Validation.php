<?php
	class Validation {
		private $params = array();

		private $result;

		function __construct($paramDuplicate) {			
			$this->params = $paramDuplicate;		
		}

		private $errorMessage = array();

		private function setErrorCode($errorName, $errorMessage) {
			if(array_key_exists($errorName, $this->errorMessage)) {
				array_push($this->errorMessage[$errorName], $errorMessage);
			}
			else {				
				$this->errorMessage[$errorName] = array();
				array_push($this->errorMessage[$errorName], $errorMessage);
			}			
		}

		public function getErrorCode() {			
			return $this->errorMessage;
		}

		public function isEmpty() {
			foreach ($this->params as $value) {
				if((!$value['isEmpty']) && (is_null($value['fieldValue']) || (trim($value['fieldValue']) === ""))) {					
					$this->setErrorCode($value['fieldName'], 'empty_value');
				}
			}
		}

		public function checkType() {
			foreach ($this->params as $value) {
				switch(strtolower($value['dataType'])) {
					case 'date':
					case 'string':
						if(!is_string($value['fieldValue']) && !is_null($value['fieldValue'])) {							
							$this->setErrorCode($value['fieldName'], 'incompatible_type');
						}
						break;
					case 'timestamp':
					case 'integer':
						if(!is_int($value['fieldValue']) && !is_null($value['fieldValue'])) {							
							$this->setErrorCode($value['fieldName'], 'incompatible_type');
						}
						break;
					case 'double':
						if(!is_double($value['fieldValue']) && !is_null($value['fieldValue'])) {							
							$this->setErrorCode($value['fieldName'], 'incompatible_type');
						}
					case 'json':
						if (!is_object(json_decode($value['fieldValue']))) {
							$this->setErrorCode($value['fieldName'], 'incompatible_type');
						}
						break;
				}
			}
		}
		
		
		/**
		* Check for min value
		*
		*
		*
		*
		*
		*/
		public function checkMinValue() {
			foreach ($this->params as $value) {
				switch(strtolower($value['dataType'])) {
					case 'date':
						if($value['minValue']) {
							if(strtotime($value['fieldValue']) < strtotime($value['minValue'])) {								
								$this->setErrorCode($value['fieldName'], 'requires_bigger_value');
							}
						}
						break;
					case 'timestamp':
					case 'integer':
					case 'double':
						if($value['minValue']) {
							if($value['fieldValue'] < $value['minValue']) {								
								$this->setErrorCode($value['fieldName'], 'requires_bigger_value');
							}
						}
						break;			
				}
			}
		}
		
		
		/**
		* Check for max value
		*
		*
		*
		*
		*
		*/
		public function checkMaxValue() {
			foreach ($this->params as $value) {
				switch(strtolower($value['dataType'])) {
					case 'date':						
						if(!is_null($value['maxValue']) && (strtotime($value['fieldValue']) > strtotime($value['maxValue']))) {							
							$this->setErrorCode($value['fieldName'], 'requires_smaller_value');
						}						
						break;
					case 'timestamp':
					case 'integer':
					case 'double':
						if(!is_null($value['maxValue']) && ($value['fieldValue'] > $value['maxValue'])) {							
							$this->setErrorCode($value['fieldName'], 'requires_smaller_value');
						}
						break;			
				}
			}
		}
		
		
		/**
		* Check for min length
		*
		*
		*
		*
		*
		*/
		public function checkMinLength() {
			foreach ($this->params as $value) {				
				switch(strtolower($value['dataType'])) {
					case 'string':						
						if($value['minLength']) {
							if(strlen($value['fieldValue']) < $value['minLength']) {								
								$this->setErrorCode($value['fieldName'], 'requires_bigger_length');
							}
						}
						break;			
				}
			}
		}
		
		
		/**
		* Check for max length
		*
		*
		*
		*
		*
		*
		*/
		public function checkMaxLength() {
			foreach ($this->params as $value) {
				switch(strtolower($value['dataType'])) {
					case 'string':						
						if($value['maxLength']) {
							if(strlen($value['fieldValue']) > $value['maxLength']) {								
								$this->setErrorCode($value['fieldName'], 'requires_smaller_length');
							}
						}
						break;		
				}
			}
		}
		
		
		/**
		* Check for regular expression
		*
		*
		*
		*
		*
		*
		*/
		public function checkForRegExp() {
			foreach ($this->params as $value) {
				switch(strtolower($value['dataType'])) {
					case 'string':						
						if(!is_null($value['regular']) && !@preg_match($value['regular'], $value['fieldValue'])) {					
							$this->setErrorCode($value['fieldName'], 'no_passed_from_regex');
						}
					break;		
				}				
			}
		}

		public function isEqualTwoPassword() {			
			foreach ($this->params as $value) {
				if(!is_null($value['confirm']) && ($value['confirm'] !== "") && ($value['fieldValue'] !== $value['confirm'])) {
					$this->setErrorCode($value['fieldName'], 'password_not_match');					
				}
			}
		}
		

	}