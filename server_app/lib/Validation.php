<?php
	class Validation {
		private $params;

		private $result;

		function __construct($paramDuplicate) {
			$this->params = $paramDuplicate;
		}

		private $errorMessage = array();

		private function setErrorCode($error) {			
			array_push($this->errorMessage, $error)
		}

		public function getErrorMessage() {
			return $this->errorMessage;
		}


		public function isEmpty() {
			foreach ($this->params as $value) {
				if((!$value['isEmpty']) && (is_null($value['fieldValue']) || (trim($value['fieldValue']) === ""))) {
					array_push($this->errorMessage[$value['fieldName']], 'empty_value');					
				}
			}
		}

		public function checkType() {
			foreach ($this->params as $value) {
				switch(strtolower($value['dataType'])) {
					case 'date':
					case 'string':
						if(!is_string($value['fieldValue']) && !is_null($value['fieldValue'])) {
							array_push($this->errorMessage[$value['fieldName']], 'incompatible_type');
						}
						break;
					case 'timestamp':
					case 'integer':
						if(!is_int($value['fieldValue']) && !is_null($value['fieldValue'])) {
							array_push($this->errorMessage[$value['fieldName']], 'incompatible_type');
						}
						break;
					case 'double':
						if(!is_double($value['fieldValue']) && !is_null($value['fieldValue'])) {
							array_push($this->errorMessage[$value['fieldName']], 'incompatible_type');
						}
						break;
					default:
						array_push($this->errorMessage[$value['fieldName']], 'undefined_type');
						break;						
				}
			}
		}

		public function checkMinValue() {
			foreach ($this->params as $value) {
				switch(strtolower($value['dataType'])) {
					case 'date':
						if($value['minValue']) {
							if(strtotime($value['fieldValue']) <= strtotime($value['minValue'])) {
								array_push($this->errorMessage[$value['fieldName']], 'requires_bigger_value');
							}
						}
						break;
					case 'timestamp':
					case 'integer':
					case 'double':
						if($value['fieldValue'] <= $value['minValue']) {
							array_push($this->errorMessage[$value['fieldName']], 'requires_bigger_value');
						}
						break;
					default:
						array_push($this->errorMessage[$value['fieldName']], 'undefined_value');
						break;						
				}
			}
		}
		
		public function checkMaxValue() {
			foreach ($this->params as $value) {
				switch(strtolower($value['dataType'])) {
					case 'date':
						if($value['minValue']) {
							if(strtotime($value['fieldValue']) >= strtotime($value['minValue'])) {
								array_push($this->errorMessage[$value['fieldName']], 'requires_smaller_value');
							}
						}
						break;
					case 'timestamp':
					case 'integer':
					case 'double':
						if($value['fieldValue'] >= $value['minValue']) {
							array_push($this->errorMessage[$value['fieldName']], 'requires_smaller_value');
						}
						break;
					default:
						array_push($this->errorMessage[$value['fieldName']], 'undefined_value');
						break;						
				}
			}
		}
		
		public function checkMinLength() {
			foreach ($this->params as $value) {
				switch(strtolower($value['dataType'])) {
					case 'string':
						if($value['minValue']) {
							if(strtotime($value['fieldValue']) >= strtotime($value['minValue'])) {
								array_push($this->errorMessage[$value['fieldName']], 'requires_smaller_value');
							}
						}
						break;
					case 'timestamp':
					case 'integer':
					case 'double':
						if($value['fieldValue'] >= $value['minValue']) {
							array_push($this->errorMessage[$value['fieldName']], 'requires_smaller_value');
						}
						break;
					default:
						array_push($this->errorMessage[$value['fieldName']], 'undefined_type');
						break;						
				}
			}
		}
		
		public function checkMaxLength() {
		
		}
		

	}