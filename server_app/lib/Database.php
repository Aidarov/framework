<?php
	class Database {

		private $connection;

		protected $tableName = 'demo';

		protected $tablePk = 'id';

		protected $params = [];
		/**
		  * params consists of database fields
		  * each array says:
		  * 1 - field name(string)
		  *	2 - is primary(boolean)
		  * 3 - is foreign key(boolean)
		  * 4 - data type(string)
		  * 5 - is empty(boolean)
		  * 5 - defaultValue (boolean)
		  * 6 - max value(string) not for string
		  * 7 - min value(string) not for string
		  * 8 - max length(int)
		  * 9 - min length(int)
		  * 10 - regular for specific character(string)
		**/
		/*protected $params = [
			array('fieldName'=>'id', 
				  'isPk'=>true, 
				  'isFk'=>array(), 
				  'dataType'=>'int', 
				  'isEmpty'=>false,
				  'defaultValue'=>'',
				  'maxValue'=>'1000000000', 
				  'minValue'=>'0',
				  'maxLength'=>null,
				  'minLength'=>null,
				  'regular'=>'',
				  'fieldValue'=>'123'),
			array('fieldName'=>'description',
				  'isPk'=>false,
				  'isFk'=>false,
				  'dataType'=>'string',
				  'isEmpty'=>true,
				  'defaultValue'=>'hello word',
				  'maxLength'=>255,
				  'minLength'=>1,
				  'regular'=>'',
				  'fieldValue'=>''),
			array('fieldName' => 'id_child_tbl',
				  'isPk'=>false,
				  'isFk'=>array('tableName'=>'tbl2', 'columnName'=>'col2'),
				  'dataType'=>'int',
				  'isEmpty'=>false,
				  'maxValue'=>'99999999',
				  'minValue'=>'0')
		]*/

		private $servername = 'localhost';

		private $username = 'root';

		private $password = '';

		private $dbname = 'test';

		//private $valid = true;

		/*
		 *Join unit
		*/
		private $selectColumns = '';

		private $joinString = "";

		private $whereClause = '';
		
		/**********************/

		

		function __construct() {
			try {
				$this->connection = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);			    
			    $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);			    
			}
			catch(PDOException $e) {
			    echo "errm: " . $e->getMessage();
			}			

			if(sizeof($this->params) > 0) {
				$this->validate();				
			}
		}

		public function selectByPk($id) {
			$result = $this->selectExecute("SELECT * FROM $this->tableName WHERE $this->tablePk = $id");
			return $result;			
		}

		public function deleteByPk($id) {			
			$statement = $this->connection->prepare("DELETE FROM $this->tableName WHERE $this->tablePk = $id");
			$statement->execute();
			return ($statement) ? true : false;
		}

		public function updateByPk($id, $params) {
			$update_str = '';

			$tail = (sizeof($params) > 1) ? ', ' : '   ';

			foreach ($params as $key => $value) {
				$update_str .= $key.' = "'.$value.'"'.$tail;
			}

			$update_str = substr($update_str, 0, -2);
			
			$statement = $this->connection->prepare("UPDATE $this->tableName SET $update_str WHERE $this->tablePk = $id");

			$statement->execute();

			return ($statement) ? true : false;
		}

		public function insert($tableData) {
			$insert_columns = '';
			$insert_values = '';

			foreach ($tableData as $key => $value) {				
				$insert_columns .= $key.', ';
				$insert_values .= '"'.$value.'", ';				
			}

			$insert_columns = substr($insert_columns, 0, -2);
			$insert_values = substr($insert_values, 0, -2);
			
			$statement = $this->connection->prepare("INSERT INTO $this->tableName($insert_columns) VALUES($insert_values)");

			$statement->execute();

			return ($statement) ? true : false;
		}

		public function innerJoin($joinTableName, $joinClause, $whereClause = null) {
			$this->join('INNER', $joinTableName, $joinClause, $whereClause);
			return $this;
		}

		public function leftJoin($joinTableName, $joinClause, $whereClause = null) {
			$this->join('LEFT', $joinTableName, $joinClause, $whereClause);
			return $this;
		}

		public function rightJoin($joinTableName, $joinClause, $whereClause = null) {
			$this->join('RIGHT', $joinTableName, $joinClause, $whereClause);
			return $this;
		}


		private function join($joinType, $joinTableName, $joinClause, $whereClause = null) {
			
			$innerClause = "$joinType JOIN $joinTableName ON ";

			foreach ($joinClause as $key => $value) {
				$innerClause .= "$this->tableName.$key = $joinTableName.$value AND ";
			}
			
			$this->joinString .= substr($innerClause, 0, -4);			
		}

		public function execute() {			
			$result = $this->selectExecute("SELECT * FROM $this->tableName ".$this->joinString." ".$this->whereClause);
			return $result;
		}

		private function selectExecute($statement) {
			$statementExec = $this->connection->prepare($statement);			
			$statementExec->execute();
			$result = $statementExec->fetchAll();
			return $result;
		}

		protected function validate() {
			$paramDuplicate = [];
			foreach($this->params as $value) {
				$value['fieldValue'] = $this->$value['fieldName'];
				array_push($paramDuplicate, $value);
			}


			$validation = new Validation($paramDuplicate);

			$validation->checkType();
			$validation->isEmpty();
			$validation->checkMinValue();
			$validation->checkMaxValue();
			$validation->checkMinLength();
			$validation->checkRegular();

			( sizeof($validation->getErrorMessage() > 0 ) ? $this->_break($errors) : $this->_continue);
		}

		private function _break($errors) {
			print_r($errors);
			exit;
		}

		private function _continue() {
			print "Everything is ok";
			continue;
		}


	}

	      