<?php
/*
* Mongodb 数据库连接
*/
namespace MongoDBserver;
interface DBface{
	
			public function create_connect($dbPort);
}
?>