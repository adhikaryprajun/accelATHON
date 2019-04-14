<?php 

include_once 'includes/bdconnection.php';
/*
$s="UPDATE users SET type = 3 WHERE id = 34";
print_r($s);
if($mysqli->query($s)){
	die("Success");
}else{
	die("Failed");
}
*/
$flag=TRUE;
if(isset($_POST['session_hash']) && isset($_POST['status']) && isset($_POST['upload_id'])){
	$hashvalue=$_POST['session_hash'];
	$status=$_POST['status'];
	$upload_id=$_POST['upload_id'];
	$sql="SELECT * FROM sessions,users WHERE sessions.session_hash='".$hashvalue."' AND users.id = sessions.user_id;";
	$result=$mysqli->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()) {
			//print_r($row);
			$merchant_id=$row['user_id'];
			$merchant_type=$row['type'];
			if($status =='0'){
				$merchant_sql="UPDATE uploads set status = 0,collector_id=NULL WHERE id=".$upload_id.";";
			}
			else if($status =="1"){
				$merchant_sql="UPDATE uploads set status = 1 ,collector_id=".$merchant_id." WHERE id=".$upload_id.";";
			}
			else if($status=="2"){
				$merchant_sql="UPDATE uploads set status = 2 WHERE id=".$upload_id.";";
			}
			else if($status=="3"){
				$merchant_sql="UPDATE uploads set status = 3 WHERE id=".$upload_id.";";
			}
			else{
				$flag=FALSE;
			}
		
			if($flag){
				$merchant_result=$mysqli->query($merchant_sql);
				if($merchant_result){
					$json->code="200";
					$json->message="Success";
					$updated_sql="SELECT * FROM uploads;";
					$updated_result=$mysqli->query($updated_sql);
					if($updated_result->num_rows>0){
						while($updated_row=$updated_result->fetch_assoc()){
							$array[]=$updated_row;
						}
						$json->updated=$array;
					}
				}else{
					$json->code="400";
					$json->message="ERROR:invalid";
				}
			}else{
				$json->code="400";
				$json->message="ERROR:Invalid status";
			}
		}
	}else{
		$json->code="400";
		$json->message="User already logged out";	
	}
}else{
	$json->code="400";
	$json->message="ERROR:invalid request ";
}
print_r(json_encode($json));

?>


