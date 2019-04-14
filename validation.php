<?php
session_start();

$con = mysqli_connect('localhost','wnsbmpmy_nhce','nhce@123');

mysqli_select_db($con,'wnsbmpmy_master_ewaste');

$name= $_POST['username'];
$pass= $_POST['password'];
$s = (" select * from users where email='".$name."' and password='".$pass."' and type='2'");
$result=mysqli_query($con,$s);
$num = mysqli_num_rows($result);
if($num==1)
{
	header('Location:campaign.html');
}
else{
	header('Location:elogin.html');
}
?>
