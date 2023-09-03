<?php require_once('check_login.php');
include('head.php');
include('header.php');
include('sidebar.php');
include('connect.php');
include('../pages/alerts.php');

if(isset($_POST["btn_update"]))
{
    extract($_POST);

    $q1="UPDATE pharmacy SET `fname`='$_POST[fname]',`lname`='$_POST[lname]',`email`='$_POST[email]',`mobile`='$_POST[contact]' where pharmacyid = '".$_SESSION["id"]."'";

    if ($conn->query($q1) === TRUE) {

        $_SESSION['success']='Record Successfully Updated';

    } else {

        $_SESSION['error']=$conn->error;
    }


    ?>
    <script>

    </script>
    <?php
}

?>

<?php

$que="select * from  pharmacy where pharmacyid = '".$_SESSION["id"]."'";
$query=$conn->query($que);
while($row=mysqli_fetch_array($query))
{
    //print_r($row);
    extract($row);
    $fname = $row['fname'];
    $lname = $row['lname'];
    $email = $row['email'];
    $contact = $row['mobile'];

}
?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">

        <div class="main-body">
            <div class="page-wrapper">

                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Profile</h4>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="dashboard.php"> <i class="feather icon-home"></i> </a>

                                    <li class="breadcrumb-item"><a href="profile.php">Profile</a>
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

                                </div>
                                <div class="card-block">
                                    <form id="main" method="post" enctype="multipart/form-data">

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">First Name</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="fname" id="fname" value="<?php echo $fname; ?>"  placeholder="Enter first name....">
                                                <span class="messages"></span>
                                            </div>

                                            <label class="col-sm-2 col-form-label">Last Name</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="lname" id="lname" value="<?php echo $lname; ?>"  placeholder="Enter last name....">
                                                <span class="messages"></span>
                                            </div>


                                        </div>


                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-4">
                                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" placeholder="Enter valid e-mail address..." pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" >
                                                <span class="messages"></span>
                                            </div>

                                            <label class="col-sm-2 col-form-label">Contact</label>
                                            <div class="col-sm-4">
                                                <input type="tel" class="form-control" id="contact" name="contact" value="<?php echo $contact;?>" placeholder="Enter valid contact number..." minlength="10" maxlength="10" >
                                                <span class="messages"></span>
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2"></label>
                                            <div class="col-sm-10">
                                                <button type="submit" name="btn_update" class="btn btn-primary m-b-0">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <?php include('footer.php');?>
