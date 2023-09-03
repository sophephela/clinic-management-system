
<?php
session_start();
$current_date = date('Y-m-d');
$return = $_SERVER['HTTP_REFERER'];
include('../connect2.php');
$init = $pdo->open();

if(isset($_POST['confirm_collection']))
{
    try{
        $sql =$init->prepare("UPDATE appointment SET app_status=3
                          WHERE appointmentid='$_POST[confirm_collection]'");
        $sql->execute();
        $getP =$init->prepare("SELECT * FROM appointment WHERE appointmentid='$_POST[confirm_collection]'");
        $getP->execute();
        $getPs = $getP->fetch();

        if($sql->rowCount() > 0) {
            $sql2 =$init->prepare("UPDATE patient SET blood_pressure=''
                          WHERE patientid='$getPs[patientid]'");
            $sql2->execute();
            $_SESSION['success'] = 'Patient Record Updated Successfully';
            header('location: history.php');
        }
    }catch (Exception $e){
        $_SESSION['error'] = $e->getMessage();
        header('location:'.$return);
    }

}

