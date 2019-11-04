<?php
session_start();
include 'connect.php';
if(isset($_SESSION['user_data'])){
	if($_SESSION['user_data']['usertype']!=1){
		header("Location:student_home.php");
	}
	if(!isset($_REQUEST['id'])){
		header("Location:teacher_home.php?error=Please Enter ID");
	} 
	$qr=mysqli_query($con,"select * from users where id='".$_REQUEST['id']."'");
	if(mysqli_num_rows($qr)==0){
		header("Location:teacher_home.php?error=Student ID Not Found");	
	}
	$result_qr=mysqli_query($con,"select * from results where student_id='".$_REQUEST['id']."'");
	if(mysqli_num_rows($result_qr)>0){
		header("Location:teacher_home.php?error=Student Result Already Exist");	
	}

	$qr_result=mysqli_query($con,"INSERT into results (student_id,teacher_id) values ('".$_REQUEST['student_id']."','".$_SESSION['user_data']['id']."')");
	if($qr_result){
		$last_id=mysqli_insert_id($con);
		$marks_Array=$_REQUEST['marks'];
		$subject_id_array=$_REQUEST['id'];
		foreach($marks_Array as $key=>$marks){
			$mark_qr=mysqli_query($con,"INSERT into result_data (result_id,subject_id,marks) values ('".$last_id."','".$subject_id_array[$key]."','".$marks."')");
		}
		header("Location:teacher_home.php?success=Added Result Successfully");
	}
	else{
		header("Location:teacher_home.php?error=Failed to Add Student");	
	}

?>
<?php
}
else{
	header("Location:index.php?error=UnAuthorized Access");
}