<?php
	class Auth extends Model{
		public function __construct() {
			parent::__construct();			
		}
		
		protected $tableName = 'auth';
		
		protected $tablePk = 'id';
		
		protected $params = array(
			array('fieldName'=>'id', 
				  'isPk'=>true, 
				  'isFk'=>array(), 
				  'dataType'=>'integer', 
				  'isEmpty'=>true,				  
				  'maxValue'=>null, 
				  'minValue'=>null,
				  'maxLength'=>null,
				  'minLength'=>null,
				  'regular'=>null,
				  'fieldValue'=>''),
			array('fieldName'=>'code',
				  'isPk'=>false,
				  'isFk'=>false,
				  'dataType'=>'string',
				  'isEmpty'=>false,				  
				  'maxLength'=>6,
				  'minLength'=>0,
				  'regular'=>null,
				  'fieldValue'=>''),
			array('fieldName'=>'descr',
				  'isPk'=>false,
				  'isFk'=>false,
				  'dataType'=>'string',
				  'isEmpty'=>true,				  
				  'maxLength'=>null,
				  'minLength'=>null,
				  'regular'=>null,
				  'fieldValue'=>'')
		);
	}