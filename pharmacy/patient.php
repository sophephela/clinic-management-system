
<?php require_once('check_login.php');include('head.php');include('header.php');include('sidebar.php');
include('../connect2.php');

    $init = $pdo->open();

if(isset($_GET['confirm_collection']))
{
    $sql =$init->prepare("SELECT * FROM appointment WHERE appointmentid='$_GET[confirm_collection]'");
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
                                    <h4>Confirm Patient Prescription Collection</h4>
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

                                    <div class="card-block">
                                        <div class="table-responsive dt-responsive">
                                            <?php if($sql->rowCount() > 0){?>
                                            <h5>Please click on the confirm button below to confirm that the patient has collected the prescibed medication.</h5>
                                            <textarea class="form-control black" placeholder="<?php echo $rsedit['prescription']?>" style="width: 100%" disabled></textarea><br>
                                            <form method="post" action="sql.php">
                                                <input name="confirm_collection" value="<?php echo $_GET['confirm_collection'] ?>" hidden>
                                                <button class="btn btn-success">Confirm Collection</button>
                                            </form>
                                            <?php }else{
                                                echo "<h5>Not Found</h5>";
                                            }?>

                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include('../pages/alerts.php');include('footer.php');?>

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

    $('.confirm-pill').click(function(){

        console.log(this.id);
    });

</script>