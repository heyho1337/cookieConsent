<?php 

	namespace Common;
	
	/**
	 * Abstract Class Database
	 */
	abstract class Database{

		protected $conn;
		protected const dbUser = "";
		protected const dbPass = "";
		protected const dbName = "";
		protected const tbl_prefix = "";
		
		/**
		 * commnets soon 
		*/
		abstract protected function selectQuery($table, $columns, $where, $order, $group = null);
    	
		/**
		 * commnets soon 
		*/
		abstract protected function insertQuery($table);
    	
		/**
		 * commnets soon 
		*/
		abstract protected function updateQuery($table, $fields, $where);
		
		/**
		 * commnets soon 
		*/
		abstract protected function createQuery($tableName, $columns);

		public function create($tableName, $columns){
			$this->createQuery($tableName, $columns);
		}

		public function select($table, $columns, $where, $order,$group = null) {
			return $this->selectQuery($table, $columns, $where, $order,$group);
		}

		public function insert($table) {
			return $this->insertQuery($table);
		}

		public function update($table,$fields,$where) {
			return $this->updateQuery($table,$fields,$where);
		}
	}