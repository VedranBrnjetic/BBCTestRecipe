<?php

class SQLconnection {
	
	private $pdo;
	public $established;
	
	
	function __construct() {
		//constructor - takes config.php for connection details and tries to connect to db;
		
		include 'config.php';
		$this->established=false;
		$this->pdo=new PDO($dbtype.':host='.$host.';dbname='.$database,$user,$pass);
		$this->pdo->exec("set names utf8");
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if($this->pdo) $this->established=true;
    }
	
	public function pdo_con(){
		return $this->pdo;
	}
	
	//simple query - could be used to do anything - add new tables, drop tables, truncate tables, fetch stuff, whatever
	//accepts string
	public function pdo_query($query_string){
		$sql = $query_string;
		$stmt=$this->pdo->prepare($sql);
		$stmt->execute();
		$obj=array();
		while($row=$stmt->fetch(PDO::FETCH_OBJ)){
			array_push($obj,$row);
		}
		unset($stmt);
		return ($obj);
		
	}
	
	//parametrised query, accepts $result_fields[array], $table[stirng], $query_params[array of objects]
	//$query_params[$object] column,compare,logical, value
	//can be used to get any info from any single table. I should expand it to allow joins and unions
	//$limit is for optional pagination; 0 means no limit
	public function pdo_query_wparam($result_fields,$table,$query_params,$limit=0){
		//preparing the query
		$res=null;
		$sql = " select ";
		//adding requested fields
		foreach($result_fields as $field){
			$sql .= $field.", ";
		}
		//triming the last comma from fieldset
		$sql = substr($sql, 0, -2);
		//adding table information
		$sql .= " from ".$table." where ";
		
		//preparing the where clause 
		//query params are organized so that the function knows how to build the where clause
		//it contains the condition column name, comparison operator and logical operator or "" for the last item
		
		foreach($query_params as $param){
			$sql .= $param->column." " . $param->compare ." :" . $param->column . " " . $param->logical ." ";
		}
		//optional pagination
		if($limit!=0){
			
			$sql.=" LIMIT ".$limit;
			
		}
		$sql .=" ;";
		
		$stmt=$this->pdo->prepare($sql);
		try{
			foreach($query_params as $param){
				$column=":".$param->column;
				$value=$param->value;
				$stmt->bindParam($column,$value);
			}
		}
		catch(PDOException $Exception){
			print_r ($Exception);
			$res=$Exception;
		}
		
		try{
			$stmt->execute();
		}
		catch(PDOException $Exception){
			print_r ($Exception);
			$res=$Exception;
		}
		
		
		try{
			$res=array();
			$results=$stmt->fetchAll(PDO::FETCH_OBJ);
			foreach($results as $result){
				$string=utf8_encode(serialize($result));
				$result=unserialize($string);
				
				array_push($res,$result);
			}
		}
		catch(PDOException $Exception){
			
			print_r ($Exception);
			$res=$Exception;
		}
		unset($stmt);
		return ($res);
		
	}
	// $table string
	//$fieldset string array
	//fieldset is separate because I set the table columns only once in the query
	//$values object array
		//expected object $obj->column, $obj->value
	public function pdo_insert($table,$fieldset,$values){
		$sql=" insert into ".$table." (";
		foreach($fieldset as $field){
			$sql.=$field.", ";
		}
		$sql = substr($sql, 0, -2);
		$sql .= ") values ";
		$i=0;
		foreach($values as $value_row){
			$sql.="(";
			foreach($value_row as $obj){
				$sql.=":".$obj->column.$i.", ";
			}
			$sql= substr($sql, 0, -2);
			$sql.="), ";
			$i++;
		}
		$sql = substr($sql, 0, -2);
		$sql.=";";
		
		
		$stmt=$this->pdo->prepare($sql);
		
		$i=0;
		foreach($values as $value_row){
			foreach($value_row as $obj){
				$column=":".$obj->column.$i;
				$value=$obj->value;
				
				$stmt->bindParam($column,$value);
			}
			$i++;
		}
		try {
			$result=$stmt->execute();
			return $result;
		}
		catch(PDOException $Exception){
			print_r ($Exception);
			$res=$Exception;
			return $res;
		}
	}
	//$table string
	//$conditions array($condtion,$condition,...)
	//	$condition stdClass($column,$compare,$value,$logical)
	public function pdo_delete($table,$conditions){
		$sql=" delete from ". $table." where ";
		foreach($conditions as $condition){
			$sql .= $condition->column." " . $condition->compare ." :" . $condition->column . " " . $condition->logical ." ";
		}
		$sql .=";";
		
		$stmt=$this->pdo->prepare($sql);
		try{
			foreach($conditions as $condition){
				$column=":".$condition->column;
				$value=$condition->value;
				$stmt->bindParam($column,$value);
			}
		}
		catch(PDOException $Exception){
			print_r ($Exception);
			$res=$Exception;
		}
		$res=null;
		try{
			$res=$stmt->execute();
		}
		catch(PDOException $Exception){
			print_r ($Exception);
			$res=$Exception;
		}
		unset($stmt);
		return $res;
		
	}
} 