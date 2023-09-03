
<?php
session_start();
$current_date = date('Y-m-d');
$return = $_SERVER['HTTP_REFERER'];
include('../connect2.php');
$init = $pdo->open();

if(isset($_POST['make_appoint']))
{
    try {
        $getP =$init->prepare("SELECT start_time,end_time FROM doctor_timings WHERE doctor_timings_id='$_POST[slot]'");  
        $getP->execute();
        $date = $getP->fetch();
        $app_date = $date['start_time']." - ".$date['end_time'];
    
        $sql =$init->prepare("INSERT INTO appointment(patientid,doctorid,appointment_date,reason,blood_pressure,app_status) 
        values('$_SESSION[id]','$_POST[doctor]','$app_date','$_POST[reason]','$_POST[blood_pressure]',0)");
        $sql->execute();

        $sql =$init->prepare("UPDATE doctor_timings SET STATUS='Booked' WHERE doctor_timings_id='$_POST[slot]'");
        $sql->execute();

        $_SESSION['success'] = 'Appointment successfully booked';
        header('location: '.$return);

    }catch (Exception $e){
        $_SESSION['error'] = $e->getMessage();
        header('location:'.$return);
    }

}

if(isset($_POST['doctorid']))
{
    try {
        $date = date('H:i:s');
        $getP =$init->prepare("SELECT * FROM doctor_timings WHERE doctorid='$_POST[doctorid]'");  
        $getP->execute();
        $data = $getP->fetchAll();
        echo  json_encode($data);

    }catch (Exception $e){
        $error = $e->getMessage();
        return $error;
    }

}

$pdo->close();