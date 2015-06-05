<?php
	class GenreModel extends Model {
		public function __construct() {
			parent::__construct();			
		}

		protected $tableName = 'user';

		protected $tablePk = 'id';

		protected $params = array(
			array('fieldName'=>'id', 
				  'isPk'=>true, 
				  'isFk'=>false, 
				  'dataType'=>'integer', 
				  'isEmpty'=>true,				  
				  'maxValue'=>null, 
				  'minValue'=>null,			  
				  'fieldValue'=>''),
			array('fieldName'=>'code',
				  'isPk'=>false,
				  'isFk'=>false,
				  'dataType'=>'string',
				  'isEmpty'=>false,				  
				  'maxLength'=>50,
				  'minLength'=>0,				  
				  'fieldValue'=>''),
			array('fieldName'=>'description',
				  'isPk'=>false,
				  'isFk'=>false,
				  'dataType'=>'string',
				  'isEmpty'=>false,				  
				  'maxLength'=>50,
				  'minLength'=>0,
				  'regular'=>null,
				  'fieldValue'=>'',
				  'confirmValue'=>''),
			array('fieldName'=>'status',
				  'isPk'=>false,
				  'isFk'=>false,
				  'dataType'=>'integer',
				  'isEmpty'=>true,
				  'maxValue'=>10,
				  'minValue'=>null,
				  'fieldValue'=>'')
		);
		
		

	}