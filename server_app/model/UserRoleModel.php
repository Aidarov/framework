<?php
	class UserRoleModel extends Model {
		public function __construct() {
			parent::__construct();			
		}

		protected $tableName = 'user_role';

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
				  'fieldValue'=>''),
			array('fieldName'=>'code',
				  'isPk'=>false,
				  'isFk'=>false,
				  'dataType'=>'string',
				  'isEmpty'=>false,				  
				  'maxLength'=>20,
				  'minLength'=>null,
				  'regular'=>null,
				  'fieldValue'=>''),
			array('fieldName'=>'description',
				  'isPk'=>false,
				  'isFk'=>false,
				  'dataType'=>'string',
				  'isEmpty'=>false,				  
				  'maxLength'=>40,
				  'minLength'=>null,
				  'regular'=>null,
				  'fieldValue'=>''),
			array('fieldName'=>'status',
				  'isPk'=>false,
				  'isFk'=>array(),
				  'dataType'=>'integer',
				  'isEmpty'=>false,
				  'maxValue'=>1,
				  'minValue'=>0,
				  'fieldValue'=>'',
				  'defaultValue'=>1)
		);

	}