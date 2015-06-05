<?php
	header('HTTP/1.0 403 Forbidden');
	header('Content-Type: application/json');
	echo json_encode($error);