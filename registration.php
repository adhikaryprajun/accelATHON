<?php
session_start();
header('location:lg.php');
$con = mysqli_connect('localhost','wnsbmpmy_nhce','nhce@123');
    
mysqli_select_db($con,'wnsbmpmy_master_ewaste');


$name= &$_POST['user'];
$pass= &$_POST['password'];
$cpass= &$_POST['cpassword'];
$email= &$_POST['email'];
$company=&$_POST['company'];
$phone= &$_POST['phone'];
$address= &$_POST['address'];

$s = " select * from users where email = '$email' and type='1'";
$result=mysqli_query($con,$s);
$num = mysqli_num_rows($result);
if($num ==1)
{
	echo "Username already taken";
}
else{
    if($pass!=$cpass){
        echo "password mismatch";
    }
	$reg="insert into users(email,phone,password,address,type,company) values ('$email','$phone','$pass','$address',1,'$company')";
	mysqli_query($con,$reg);
	echo "registration successful";
}


?>
