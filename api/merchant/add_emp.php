<?php 

include_once '../includes/bdconnection.php';

if(isset($_POST['session_hash'])){
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
					if(isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['password']) && isset($_POST['address']) && isset($_POST['name'])){
						$emp_email=$_POST['email'];
						$emp_phone=$_POST['phone'];
						$emp_password=$_POST['password'];
						$emp_address=$_POST['address'];
						$emp_type="2";
						$emp_merchant_id=$merchant_id;
						$emp_name=$_POST['name'];
						$merchant_sql="INSERT INTO users(email,phone,password,address,type,merchant_id,name) VALUES('".$emp_email."','".$emp_phone."','".$emp_password."','".$emp_address."',".$emp_type.",".$emp_merchant_id.",'".$emp_name."');";
						$merchant_result=$mysqli->query($sql);
						//die($merchant_sql);
						if($merchant_result == 1){
							$json->code="200";
							$json->message="Success";
							$sql2="SELECT * FROM users WHERE merchant_id=".$emp_merchant_id.";";
							$allemp=$mysqli->query($sql2);
							if($allemp->num_rows>0){
								while($emprow=$allemp->fetch_assoc()){
									$allemployess[]=$emprow;
								}
								$json->employee=$allemployess;
							
							}
						}else{
							$json->code="400";
							$json->message="Employee was not entered";
						}
					}else{
						$json->code="200";
						$json->message="Success";
						$sql2="SELECT * FROM users WHERE merchant_id=".$emp_merchant_id.";";
						$allemp=$mysqli->query($sql2);
						if($allemp->num_rows>0){
							while($emprow=$allemp->fetch_assoc()){
								$allemployess[]=$emprow;
							}
							$json->employee=$allemployess;
						}						
					}
				}else{
					$json->code="400";
					$json->message="User already logged out";	
				}
			}else{
				$json->code="400";
				$json->message="User is not authorized";
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
