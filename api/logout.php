<?php
include_once 'includes/bdconnection.php';



if(isset($_POST['session_hash'])){
	$hash_value=$_POST['session_hash'];
	$sql="SELECT * FROM sessions WHERE session_hash='".$hash_value."';";
	$result=$mysqli->query($sql);
	if( $result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$status=$row['status'];
			if($status =="1"){
				$update_sql="UPDATE sessions SET status = 2 WHERE session_hash='".$hash_value."';";
				$update_result=$mysqli->query($update_sql);
				$json->code="200";
				$json->message="Success";
			}else{
				$json->code="400";
				$json->message="ERROR:already logged out";
			}
		}
	}else{
		$json->code="400";
		$json->message="ERROR:Hash value invalid";
	}
}else{
	$json->code="400";
	$json->message="ERROR:Hash value not given";
}

print_r(json_encode($json));


?>