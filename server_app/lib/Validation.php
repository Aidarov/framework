<?php
	class Validation {
		private $params;

		private $result;

		function __construct($paramDuplicate) {
			$this->params = $paramDuplicate;
		}

		private $errorMessage = [];

		private function setErrorCode($error) {			
			array_push($this->errorMessage, $error)
		}

		public function getErrorMessage() {
			return $this->errorMessage;
		}


		public function isEmpty() {
			foreach ($this->params as $value) {
				if((!$value['isEmpty']) && (is_null($value['FieldValue']) || (trim($value['FieldValue']) === ""))) {
					array_push($this->errorMessage[$value['FieldName']], 'EMPTY_VALUE');					
				}
			}
		}

		public function checkType() {
			foreach ($this->params as $value) {
				if()
			}
		}

		protected function isDefault($columnName) {

		}

		protected function isPk($columnName, ) {

		}

	}