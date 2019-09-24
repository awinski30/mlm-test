<?php 

//db class and functions
Class DB extends Globalfunc{
	public function connect(){
		$conx = mysqli_connect(HOST,USERN,PASS,NAME) ;
		return $conx;
	}

	function select($row, $tbl, $where = "", $outtype = ""){
		$d = "";
		$yourArray = array();
		$query = mysqli_query(self::connect(),"SELECT ".$row." FROM ".$tbl." ".$where) or die (mysqli_error(self::connect()));
		if($outtype == 1){
			 $r = mysqli_fetch_assoc($query);
			 return $r[$row];
		}else{
				$arr = array();
				$in = 0;
			 	while ($r = mysqli_fetch_assoc($query)) {
			 	 	$yourArray[$in]= $r;
			 	 	$in++;

			 	 } 
			 	return $yourArray;
			 
		}	
		
	}

	function operate_select($operator, $row, $tbl, $where = ""){
		// return "SELECT ".$operator." FROM ".$tbl." ".$where;
		// die();

		$query = mysqli_query(self::connect(),"SELECT ".$operator." FROM ".$tbl." ".$where) or die (mysqli_error(self::connect()));
		 $r = mysqli_fetch_assoc($query);
			 return $r[$row];
	}

	function delete($tbl, $where='' ){
		$query = mysqli_query(self::connect(),"DELETE FROM ".$tbl." ".$where) or die (mysqli_error(self::connect()));
		if($query){
			return 1;
		}
	}

	function update($tbl, $set , $where =""){
		$query = mysqli_query(self::connect(),"UPDATE ".$tbl." SET ".$set." ".$where) or die (mysqli_error(self::connect()));
		if($query){
			return 1;
		}	
	}

	function counter($row, $tbl, $where = ""){
		$query = mysqli_query(self::connect(),"SELECT ".$row." FROM ".$tbl." ".$where." ") ;
		if($query){
			return $c = mysqli_num_rows($query);
		}else{
			return  mysqli_error(self::connect());
		}
		
	}

	function insert($tbl, $rows, $values, $getid = ''){
		$con = self::connect();
		$query = mysqli_query($con,"INSERT INTO ".$tbl." (".$rows.") VALUES (".$values.") ");
		// $id = mysqli_insert_id(self::connect());
		if($query){	
			if($getid==1){
				$id = $con->insert_id;
				return $id;
			}else{
				return 1;
			}
		}else{
			return  mysqli_error(self::connect());
		}	
	} 
}

?>