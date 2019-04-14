<?php 

include_once 'includes/bdconnection.php';


if(isset($_POST['username']) && isset($_POST['password'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	// TODO Validation
	$sql="SELECT * FROM users WHERE email='".$username."';";
	$result=$mysqli->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			//print_r($row);
			$user_password = $row['password'];
			$user_id=$row['id'];
			$user_type=$row['type'];
			if($user_type === '3'){
				$json->code="400";
				$json->message="User deactivated";
			}else{
				
				if($user_password==$password){
					$hashvalue=generateHash();
					$session_sql="INSERT INTO sessions(user_id,session_hash,status) VALUES(".$user_id.",'".$hashvalue."',1);";
					$session_result=$mysqli->query($session_sql);
					
					if($session_result==1) {
						$session->user_id=$user_id;
						$session->hashvalue=$hashvalue;
						$session->status=1;
						$json->code="200";
						$json->message="Success";
						$json->user = $row;
						$json->session=$session;
					}else{
						$json->code="400";
						$json->message="invalid username or password try again";
					}
				} else {
					$json->code="400";
					$json->message="invalid username or password";
				}
			}	
		}
	}else {
	$json->code="400";
	$json->message="ERROR:username not found";
}
	
} else {
	$json->code="400";
	$json->message="invalid";
}
	print_r(json_encode($json));

function generateHash() {
	return hash("ripemd160", date("Y/m/d").time());
}
?>