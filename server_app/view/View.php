<?php
	class View {
		function __construct() {

		}

		public static function xmlHeader() {
			return header('Content-Type: text/xml');
		}

		public static function jsonHeader() {
			return header('Content-Type: application/json');
		}

	}