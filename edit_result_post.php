<?php
session_start();
include 'connect.php';
if(isset($_SESSION['user_data'])){
	if($_SESSION['user_data']['usertype']!=1){
		header("Location:student_home.php");
	}
	if(!isset($_REQUEST['student_id'])){
		header("Location:teacher_home.php?error=Please Enter ID");
	} 
	$qr=mysqli_query($con,"select * from users where id='".$_REQUEST['student_id']."'");
	if(mysqli_num_rows($qr)==0){
		header("Location:teacher_home.php?error=Student ID Not Found");	
	}

	$result_id=$_REQUEST['result_id'];
	$marks_Array=$_REQUEST['marks'];
	$data_id=$_REQUEST['id'];
	foreach($marks_Array as $key=>$marks){
		$qr_update=mysqli_query($con,"UPDATE result_data set marks='".$marks."' where id='".$data_id[$key]."'");
	}
	header("Location:teacher_home.php?success=Edited Successfully");

?>
<?php
}
else{
	header("Location:index.php?error=UnAuthorized Access");
}
//teacher part complete now student view the result;