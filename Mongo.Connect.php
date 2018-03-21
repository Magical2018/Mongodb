<?php
/*
* Mongodb 数据库连接  适配器
*/
namespace MongoDBserver;

include "Mongo.interface.php";
include "Mongo.PHP7down.php";
include "Mongo.PHP7up.php";


class Mongo implements DBface {
		
		private $dbPort = "mongodb://localhost:27017";
		
		protected $child_mongo;
		
		private $php_versions;
		
		
		
		function __construct(){
				 
				 $this->php_versions = substr(PHP_VERSION,0,1);
				 
			     $this->create_connect($this->dbPort);
				 
				 
				 
		}
		
		public function create_connect($dbPort){
				
				
				if($this->php_versions>=7){
					
					$this->MondbObject = new PHP7up($dbPort,function($fatherMongo){
						  $this->child_mongo = $fatherMongo;
					});
					
				}else{
					
					$this->MondbObject = new PHP7down($dbPort,function($fatherMongo){
						
						  $this->child_mongo = $fatherMongo;
						  
					});
					
				}	
				
		}
		
		public function __call(string $fname,array $arguments){
				//var_dump(func_get_args());
				return $this->MondbObject->$fname($arguments);
				
			
		}
		
			
		
	
}

echo "<pre>";

$M = new Mongo();

//$id = $M->setCollection('2')->add();

//var_dump($id);



$M->setCollection('2')->findAll(); 

$M->setCollection('2')->update(); 

$M->setCollection('2')->del();





