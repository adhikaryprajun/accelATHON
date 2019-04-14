<?php 

include_once 'includes/bdconnection.php';


if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['type']) && isset($_POST['name']))  {
	$username = $_POST['email'];
	$password = $_POST['password'];
	$phone=$_POST['phone'];
	$address=$_POST['address'];
	$type=$_POST['type'];
	$name=$_POST['name'];
	
	
	// TODO Validation
	if($type == '0'){
		$sql="INSERT INTO users(email,phone,password,address,type,name) VALUES('".$username."','".$phone."','".$password."','".$address."',".$type.",'".$name."');";
	}
	else if($type =='1'){
		if(isset($_POST['company'])){
			$company=$_POST['company'];
			$sql="INSERT INTO users(email,phone,password,address,type,company,name) VALUES('".$username."','".$phone."','".$password."','".$address."',".$type.",'".$company."','".$name."');";
		}
		else{
			$sql="-1";
		$json->code="400";
		$json->message="company field missing";
		}
	}
	else{
		if(isset($_POST['merchant_id'])){
			$merchant_id=$_POST['merchant_id'];
			$sql="INSERT INTO users(email,phone,password,address,type,merchant_id,name) VALUES('".$username."','".$phone."','".$password."','".$address."',".$type.",'".$merchant_id."','".$name."');";
		}
		else{
				$sql="-1";
				$json->code="400";
				$json->message="merchant id missing";
		}
	}
	if($sql !="-1"){
	$result=$mysqli->query($sql);
	print_r($result);
	if($result==1) {
		$json->code="200";
		$json->message="success";
	}else{
		$json->code="400";
		$json->message="Error occured";
	}
	}	
				
}else{
		$json->code="400";
		$json->message="Please fill all details";
}
print_r(json_encode($json));
?>