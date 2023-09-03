
<!DOCTYPE html>
<html lang="en">
<?php require_once('check_login.php');?>
<?php include('head.php');?>
<?php include('header.php');?>
<?php include('sidebar.php');?>

<?php
include('connect2.php');
$init = $pdo->open();

$sql =$init->prepare("select * from admin where id = '".$_SESSION["id"]."'");
$sql->execute();
$row1 = $sql->fetch();

?>


<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper full-calender">
                <div class="page-body">
                    <div class="row">


                        <?php if($_SESSION['user'] == 'admin'){ ?>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-c-green update-card">
                                    <div class="card-block">
                                        <div class="row align-items-end">
                                            <div class="col-8">

                                                <h4 class="text-white">
                                                    <?php

                                                    $sql =$init->prepare("SELECT * FROM patient WHERE status='Active' and delete_status='0'");
                                                    $sql->execute();
                                                    echo $sql->rowCount();
                                                    ?>
                                                </h4>
                                                <h6 class="text-white m-b-0">Total Patient</h6>
                                            </div>
                                            <div class="col-4 text-right">
                                                <canvas id="update-chart-2" height="50"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-c-pink update-card">
                                    <div class="card-block">
                                        <div class="row align-items-end">
                                            <div class="col-8">

                                                <h4 class="text-white">
                                                    <?php
                                                    $sql =$init->prepare("SELECT * FROM doctor WHERE status='Active' and delete_status='0'");
                                                    $sql->execute();
                                                    echo $sql->rowCount();
                                                    ?>
                                                </h4>
                                                <h6 class="text-white m-b-0">Total Doctor</h6>
                                            </div>
                                            <div class="col-4 text-right">
                                                <canvas id="update-chart-3" height="50"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-c-lite-green update-card">
                                    <div class="card-block">
                                        <div class="row align-items-end">
                                            <div class="col-8">

                                                <h4 class="text-white">
                                                    <?php
                                                    $sql =$init->prepare("SELECT * FROM admin WHERE delete_status='0'");
                                                    $sql->execute();
                                                    echo $sql->rowCount();
                                                    ?>
                                                </h4>
                                                <h6 class="text-white m-b-0">Performing Admin
                                                </h6>
                                            </div>
                                            <div class="col-4 text-right">
                                                <canvas id="update-chart-4" height="50"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-c-yellow update-card">
                                    <div class="card-block">
                                        <div class="row align-items-end">
                                            <div class="col-8">

                                                <h4 class="text-white">RS.
                                                    <?php
//                                                    $sql = "SELECT sum(bill_amount) as total  FROM `billing_records` ";
//                                                    $qsql = mysqli_query($conn,$sql);
//                                                    while ($row = mysqli_fetch_assoc($qsql))
//                                                    {
//                                                        echo $row['total'];
//                                                    }
                                                    ?>
                                                </h4>
                                                <h6 class="text-white m-b-0">Hospital Earning</h6>
                                            </div>
                                            <div class="col-4 text-right">
                                                <canvas id="update-chart-1" height="50"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>

                    </div>

                    <?php if($_SESSION['user'] == 'admin'){ ?>
                        <div class="row">
                            <div class="col-md-6" hidden>
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Appointment</h5>

                                    </div>
                                    <div class="card-block">
                                        <div class="ct-chart1 ct-perfect-fourth"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6" hidden>
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Patient</h5>
                                    </div>
                                    <div class="card-block">
                                        <div class="ct-chart1-patient ct-perfect-fourth"></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-header">
                                <h2>Appointments</h2>
                                <!-- <h5>DOM/Jquery</h5>
                                <span>Events assigned to the table can be exceptionally useful for user interaction, however you must be aware that DataTables will add and remove rows from the DOM as they are needed (i.e. when paging only the visible elements are actually available in the DOM). As such, this can lead to the odd hiccup when working with events.</span> -->
                            </div>
                            <div class="card-block">
                                <div class="table-responsive dt-responsive">
                                    <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                        <thead>
                                        <tr>
                                            <th>Patient detail</th>
                                            <th>Appointment Date &  Time</th>
                                            <th>Doctor</th>
                                            <th>Reason</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                        $sql =$init->prepare("SELECT *,(doctor.doctorname) AS dname,
                                                              patient.fname AS pname,patient.lname AS psurname
                                                              FROM doctor,patient,appointment 
                                                              WHERE doctor.doctorid=appointment.doctorid
                                                              AND patient.patientid=appointment.patientid");
                                        $sql->execute();
                                        if($sql->rowCount() > 0){
                                           foreach ($sql as $data){
                                               echo "<tr>
                                                    <td>&nbsp;$data[pname]<br>&nbsp;$data[psurname]</td>     
                                                 <td>&nbsp;" . date("d-M-Y",strtotime($data['appointment_date'])) . " &nbsp; " . date("H:i A",strtotime($data['appointment_date'])) . "</td> 
                                                   <td>&nbsp;$data[dname]</td>
                                                    <td>&nbsp;$data[reason]</td>
                                                    <td>&nbsp;$data[app_status]</td></tr>";
                                           }
                                        }



                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>
</div>


<?php include('footer.php');?>


<link rel="stylesheet" href="files/bower_components/chartist/css/chartist.css" type="text/css" media="all">
<!-- Chartlist charts -->
<script src="files/bower_components/chartist/js/chartist.js"></script>
<script src="files/assets/pages/chart/chartlist/js/chartist-plugin-threshold.js"></script>
<script type="text/javascript">
    /*Threshold plugin for Chartist start*/
    var appointment = [];
    <?php
    for ($i = 01; $i < 13; $i++) {
    $count = 0;
    $sql ="SELECT * FROM appointment WHERE (status !='') and delete_status='0' and MONTH(appointmentdate) = '".$i."'";$qsql = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($qsql);
    ?>
    appointment.push(<?php echo $count; ?>);
    <?php } ?>
    new Chartist.Line('.ct-chart1', {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May','Jun','July','Oct','Sep','Oct','Nov','Dec'],
        series: [
            appointment
        ]
    }, {
        showArea: false,

        axisY: {
            onlyInteger: true
        },
        plugins: [
            Chartist.plugins.ctThreshold({
                threshold: 4
            })
        ]
    });

    var defaultOptions = {
        threshold: 0,
        classNames: {
            aboveThreshold: 'ct-threshold-above',
            belowThreshold: 'ct-threshold-below'
        },
        maskNames: {
            aboveThreshold: 'ct-threshold-mask-above',
            belowThreshold: 'ct-threshold-mask-below'
        }
    };

    //Second Chat
    var patient = [];
    <?php
    for ($i = 01; $i < 13; $i++) {
    $count_patient = 0;
    $sql ="SELECT * FROM patient WHERE (status !='') and delete_status='0' and MONTH(admissiondate) = '".$i."'";
    $qsql = mysqli_query($conn,$sql);
    $count_patient = mysqli_num_rows($qsql);
    ?>
    patient.push(<?php echo $count_patient; ?>);
    <?php } ?>

    new Chartist.Line('.ct-chart1-patient', {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May','Jun','July','Oct','Sep','Oct','Nov','Dec'],
        series: [ patient
        ]
    }, {
        showArea: false,

        axisY: {
            onlyInteger: true
        },
        plugins: [
            Chartist.plugins.ctThreshold({
                threshold: 4
            })
        ]
    });

    var defaultOptions = {
        threshold: 0,
        classNames: {
            aboveThreshold: 'ct-threshold-above',
            belowThreshold: 'ct-threshold-below'
        },
        maskNames: {
            aboveThreshold: 'ct-threshold-mask-above',
            belowThreshold: 'ct-threshold-mask-below'
        }
    };

</script>
</html>