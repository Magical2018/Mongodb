<?php
/*
* Mongodb 数据库连接
*/
namespace MongoDBserver;
class PHP7up  implements DBface{
			
			protected $mongo,$Collection;
			
			public function __construct($dbPort,$callback){
				
					$this->mongo = $this->create_connect($dbPort);
					
					$callback($this->mongo);
			}
			
			public function create_connect($dbPort){
					
					$mongo = new \MongoDB\Driver\Manager($dbPort);
					if(!$mongo){
						trigger_error(__CLASS__." connect error");exit();
					}
					return $mongo;
			
			}
			
			public function setCollection($name){
				
					$this->Collection = 'test.runoob1';
					
					
					return $this;
			}
			
			
			public function data($data='',$callback){
					
					$bulk = new \MongoDB\Driver\BulkWrite;
					
					$document = ['_id' => new \MongoDB\BSON\ObjectID, 'name' => '菜鸟教程'];

					$_id= $bulk->insert($document);
					
					
					$bulk->insert(['x' => 1, 'name'=>'菜鸟教程', 'url' => 'http://www.runoob.com']);
					$bulk->insert(['x' => 2, 'name'=>'Google', 'url' => 'http://www.google.com']);
					$bulk->insert(['x' => 3, 'name'=>'taobao', 'url' => 'http://www.taobao.com']);



					//var_dump($_id);
					
					$reslut = $this->$callback($_id,$bulk);
					
					//$reslut->_id = $_id;
					
					
					//$reslut  是 MongoDB\Driver\WriteResult 这个类
					
					//echo "<pre>";
					//var_dump(   $reslut  );
					
					return ((array)$_id)['oid'];
			
			}
			
			
			public function add(){
			
				$id = $this->data('','execute');

				return $id;
			}
			
			
			public function findAll(){
				
					$filter = ['x' => ['$gt' => 1]];
					$options = [
						'projection' => ['_id' => 0],
						'sort' => ['x' => -1],
					];

					// 查询数据
					$query = new \MongoDB\Driver\Query($filter, $options);
					$cursor = $this->mongo->executeQuery($this->Collection, $query);

					foreach ($cursor as $document) {
						print_r($document);
					}
					
			}
			
			
			public function update(){
				
				$bulk = new \MongoDB\Driver\BulkWrite;
				$bulk->update(
					['x' => 2],
					['$set' => ['name' => '菜鸟工具666', 'url' => 'tool.runoob.com']],
					['multi' => false, 'upsert' => false]
				);
				
				$this->execute('',$bulk);

			}
			
			public function del(){
				
				$bulk = new \MongoDB\Driver\BulkWrite;
				$bulk->delete(['x' => 1], ['limit' => 1]);   // limit 为 1 时，删除第一条匹配数据
				$bulk->delete(['x' => 2], ['limit' => 0]);   // limit 为 0 时，删除所有匹配数据
				$this->execute('',$bulk);

			}
			
			protected function execute($_id,$bulk){
					
					$writeConcern = new \MongoDB\Driver\WriteConcern(\MongoDB\Driver\WriteConcern::MAJORITY, 1000);
			
					$result = $this->mongo->executeBulkWrite($this->Collection, $bulk, $writeConcern);
					
					return $result;
			}
		
		
}

