<?php
	class Database {

		private $connection;

		protected $tableName;

		protected $tablePk;	
		
		protected $limit = 10;

		protected $params = array();
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

		private $servername;

		private $username;

		private $password_db;

		private $dbname;
		
		private $validation;		
		
		

		/*
		 *Join unit
		*/
		private $selectColumns = '';

		private $joinString = "";

		private $whereClause = '';
		
		/**********************/

		

		function __construct() {
			try {
			
				$this->servername = MainConfig::$params['database']['servername'];
				$this->username = MainConfig::$params['database']['username'];
				$this->password_db = MainConfig::$params['database']['password'];
				$this->dbname = MainConfig::$params['database']['dbname'];				

				$this->connection = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password_db);			    
			    $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);			    
			}
			catch(PDOException $e) {
			    echo "errm: " . $e->getMessage();
			}
		}

		public function selectByPk($id) {			
			$statement = $this->connection->prepare("SELECT * FROM $this->tableName WHERE $this->tablePk = :id");
			$statement->execute(array('id' => $id));
			$result = $statement->fetchAll();
			return $result;			
		}

		public function deleteByPk($id) {			
			$statement = $this->connection->prepare("DELETE FROM $this->tableName WHERE $this->tablePk = :id");
			$statement->execute(array('id' => $id));
			return ($statement->rowCount() > 0) ? true : false;
		}

		public function updateByPk($id, $params) {
			$update_str = '';

			$tail = (sizeof($params) > 1) ? ', ' : '   ';

			foreach ($params as $key => $value) {
				$update_str .= $key.' = "'.mysql_real_escape_string($value).'"'.$tail;
			}

			$update_str = substr($update_str, 0, -2);
			
			$statement = $this->connection->prepare("UPDATE $this->tableName SET $update_str WHERE $this->tablePk = :id");

			$statement->execute(array('id' => $id));

			return ($statement->rowCount() > 0) ? true : false;
		}
		
		public function updateByClause($params, $whereClause, $tableName = null) {
			$update_str = '';
			$whereCondition = '';
			$tableName = is_null($tableName) ? $this->tableName : $tableName;

			$tail = (sizeof($params) > 1) ? ', ' : '   ';

			foreach ($params as $key => $value) {
				$update_str .= $key.' = "'.mysql_real_escape_string($value).'"'.$tail;
			}
			
			if(sizeof($whereClause) > 0) {
				
				foreach($whereClause as $key => $value) {
					$whereCondition .= ' '.mysql_real_escape_string($key).' = "'.mysql_real_escape_string($value).'" AND ';
				}
				
				$whereCondition = 'WHERE '.substr($whereCondition, 0, -4);
			}

			$update_str = substr($update_str, 0, -2);
			
			echo "UPDATE $tableName SET $update_str $whereCondition";
			
			$statement = $this->connection->prepare("UPDATE $tableName SET $update_str $whereCondition");

			$statement->execute();

			return ($statement->rowCount() > 0) ? true : false;
		}
		

		public function insert($tableData) {
			$insert_columns = '';
			$insert_values = '';

			foreach ($tableData as $key => $value) {				
				$insert_columns .= $key.', ';
				$insert_values .= '"'.mysql_real_escape_string($value).'", ';				
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

		public function validate() {
		
			$paramDuplicate = array();
			
			foreach($this->params as $value) {
				$value['fieldValue'] = $this->{$value['fieldName']};
				array_push($paramDuplicate, $value);
			}

			$this->validation = new Validation($paramDuplicate);

			$this->validation->checkType();
			$this->validation->isEmpty();
			$this->validation->checkMinValue();
			$this->validation->checkMaxValue();
			$this->validation->checkMinLength();
			$this->validation->checkMaxLength();
			$this->validation->checkForRegExp();
			
			return (sizeof($this->validation->getErrorCode()) > 0 ) ? false : true ;
		}
		
		public function getValidationErrors() {
			return $this->validation->getErrorCode();
		}
		
		public function save() {
			$modelObjects = array();
			foreach($this->params as $value) {
				$modelObjects[$value['fieldName']] = $this->{$value['fieldName']};					
			}			
			$this->insert($modelObjects);
			
			return $this->getPdoErrorMessage();
			
		}		
		
		public function getPdoErrorMessage() {
			return $this->connection->errorInfo();
		}
		
		public function selectWithClause($columnName, $whereClause, $offset, $orderParam, $orderAscDesc) {
		
			$columns 		= '';
			$whereCondition = '';
			$orderByClause 	= '';
			$limitClause;
			
			if(is_array($columnName) && is_array($whereClause) && is_int($offset) && !is_null($offset) && is_array($orderParam) && ($orderAscDesc === 'ASC' || $orderAscDesc === 'DESC')) {
			
				if(sizeof($columnName) > 0) {					
					
					foreach($columnName as $column) {
						$columns .= ' '.$column.', ';
					}
					
					$columns = substr($columns, 0, -2);
				}
				
				if(sizeof($whereClause) > 0) {
				
					foreach($whereClause as $key => $value) {
						$whereCondition .= ' '.mysql_real_escape_string($key).' = "'.mysql_real_escape_string($value).'" AND ';
					}
					
					$whereCondition = 'WHERE '.substr($whereCondition, 0, -4);
				}
				
				if(sizeof($orderParam) > 0) {
				
					foreach($orderParam as $param) {
						$orderByClause .=  $param.', ';
					}
					
					$orderByClause = substr($orderByClause, 0, -2);
					
					$orderByClause = 'ORDER BY '.$orderByClause.' '.$orderAscDesc;
				}
				
				$limitClause = 'LIMIT '.$offset.', '.$this->limit;			
				
				$result = $this->selectExecute("SELECT $columns FROM $this->tableName $whereCondition $limitClause");
				
				return $result;
			}
			else {
				return null;
			}
		}
	}      