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
$rowCount =0;
?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
<div class="pcoded-content">
    <div class="pcoded-inner-content">

        <div class="main-body">
            <div class="page-wrapper">

                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Reports</h4>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="index.php"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a>Reports</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="reports.php">Reports</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-body">

                    <div id="summery-report" class="card summery-report">
                        <div class="card-header">
							<div>
								<label>Select type of report</label>
								<select  class="form-control" onchange="window.location.href='?reportType='+$(this).val()">
									<option value="">Select report type</option>
									<option <?php if(isset($_GET['reportType']) && $_GET['reportType']=='summery'){ echo 'selected'; }?> value="summery">Overall Summery</option>
									<option <?php if(isset($_GET['reportType']) && $_GET['reportType']=='history'){ echo 'selected'; }?> value="history">Patients history</option>
									<option <?php if(isset($_GET['reportType']) && $_GET['reportType']=='appointment'){ echo 'selected';} ?> value="appointment">Total appointments</option>
									<option
										<?php if(isset($_GET['reportType']) && $_GET['reportType']=='department'){ echo 'selected';} ?> value="department">Department Summery
									</option>

								</select>
							</div>
                        </div>
                        <div class="card-block">
                            <div class="table-responsive dt-responsive">
								<!--Overall -->
								<?php 
								 if(isset($_GET['reportType']) && $_GET['reportType'] =="appointment"){
								
								   ?>
								<div class=" ">
									<label>Select date range</label>
									<br/>
									<div class="col-sm-12" style="display: flex">
										<div>
											<label>From</label>
											<input type="date" value="<?php if(isset($_GET['from'])) echo $_GET['from']; ?>" class="form-control col-sm-12" onchange="window.location.href='?reportType=<?php echo $_GET['reportType'] ?>&from='+$(this).val()">
										</div>
										
										<?php 
										  if(isset($_GET['from']) && $_GET['from']!=''){?>
										<div>
											<label>To</label>
											<input type="date" value="<?php if(isset($_GET['to'])) echo $_GET['to']; ?>" class="form-control col-sm-12" onchange="window.location.href='?reportType=<?php echo $_GET['reportType'].'&from='.$_GET['from'] ?>&to='+$(this).val()">
											</div>
										
										<?php }?>
									</div>
									
								</div>
								<br/>
								<?php if(isset($_GET['from']) && isset($_GET['to']) ){?>
								<div class="">
									<h2>Patient Appointment Report</h2>
								</div>
								<table id="dom-jqry" class="table table-striped table-bordered nowrap">
									<thead>
										<tr>
											<th>Patient Name</th>
											<th>Appointment Date</th>
											<th>Patient Blood Pressure</th>
											<th>Reason</th>
											<th>Prescription</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<?php
                                    $sql =$init->prepare("SELECT * FROM appointment,patient WHERE appointment.patientid=patient.patientid  AND app_status in (2,3,4) AND booking_date BETWEEN '$_GET[from]' AND '$_GET[to]'");
                                    $sql->execute();
                                    $qsql = $sql->fetchAll();
                                    foreach($qsql as $rs)
                                    {
									$rowCount++;
                                        $dob = substr($rs['id_number'],4,2).'-'.substr($rs['id_number'],2,2).'-';
                                        $year=((substr($rs['id_number'],0,2) > 22) ? '19': '20').substr($rs['id_number'],0,2);
                                        $temp = $rs['blood_pressure']==null?'<i class="text-warning">Please Update Temperature</i>':'<i class="">'.$rs['blood_pressure'].'</i>';;

                                        echo "<tr>
                                                <td><strong>Names : </strong> $rs[fname] $rs[lname]<br>
                                                <strong>Email :</strong> $rs[email] <br>
                                                <strong>Addr : </strong>$rs[address]<br>
                                                <strong>Mob No : </strong>$rs[mobileno]<br>
                                                
                                                <strong>Gender</strong>: &nbsp;$rs[gender]<br>
                                                <strong>DOB : </strong> $dob$year</td>
                                                <td>$rs[appointment_date]</td>
                                                <td>$temp  </td>
                                                <td>$rs[reason]</td>
                                                <td>$rs[prescription]</td>
                                                <td align='center'>";
                                        if($rs['app_status']==2)
                                        {
                                            echo "<i class='text-warning'>Pending Medication Collection</i>";
                                        }
										if($rs['app_status']==3){
                                            echo "<i class='text-success'>Collected</i>";
                                        }
										if($rs['app_status']==4){
                                            echo "<i class='text-danger'>Missed Appointment</i>";
                                        }
                                        echo "</td></tr>";
                                    }
                                    ?>
									</tbody>
								</table>

								<?php }
								}
								?>

								<!--End Overall -->







								<!--history -->
								<?php 
								 if(isset($_GET['reportType']) && $_GET['reportType'] =="history"){
								
								   ?>
								<div class=" ">
									<label>Filter By Age</label>
									<br/>
									<div class="col-sm-12" style="display: flex">
										<div>
											<label>From</label>
											<input type="date" value="<?php if(isset($_GET['from'])) echo $_GET['from']; ?>" class="form-control col-sm-12" onchange="window.location.href='?reportType=<?php echo $_GET['reportType'] ?>&from='+$(this).val()">
										</div>

										<?php 
										  if(isset($_GET['from']) && $_GET['from']!=''){?>
										<div>
											<label>To</label>
											<input type="date" value="<?php if(isset($_GET['to'])) echo $_GET['to']; ?>" class="form-control col-sm-12" onchange="window.location.href='?reportType=<?php echo $_GET['reportType'].'&from='.$_GET['from'] ?>&to='+$(this).val()">
										</div>

										<?php }?>
									</div>

								</div>
								<br/>
								<?php if(isset($_GET['from']) && isset($_GET['to']) ){?>
								<div class="">
									<h2>Patients Details Report</h2>
								</div>
								<table id="dom-jqry" class="table table-striped table-bordered nowrap" style="width: 100%">
									<thead>
										<tr>
											<th>Patient Name</th>
											<th>Id Number</th>
											<th>Email</th>
											<th>Address</th>
											<td>Mobile</td>
											<th>No. of Visits</th>
										</tr>
									</thead>
									<tbody>
										<?php
                                   $sql = $init->prepare("SELECT DISTINCT appointment.patientid,COUNT(appointment.patientid) AS countVisit,mobileno,address,email,id_number,fname,lname
														   FROM appointment
														   INNER JOIN patient ON appointment.patientid = patient.patientid");
									$sql->execute();
									$qsql = $sql->fetchAll();

									$to = substr($_GET['to'], 0, 4);
									$from = substr($_GET['from'], 0, 4);

									foreach ($qsql as $rs) {
									$rowCount++;
										$dob = substr($rs['id_number'], 4, 2) . '-' . substr($rs['id_number'], 2, 2) . '-';
										$year = ((substr($rs['id_number'], 0, 2) > 22) ? '19' : '20') . substr($rs['id_number'], 0, 2);
										if ($from < $year && $to > $year) {
											echo "<tr>
													<td><strong>Names:</strong> $rs[fname] $rs[lname]</td>
													<td><strong>ID Number:</strong> $rs[id_number]</td>
													<td><strong>Email:</strong> $rs[email]</td>
													<td><strong>Addr:</strong> $rs[address]</td>
													<td><strong>Mob No:</strong> $rs[mobileno]</td>
													<td>$rs[countVisit]</td>
												</tr>";
										}
									}

                                    ?>
									</tbody>
								</table>

								<?php }
								}
								?>

								<!--End history -->




								<!--Overview -->
								<?php 
								 if(isset($_GET['reportType']) && $_GET['reportType'] =="summery"){
								
								   ?>
								
								<br/>
					
								<div class="">
									<h2>Overview Report</h2>
								</div>


								<div class="pcoded-contents">
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
																			<h6 class="text-white m-b-0">
																				Performing Admin
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

																			<h4 class="text-white">
																				RS.
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
														<div class="col-md-6" hidden="">
															<div class="card">
																<div class="card-header">
																	<h5>Appointment</h5>

																</div>
																<div class="card-block">
																	<div class="ct-chart1 ct-perfect-fourth"></div>
																</div>
															</div>
														</div>

														<div class="col-md-6" hidden="">
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
										   $rowCount++;
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




							<?php }?>

								<!--End overall -->




							<!--department -->
							<?php 
								 if(isset($_GET['reportType']) && $_GET['reportType'] =="department"){
								
								   ?>
							<div class=" ">
								<label>Filter By Department</label>
								<br/>
								<div class="col-sm-12" style="display: flex">
									<select class="form-control" onchange="window.location.href='?reportType=<?php echo $_GET['reportType'] ?>&dep='+$(this).val()">
										<option value="" selected disabled>-- All --</option>
										<?php
                                            $sqldepartment= $init->prepare("SELECT * FROM department WHERE status='Active'");
                                            $sqldepartment->execute();
											$deps =$sqldepartment->fetchAll();
                                            foreach($deps as $dep)
                                            {
												    if(isset($_GET['dep']) && $dep['departmentid']==$_GET['dep']){
                                                     echo "<option value='$dep[departmentid]' selected>$dep[departmentname]</option>";
                                                    }else{
													 echo "<option value='$dep[departmentid]'>$dep[departmentname]</option>";
													}
                                            }
                                            ?>
									</select>
									
								</div>

							</div>
							<br/>
							
							<div class="">
								<h2>Department Summery Report</h2>
							</div>
							<table id="dom-jqry" class="table table-striped table-bordered nowrap" style="width: 100%">
								<thead>
									<tr>
										<th>Doctors Details</th>
										<th>Department Name</th>
										<th>Schedules</th>
										<th>Departement Description</th>

									</tr>
								</thead>
								<tbody>
									<?php
									

							        $sqlStr = "SELECT * FROM doctor,department WHERE doctor.departmentid=department.departmentid";
									if(isset($_GET['dep'])){
									  $sqlStr = "SELECT * FROM doctor,department WHERE doctor.departmentid=department.departmentid AND department.departmentid='$_GET[dep]'";
									}
													
									$sql2 = $init->prepare($sqlStr);
									$sql2->execute();
									$qsql2 = $sql2->fetchAll();	
									foreach ($qsql2 as $rs2) {
									$rowCount++;
											echo"<td><strong>Names : </strong> $rs2[doctorname]<br>
												<strong>Email :</strong> $rs2[email] <br>
												<strong>Mob No : </strong>$rs2[mobileno]<br>
												<strong>Experience : </strong>$rs2[experience]<br>
												<strong>Education : </strong>$rs2[education]
												</td><td>";
												
												$sql3 = $init->prepare("select * from doctor_timings,doctor where doctor_timings.doctorid='$rs2[doctorid]'");
												$sql3->execute();
												$qsql3 = $sql3->fetchAll();	
												foreach ($qsql3 as $rs3) {
											    echo" <span>$rs3[start_time] - $rs3[end_time]</span><br>";
											    }
												echo"</td><td>$rs2[departmentname]</td>
												<td>$rs2[description]</td></tr>";
									}

                                    ?>
								</tbody>
							</table>

							<?php }
								
								?>

							<!--End department -->
							
							
								
								
                            </div>
							
						</div>
                   
					</div>
					<?php if(isset($_GET['reportType']) && $rowCount>0){ ?>
					   <div class="row">
						   <button id="download" class="form-control btn btn-success"><i class="fa fa-download"></i> Donwload Report</button>
					   </div><br/>
					<?php }?>

                </div>

            </div>
        </div>

        <div id="#">
	
        </div>
    </div>
</div>

<?php $pdo->close();include('footer.php');?>

<script>
	var addButtonTrigger = function addButtonTrigger(el) {
	el.addEventListener('click', function () {
	var popupEl = document.querySelector('.' + el.dataset.for);
	popupEl.classList.toggle('popup--visible');
	});
	};

	Array.from(document.querySelectorAll('button[data-for]')).
	forEach(addButtonTrigger);


	window.onload = function () {
	document.getElementById("download")
	.addEventListener("click", () => {
	//$('#reloadDownload').modal('show');
	const report = this.document.getElementById("summery-report");

	//var name = document.getElementById('text-primary').innerText;
	var opt = {
	margin: 0.5,
	filename: 'report.pdf',
	image: { type: 'jpeg', quality: 1 },
	html2canvas: { scale: 2 },
	jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
	};

	setTimeout(function(){
	html2pdf().from(report).set(opt).save();
	},1000);


	});


	}
</script>