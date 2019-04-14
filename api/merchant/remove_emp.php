<?php 

include_once '../includes/bdconnection.php';
/*
$s="UPDATE users SET type = 3 WHERE id = 34";
print_r($s);
if($mysqli->query($s)){
	die("Success");
}else{
	die("Failed");
}
*/

if(isset($_POST['session_hash']) ){
	$hashvalue=$_POST['session_hash'];
	$sql="SELECT * FROM sessions,users WHERE sessions.session_hash='".$hashvalue."' AND users.id = sessions.user_id;";
	$result=$mysqli->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()) {
			//print_r($row);
			$status = $row['status'];
			$merchant_id=$row['user_id'];
			$merchant_type=$row['type'];
			if($merchant_type == "1"){
				if($status=='1'){
					if(isset($_POST['emp_id']) && isset($_POST['type'])){
						$employee_id=$_POST['emp_id'];
						$type=$_POST['type'];
						if($type === "2"){
							$emp_type="3";
						}else if($type==="3"){
							$emp_type="2";
						}else{
							$employee_id=$type;
							$emp_type=$type;
						}
						$merchant_sql="UPDATE users SET type = ".$emp_type." WHERE id = ".$employee_id." AND merchant_id =".$merchant_id.";";
						$merchant_result=$mysqli->query($merchant_sql);
						print_r($merchant_sql);
						if($merchant_result){
							$json->code="200";
							$json->message="Success";
							$get_all="SELECT * FROM users WHERE merchant_id=".$merchant_id.";";
							$get_all_result=$mysqli->query($get_all);
							print_r($get_all);
							if($get_all_result->num_rows > 0){
								while($get_all_rows=$get_all_result->fetch_assoc()){
									$emprow []=$get_all_rows;
								}
								$json->employees=$emprow;
							}
							
						}else{
							$json->code="400";
							$json->message="ERROR:invalid request";
						}
					}else{
						$json->code="400";
						$json->message="ERROR:Employee id wasn't given";
						
					}
				}else{
					$json->code="400";
					$json->message="User already logged out";	
				}
			}else{
				$json->code="400";
				$json->message="User is not authorized ";
			}
		}	
	}else{
		$json->code="400";
		$json->message="Unauthorized access";
	}
}else{
	$json->code="400";
	$json->message="Unauthorized access";
}

print_r(json_encode($json));

?>


