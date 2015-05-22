<?php
	class Model extends Database{
		function __construct() {
			parent::__construct();
			foreach($this->params as $value) {
				$this->{$value['fieldName']} = isset($value['defaultValue']) ? $value['defaultValue'] : null;								
			}
		}	
	}