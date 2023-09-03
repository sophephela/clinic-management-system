
<?php require_once('check_login.php');?>
<?php include('head.php');?>
<?php include('header.php');?>
<?php include('sidebar.php');?>
<?php include('../connect2.php');

$init = $pdo->open();
if(isset($_GET['confirm_blood_id']))
{
    $sql =$init->prepare("UPDATE patient SET blood_pressure='$_GET[confirm_blood]' WHERE patientid='$_GET[confirm_blood_id]'");
    $qsql=$sql->execute();
	
		$sql =$init->prepare("SELECT * from appointment where patientid='$_GET[confirm_blood_id]' and app_status=0");
        $sql->execute();
        $records = $sql->fetchAll();

        foreach($records as $rec){

          if( substr($rec['appointment_date'],strpos($rec['appointment_date'],"- ")+2,8) > date('H:i:s')){
             $sql =$init->prepare("UPDATE appointment SET blood_pressure='$_GET[confirm_blood]', APP_STATUS=1 where appointmentid='$rec[appointmentid]'");
             $sql->execute();
          }
        }
	
    if($sql->rowCount() > 0)
    {
        ?>
        <div class="popup popup--icon -success js_success-popup popup--visible">
            <div class="popup__background"></div>
            <div class="popup__content">
                <h3 class="popup__content__title">
                    Success
                </h3>
                <p>Patient record updated successfully.</p>
                <p>
                    <?php echo "<script>setTimeout(\"location.href = 'view-patient.php';\",1500);</script>"; ?>
                </p>
            </div>
        </div>
        <?php
    }
}
?>
<?php
if(isset($_GET['edit_blood']))
{ ?>
    <div class="popup popup--icon -blood js_blood-popup popup--visible">
       
        <div class="popup__content">
            <h3 class="popup__content__title">
                Edit Patient Blood Pressure
            </h3>
			<form class="" action="index.php" method="get">
				<input name="confirm_blood_id" value="<?php echo $_GET['edit_blood']?>" class="form-control" required="" hidden>
				<input name="confirm_blood" class="form-control" required >
					<br></br>
				<p>
					<button class="button button--sucsess" type="submit">
						Confirm
					</button>
					<a href="index.php" class="button button--error" data-for="js_success-popup" style="margin-left:5px">Cancel</a>
				</p>
			</form>
            
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
                                        <a href="index.php"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a>Patient</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="index.php">Patient</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-body">

                    <div class="card">
                        <div class="card-header">
                            <!-- <h5>DOM/Jquery</h5>
                            <span>Events assigned to the table can be exceptionally useful for user interaction, however you must be aware that DataTables will add and remove rows from the DOM as they are needed (i.e. when paging only the visible elements are actually available in the DOM). As such, this can lead to the odd hiccup when working with events.</span> -->
                        </div>
                        <div class="card-block">
                            <div class="table-responsive dt-responsive">
                                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Admission details</th>
                                        <th>Address</th>
                                        <th>Patient Blood Pressure</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									
                                    $sql =$init->prepare("SELECT * FROM patient a,appointment b where app_status=0 and a.patientid=b.patientid and doctorid='$_SESSION[id]'");
                                    $sql->execute();
                                    $qsql = $sql->fetchAll();
                                    foreach($qsql as $rs)
                                    {
                                        $dob = substr($rs['id_number'],4,2).'-'.substr($rs['id_number'],2,2).'-';
                                        $year=(substr($rs['id_number'],0,2) <= 22) ? '19': '20'.substr($rs['id_number'],0,2);
										
										$sql2 =$init->prepare("SELECT * from appointment where patientid='$rs[patientid]' and blood_pressure='' and app_status=0");
                                        $sql2->execute();
                                        $brec = $sql2->fetchAll();
										
										if($sql2->rowCount() > 0 ){
										  $temp = '<i class="text-warning">Please Update Temperature</i>';
										}else{
										  $temp = '<i class="">'.$rs['blood_pressure'].'</i>';
										}

                                        echo "<tr>
                                                <td><strong>Names : </strong> $rs[fname] $rs[lname]<br>
                                                <strong>Email :</strong> $rs[email] </td>
                                                <td><strong>Addr : </strong>$rs[address]<br>
                                                <strong>Mob No : </strong>$rs[mobileno]</td>
                                                <td><strong>ID Number</strong> - $rs[id_number]<br>
                                                <strong>Gender</strong>: &nbsp;$rs[gender]<br>
                                                <strong>DOB : </strong> $dob$year</td>
                                                <td><strong>Blood Pressure : </strong>$temp  </td>
                                                <td align='center'>Status - $rs[status] <br>";
                                        if(isset($_SESSION['user']))
                                        {
                                            echo "<a href='index.php?edit_blood=$rs[patientid]' class='btn btn-primary'>Add Temperature</a>";
                                        }
                                        echo "</td></tr>";
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

        <div id="#">
        </div>
    </div>
</div>

<?php $pdo->close();include('../pages/alerts.php'); include('footer.php');?>

<script>
    var addButtonTrigger = function addButtonTrigger(el) {
        el.addEventListener('click', function () {
            var popupEl = document.querySelector('.' + el.dataset.for);
            popupEl.classList.toggle('popup--visible');
        });
    };

    Array.from(document.querySelectorAll('button[data-for]')).
    forEach(addButtonTrigger);
</script>