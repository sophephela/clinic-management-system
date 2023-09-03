<?php require_once('check_login.php');
include('head.php');
include('header.php');
include('sidebar.php');
include('connect.php');
include('../pages/alerts.php');

$q = "select * from  pharmacy where pharmacyid = '".$_SESSION['id']."'";
$q1 = $conn->query($q);
while($row = mysqli_fetch_array($q1)){
    extract($row);
    $db_pass = $row['password'];
}

if(isset($_POST["btn_password"])){

    $old = hash('sha256',$_POST['old_password']);
    $pass_new = hash('sha256', $_POST['new_password']);
    $confirm_new = hash('sha256', $_POST['confirm_password']);
//$passw = hash('sha256',$p);
//echo $pass_new;
    function createSalt()
    {
        return '2123293dsj2hu2nikhiljdsd';
    }
    $salt = createSalt();
    $old_pass =  hash('sha256', $salt . $old);
    $new_pass =  hash('sha256', $salt . $pass_new);
    $confirm =  hash('sha256', $salt . $confirm_new);

    if($db_pass!=$old_pass){ ?>
        <?php $_SESSION['error']='Old Password not matched';?>
        <!--  <script>
         alert('OLD Paasword not matched');
         </script> -->
    <?php } else if($new_pass!=$confirm){ ?>
        <?php $_SESSION['error']='NEW Password and CONFIRM password not Matched';?>
        <!--  <script>
         alert('NEW Password and CONFIRM password not Matched');
         </script> -->
    <?php } else {
        $sql = "update  pharmacy set `password`='$confirm' where pharmacyid = '".$_SESSION['id']."'";

        $res = $conn->query($sql);
        $_SESSION['success'] = 'Password changed Successfully...';
    }
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
                                    <h4>Change Password</h4>
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
                                    <li class="breadcrumb-item"><a href="changepassword.php">Change Password</a>
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
                                    <form id="main" method="POST">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Old Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" id="password" name="old_password" placeholder="Old Password" required="">
                                                <span class="messages"></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">New Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" id="password" name="new_password" placeholder="Password input" required="">
                                                <span class="messages"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Confirm Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" id="repeat-password" name="confirm_password" placeholder="Confirm Password" required="">
                                                <span class="messages"></span>
                                            </div>
                                        </div>






                                        <div class="form-group row">
                                            <label class="col-sm-2"></label>
                                            <div class="col-sm-10">
                                                <button type="submit" name="btn_password" class="btn btn-primary m-b-0">Submit</button>
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
