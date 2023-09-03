<?php require_once('check_login.php');?>
<?php include('head.php');?>
<?php include('header.php');?>
<?php include('sidebar.php');?>
<?php include('connect2.php');

$init = $pdo->open();
if(isset($_POST['btn_submit']))
{
    if(isset($_GET['editid']))
    {
        $sql =$init->prepare("UPDATE patient SET fname='$_POST[fname]',lname='$_POST[lname]',
        address='$_POST[address]',mobileno='$_POST[mobilenumber]',id_number='$_POST[id_number]',email='$_POST[email]',blood_pressure='$_POST[blood_pressure]',gender='$_POST[gender]',status='$_POST[status]' WHERE patientid='$_GET[editid]'");
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
                    <p>Patient Record Updated Successfully</p>
                    <p>
                        <!--  <a href="index.php"><button class="button button--success" data-for="js_success-popup"></button></a> -->
                        <?php echo "<script>setTimeout(\"location.href = 'view-patient.php';\",1500);</script>"; ?>
                    </p>
                </div>
            </div>
            <?php
        }
    }
    else
    {
        $pass = $_POST['password'];
        $sql =$init->prepare("INSERT INTO patient(fname,lname,address,mobileno,id_number,email,password,gender,status) 
        values('$_POST[fname]','$_POST[lname]','$_POST[address]','$_POST[mobilenumber]','$_POST[id_number]','$_POST[email]','$pass','$_POST[gender]','$_POST[status]')");
        if($sql->rowCount() > 0)
        {
            ?>
            <div class="popup popup--icon -success js_success-popup popup--visible">
                <div class="popup__background"></div>
                <div class="popup__content">
                    <h3 class="popup__content__title">
                        Success
                    </h3>
                    <p>Patient Record Inserted Successfully</p>
                    <p>
                        <!--  <a href="index.php"><button class="button button--success" data-for="js_success-popup"></button></a> -->
                        <?php echo "<script>setTimeout(\"location.href = 'view-patient.php';\",1500);</script>"; ?>
                    </p>
                </div>
            </div>
            <?php
        }
    }
}
if(isset($_GET['editid']))
{
    $sql=$init->prepare("SELECT * FROM patient WHERE patientid='$_GET[editid]' ");
    $sql->execute();
    $rsedit = $sql->fetch();

}

?>
<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

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
                                    <!-- <span>Lorem ipsum dolor sit <code>amet</code>, consectetur adipisicing elit</span> -->
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
                                    <li class="breadcrumb-item"><a href="add_user.php">Patient</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="card">
                                <div class="card-header">
                                    <!-- <h5>Basic Inputs Validation</h5>
                                    <span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span> -->
                                </div>
                                <div class="card-block">
                                    <form id="main" method="post" action="" enctype="multipart/form-data">

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Patient Name</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="fname" id="name" placeholder="Enter name...." required=""  value="<?php if(isset($_GET['editid'])) { echo $rsedit['fname']; } ?>" >
                                                <span class="messages"></span>
                                            </div>

                                            <label class="col-sm-2 col-form-label">Patient Surname</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="lname" id="surname" placeholder="Enter surname...." required=""  value="<?php if(isset($_GET['editid'])) { echo $rsedit['lname']; } ?>" >
                                                <span class="messages"></span>
                                            </div>


                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Mobile No</label>
                                            <div class="col-sm-4">
                                                <input type="number" class="form-control" name="mobilenumber" id="mobilenumber" placeholder="Enter mobilenumber...." required="" value="<?php echo $rsedit['mobileno']; ?>">
                                                <span class="messages"></span>
                                            </div>

                                            <label class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-4">
                                                <input class="form-control" type="text" name="email" id="email"
                                                       value="<?php if(isset($_GET['editid'])) { echo $rsedit['email']; } ?>" />
                                                <span class="messages"></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">


                                            <label class="col-sm-2 col-form-label">Blood Pressure</label>
                                            <div class="col-sm-4">
                                                <input class="form-control" type="text" name="blood_pressure" id="blood_pressure"
                                                       value="<?php if(isset($_GET['editid'])) { echo $rsedit['blood_pressure']; } ?>" />
                                                <span class="messages"></span>
                                            </div>

                                            <label class="col-sm-2 col-form-label">ID Number</label>
                                            <div class="col-sm-4">
                                                <input class="form-control" type="text" name="id_number" id="id_number" maxlength="13" minlength="13" onkeypress="return /[0-9]/i.test(event.key)"
                                                       value="<?php if(isset($_GET['editid'])) { echo $rsedit['id_number']; } ?>" />
                                                <span class="messages"></span>
                                            </div>

                                        </div>

                                        <div class="form-group row">


                                            <label class="col-sm-2 col-form-label">Status</label>
                                            <div class="col-sm-4">

                                                <select name="status" id="status" class="form-control" required="">
                                                    <option value="" disabled>-- Change Status -- </option>
                                                    <option value="Active" <?php if(isset($_GET['editid']))
                                                    { if($rsedit['status'] == 'Active') { echo 'selected'; } } ?>>Active</option>
                                                    <option value="0" <?php if(isset($_GET['editid']))
                                                    { if($rsedit['status'] == 0) { echo 'selected'; } } ?>>Not Active</option>
                                                </select>
                                            </div>

                                            <label class="col-sm-2 col-form-label">Gender</label>
                                            <div class="col-sm-4">
                                                <select name="gender" id="gender" class="form-control" required="">
                                                    <option value="" disabled>-- Select One -- </option>
                                                    <option value="Male" <?php if(isset($_GET['editid']))
                                                    { if($rsedit['gender'] == 'Male') { echo 'selected'; } } ?>>Male</option>
                                                    <option value="Female" <?php if(isset($_GET['editid']))
                                                    { if($rsedit['gender'] == 'Female') { echo 'selected'; } } ?>>Female</option>
                                                </select>
                                            </div>
                                        </div>

                                        <?php
                                        if(!isset($_GET['editid']))
                                        {
                                            ?>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Password</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control" type="password" name="password" id="password"/>
                                                    <span class="messages"></span>
                                                </div>

                                                <label class="col-sm-2 col-form-label">Confirm Password</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control" type="password" name="cnfirmpassword" id="cnfirmpassword"/>
                                                    <span class="messages" id="confirm-pw" style="color: red;"></span>
                                                </div>
                                            </div>
                                        <?php } ?>


                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Address</label>
                                            <div class="col-sm-10">
                                                <textarea name="address" id="address" class="form-control"><?php if(isset($_GET['editid'])) { echo $rsedit['address']; } ?></textarea>
                                            </div>

                                        </div>



                                        <div class="form-group row">
                                            <label class="col-sm-2"></label>
                                            <div class="col-sm-10">
                                                <button type="submit" name="btn_submit" class="btn btn-primary m-b-0">Submit</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php');?>

<script type="text/javascript">
    $('#main').keyup(function(){
        $('#confirm-pw').html('');
    });

    $('#cnfirmpassword').change(function(){
        if($('#cnfirmpassword').val() != $('#password').val()){
            $('#confirm-pw').html('Password Not Match');
        }
    });

    $('#password').change(function(){
        if($('#cnfirmpassword').val() != $('#password').val()){
            $('#confirm-pw').html('Password Not Match');
        }
    });
</script>