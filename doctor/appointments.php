
<?php require_once('check_login.php');include('head.php');include('header.php');include('sidebar.php');
include('../connect2.php');


$init = $pdo->open();
if(isset($_GET['attend_app']))
{
    $sql =$init->prepare("UPDATE appointment SET doctorid=$_SESSION[id] WHERE appointmentid='$_GET[attend_app]'");
    $sql->execute();
    if($sql->rowCount() > 0)
    {
        ?>
        <div class="popup popup--icon -success js_success-popup popup--visible">
            <div class="popup__background"></div>
            <div class="popup__content">
                <h3 class="popup__content__title">
                    Success
                </h3>
                <p>Appointment successfully updated</p>
                <p>
                    <!--  <a href="index.php"><button class="button button--success" data-for="js_success-popup"></button></a> -->
                    <?php echo "<script>setTimeout(\"location.href = 'appointments.php';\",1500);</script>"; ?>
                </p>
            </div>
        </div>
        <?php
    }
}
?>
<?php
if(isset($_GET['delid']))
{ ?>
    <div class="popup popup--icon -question js_question-popup popup--visible">
        <div class="popup__background"></div>
        <div class="popup__content">
            <h3 class="popup__content__title">
                Sure
                </h3>
                <p>Are You Sure To Delete This Record?</p>
                <p>
                    <a href="view-patient.php?id=<?php echo $_GET['delid']; ?>" class="button button--success" data-for="js_success-popup">Yes</a>
                    <a href="view-patient.php" class="button button--error" data-for="js_success-popup">No</a>
                </p>
        </div>
    </div>
<?php } ?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">

        <div class="main-body">
            <div class="page-wrapper">

                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Patient</h4>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="dashboard.php"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a>Patient</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="view_user.php">Patient</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-body">

                    <div class="card">
                        <div class="card-header text-center">
                            <h4 class="">New Appointments</h4>
                            <!-- <h5>DOM/Jquery</h5>
                            <span>Events assigned to the table can be exceptionally useful for user interaction, however you must be aware that DataTables will add and remove rows from the DOM as they are needed (i.e. when paging only the visible elements are actually available in the DOM). As such, this can lead to the odd hiccup when working with events.</span> -->
                        </div>
                        <div class="card-block">
                            <div class="table-responsive dt-responsive">
                                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>Patient Details</th>
                                        <th>Appointment Reason</th>
                                        <th>Blood Pressure</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql =$init->prepare("SELECT * FROM appointment,patient where patient.patientid=appointment.patientid AND doctorid IS null");
                                    $sql->execute();
                                    $qsql = $sql->fetchAll();
                                    if($sql->rowCount() > 0){
                                        foreach($qsql as $rs)
                                        {
                                            echo "<tr>
                                                    <td><strong>Name: $rs[fname] $rs[lname]</strong><br>
                                                     <strong>ID Number: $rs[id_number]</strong><br>
                                                     <strong>Mobile: $rs[mobileno]</strong></td>
                                                      <td>$rs[reason]</td>
                                                    <td>$rs[blood_pressure]</td>
                                                    <td align='center'><button class='btn btn-success btn-attend' id='$rs[appointmentid]'>Attend Patient</button></td>
                                                </tr>";
                                        }
                                    }

                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                

            </div>
        </div>

    </div>
</div>
</div>


<div id="app-attend" class="popup popup--icon -question js_question-popup ">
    <div class="popup__background"></div>
    <div class="popup__content">
        <h3 class="popup__content__title">
            Sure
        </h3>
        <p>Are You Sure To Attend This Patient?</p>
        <p>
            <a class="button button--success accept_appointment" data-for="js_success-popup">Yes</a>
            <a href="appointments.php" class="button button--error" data-for="js_success-popup">No</a>
        </p>
    </div>
</div>


<?php include('../pages/alerts.php');include('footer.php');?>

<script>
    var addButtonTrigger = function addButtonTrigger(el) {
        el.addEventListener('click', function () {
            var popupEl = document.querySelector('.' + el.dataset.for);
            popupEl.classList.toggle('popup--visible');
        });
    };

    Array.from(document.querySelectorAll('button[data-for]')).
    forEach(addButtonTrigger);

    $('.btn-attend').on('click',function () {
        $('.accept_appointment').attr('href','appointments.php?attend_app='+this.id);
        $('#app-attend').addClass('popup--visible');
    });
</script>