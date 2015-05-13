<?php
	class ParentClass {

		

		function __construct() {
			print 'this parent constructor';			
			exit;
		}

		public function inherit($obj = null) {
			print $this->prop;
		}
	}