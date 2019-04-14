<?php 

include_once 'includes/bdconnection.php';


if(isset($_POST['username']) && isset($_POST['password'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	print_r($username);
	// TODO Validation
	$sql="SELECT * FROM users WHERE email='".$username."';";
	$result=$mysqli->query($sql);
	print_r($result);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			//print_r($row);
			$user_password = $row['password'];
			$user_id=$row['id'];
			if($user_password==$password){
				$hashvalue=generateHash();
				$session_sql="INSERT INTO sessions(user_id,session_hash,status) VALUES(".$user_id.",'".$hashvalue."',1);";
				$session_result=$mysqli->query($session_sql);
				echo ("Session");
				print_r($session_result);
				
				if($session_result==1) {
					$session->user_id=$user_id;
					$session->hashvalue=$hashvalue;
					$session->status=1;
					$json->user = $row;
					$json->session=$session;
				}
				
			}
			
		}
		print_r(json_encode($json));
	}
} else {
	print_r("ERROR : Invalid Request");
}

function generateHash() {
	return hash("ripemd160", date("Y/m/d").time());
}
?>