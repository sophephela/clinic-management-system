<?php 
session_start();
if((isset($_SESSION["email"]) && isset($_SESSION["password"]))){

    if($_SESSION["user"]=='nurse'){
        header("location:nurse/view-patient.php");
    }

    if($_SESSION["user"]=='pharmacy'){
        header("location:pharmacy/patient.php");
    }
//
//    if($_SESSION["user"]=='admin'){
//        header("location:index.php");
//    }
	$myemail = $_SESSION['email'];
}else {
	header("location:home.php");
}
?>