<?php
/*
* Mongodb 数据库连接
*/
namespace MongoDBserver;

class PHP7down implements DBface{
			
			protected $mongo;
			
			public function __construct($dbPort,$callback){
				
				   $this->mongo = $this->create_connect($dbPort);
				   
				   $callback($this->mongo);
			}
			
			
			public function create_connect($dbPort){
					
				    $mongo = new \MongoClient(); // 连接默认主机和端口为：mongodb://localhost:27017
					if(!mongo){
						trigger_error(__CLASS__." connect error");exit();
					}
					return $mongo;
				
			}
}

