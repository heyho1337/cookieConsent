<?php 

	namespace Models\Database;
	
	/**
	 * Abstract Class Db\Database
	 */
	abstract class Database{

		protected $conn;
		protected const dbUser = "consent";
		protected const dbPass = "consent123";
		protected const dbName = "consentdb";
		protected const tbl_prefix = "";
		
		/**
		 * select row or rows from the databse
		*/
		abstract protected function select(string $table, array $columns, array $where, string $order, string | null $group = null);
    	
		/**
		 * insert rows into a database
		*/
		abstract protected function insert(string $table);
    	
		/**
		 * update a row's columns in the database
		*/
		abstract protected function update(string $table, array $fields, array $where);
		
		/**
		 * create a database table if it is not extist allready
		*/
		abstract protected function create(string $tableName, array $columns);
	}