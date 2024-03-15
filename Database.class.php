<?php
    
    namespace Common;
	
	/**
	 * Class Database
	 */
	class Database{
    	protected $conn;
		protected const dbUser = "";
		protected const dbPass = "";
		protected const dbHost = "";
		protected const dbName = "";
		protected const tbl_prefix = "";

        function __construct(){
           	$dsn = 'mysql:host='.self::dbHost.';dbname='.self::dbName.';port=3311;charset=utf8';
            try {
              	$this->conn = new \PDO($dsn, self::dbUser, self::dbPass, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
            } catch (\PDOException $e) {
                echo $e->getMessage();
                $response["status"] = "error";
                $response["message"] = 'Connection failed: ' . $e->getMessage();
                $response["data"] = null;
                exit;
            }
        }
        

        private function selectQuery($table, $columns, $where, $order,$group = null){
            try{
                $a = array();
                $w = "";
                $cols = "";
                $where_string = "where 1=1 ";
                if(is_array($where)){
                    foreach ($where as $key => $value) {
                        $w .= " and " .$key. " like :".$key;
                        $a[":".$key] = $value;
                    }
					$where_string.= $w;
                }
				$countCol = count($columns);
                for($i = 0;$i<$countCol;$i++){
					$cols .= $columns[$i];
					if ($i < $countCol - 1) {
						$cols .= ",";
					}
                }

				$stmt = $this->conn->prepare("select ".$cols." from ".self::tbl_prefix.$table." ".$where_string." ".$group." ".$order);
                $stmt->execute($a);
                $rows = $stmt->fetchAll(\PDO::FETCH_OBJ);

				$count = $this->conn->prepare("select ".$cols." from ".self::tbl_prefix.$table." ".$where_string." ".$group." ".$order);
                $count->execute($a);

                if(isset($rows)){
					$response["status"] = "success";
                    $response["message"] = "Data selected from database";
                }else{
                    $response["status"] = "warning";
                    $response["message"] = "No data found.";
                }
                $response["data"] = $rows;
				$response['rowCount'] = $count->rowCount();
            }catch(\PDOException $e){
                $response["status"] = "error";
                $response["message"] = 'Select Failed: ' .$e->getMessage();
                $response["data"] = null;
            }
            $response['query'] = "select ".$cols." from ".self::tbl_prefix.$table." where 1=1 ". $w." ".$group." ".$order;
            return $response; 
        }
		

		private function insertQuery($table){
			$data = $_POST;
			$type = $this->conn->query("SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='".self::tbl_prefix.$table."'");
			$type2 = $type->fetchAll(\PDO::FETCH_COLUMN);
			array_shift($type2);
			$q = $this->conn->prepare("DESCRIBE ".self::tbl_prefix.$table);
			$q->execute();
			$getFields = $q->fetchAll(\PDO::FETCH_COLUMN);
		
			array_shift($getFields);
			$implodedFields = implode(", :", $getFields);
			$sql = "INSERT INTO ".self::tbl_prefix.$table." (".implode(", ", $getFields).") VALUES(:".$implodedFields.")";
			$insert = $this->conn->prepare($sql);
			$none		= "";

			foreach ($getFields as $dbKey => $dbValue) {
				if(isset($data[$dbValue])) {
					$insert->bindValue(":$dbValue", $data[$dbValue]);
				}
				else {
					if($type2[$dbKey] === "int"){
						$insert->bindValue(":$dbValue", 0);
					}
					else{
						$insert->bindValue(":$dbValue", $none);
					}
				}
			}
		
			$insert->execute();
			$last_insert_id	= $this->conn->lastInsertId();
			return $last_insert_id;
		}

		
		private function updateQuery($table,$fields,$where){
			$sql="UPDATE ".self::tbl_prefix.$table." SET ";
			$j = 0;
			$w = " WHERE ";
			foreach ($where as $key => $value) {
				if($j === 0){
					$w.=$key." = :".$key;
				}
				else{
					$w.= " and " .$key. " = :".$key;
				}
				$j++;
			}
			$field_count = count($fields);
			$i = 0;
			foreach($fields as $dbKey => $dbValue){
				$i++;
				if($i === $field_count){
					$sql.=$dbKey." = :".$dbKey."";
				}
				else{
					$sql.=$dbKey." = :".$dbKey.",";
				}
			}
			$sql.=$w;
			$stmt = $this->conn->prepare($sql);
			$k = 0;
			foreach($fields as $dbKey => $dbValue){
				$stmt->bindParam(':'.$dbKey, $fields[$dbKey]);
			}
			foreach ($where as $key => $value) {
				$stmt->bindParam(':'.$key, $value);
			}
			$result = $stmt->execute();
			return $result;
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