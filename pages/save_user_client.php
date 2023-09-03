
<?php
session_start();
$current_date = date('Y-m-d');
$return = $_SERVER['HTTP_REFERER'];
include('../connect2.php');
$init = $pdo->open();

if(isset($_POST['btn_signup'])){
    if($_POST['password'] !=$_POST['confirm-password']){
        $_SESSION['error'] = 'Password does not match';
        header('location: ../signup.php');
        exit(0);
    }
    if(checkPassword($_POST['password']==false)){
        $_SESSION['error'] = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
        header('location: ../signup.php');
        exit(0);
    }
    $email=$_POST['email'];

    $sql = $init->prepare("SELECT * FROM admin WHERE email = :email");
    $sql->execute(['email'=>$email]);
    $row = $sql->fetch();

    if($sql->rowCount() >0){
        $_SESSION['error']= 'Email already exists.';
        header('location: '.$return);
        exit(0);
    }

    
    $sql = $init->prepare("SELECT * FROM doctor WHERE email = :email");
    $sql->execute(['email'=>$email]);
    $row = $sql->fetch();

    if($sql->rowCount() >0){
        $_SESSION['error']= 'Email already exists.';
        header('location: '.$return);
        exit(0);
    }

    $sql = $init->prepare("SELECT * FROM pharmacy WHERE email = :email");
    $sql->execute(['email'=>$email]);
    $row = $sql->fetch();

    if($sql->rowCount() >0){
        $_SESSION['error']= 'Email already exists.';
        header('location: '.$return);
        exit(0);
    }

    $sql = $init->prepare("SELECT * FROM patient WHERE email = :email");
    $sql->execute(['email'=>$email]);
    $row = $sql->fetch();

    if($sql->rowCount() >0){
        $_SESSION['error']= 'Email already exists.';
        header('location: '.$return);
        exit(0);
    }

    $passw = hash('sha256', $_POST['password']);

    $salt = createSalt();
    $pass = $_POST['password'];
    $id = $_POST['id_number'];
    $month = substr($id,2,2);
    $day = substr($id,4,2);
    $gender=  substr($id,6,1) >= 5 ? 'male': 'female';
    $dob= $day.'-'.$month.'-'.substr($id,0,2) <= 22 ? '19': '20'.substr($id,0,2);


    try{

        $sql =$init->prepare("INSERT INTO patient (id_number,fname, lname,email,password, gender,  age,mobileno,address,status,delete_status)
                VALUES ('$_POST[id_number]','$_POST[fname]','$_POST[lname]','$_POST[email]','$pass','$gender','$_POST[age]','$_POST[contact]','$_POST[addr]',0,0)");
        if ($sql->execute()) {
            $_SESSION['success'] = 'Registration Successful';
            header('location: ../login.php');
        }else{
            $_SESSION['error'] = $sql->execute();
            header('location: ../signup.php');
        }

    }catch (Exception $exception){
        $_SESSION['error'] = $exception->getMessage();
        header('location: ../signup.php');
    }
}


if(isset($_POST['btn_login']))
{
    $email = $_POST['email'];
    $count='';
    $passw = hash('sha256', $_POST['password']);

    $salt = createSalt();
    $pass = $_POST['password'];
    $url='index.php';

    if($_POST['user'] == 'admin'){
        $sql = $init->prepare("SELECT * FROM admin WHERE email='" .$email . "' and password = '". $pass."'");
        $result = $sql->execute();
        $row  = $sql->fetch();
        $count=$sql->rowCount();
        if($sql->rowCount() > 0){
            $_SESSION["adminid"] = $row['id'];
            $_SESSION["id"] = $row['id'];
            $_SESSION["username"] = $row['username'];
            $_SESSION["password"] = $row['password'];
            $_SESSION["email"] = $row['email'];
            $_SESSION["fname"] = $row['fname'];
            $_SESSION["lname"] = $row['lname'];
            $_SESSION['image'] = $row['image'];
            $_SESSION['user'] = $_POST['user'];
            $url='../index.php';
        }

    }else if($_POST['user'] == 'doctor'){
        $sql = $init->prepare("SELECT * FROM doctor WHERE email='" .$email . "' and password = '". $pass."'");
        $result = $sql->execute();
        $row  = $sql->fetch();
        $count=$sql->rowCount();
        if($sql->rowCount() > 0) {
            if($row['status']!='Active'){
                $_SESSION['error'] = 'Account not yet active';
                header('location: ../login.php');
                exit(0);
            }else{
                $_SESSION["doctorid"] = $row['doctorid'];
                $_SESSION["id"] = $row['doctorid'];
                $_SESSION["password"] = $row['password'];
                $_SESSION["email"] = $row['email'];
                $_SESSION["fname"] = $row['doctorname'];
                $_SESSION['user'] = $_POST['user'];
                $url = '../doctor/view-patient.php';
            }

        }
    }else if($_POST['user'] == 'pharmacy'){
        $sql = $init->prepare("SELECT * FROM pharmacy WHERE email='" .$email . "' and password = '". $pass."'");
        $result = $sql->execute();
        $row  = $sql->fetch();
        $count=$sql->rowCount();
        if($sql->rowCount() > 0) {
            if($row['status']!='Active'){
                $_SESSION['error'] = 'Account not yet active';
                header('location: ../login.php');
                exit(0);
            }else{
                $_SESSION["pharmacyid"] = $row['pharmacyid'];
                $_SESSION["id"] = $row['pharmacyid'];
                $_SESSION["password"] = $row['password'];
                $_SESSION["email"] = $row['email'];
                $_SESSION["fname"] = $row['fname'];
                $_SESSION['user'] = $_POST['user'];
                $url = '../pharmacy/';
            }

        }
    }else if($_POST['user'] == 'patient'){
        $sql = $init->prepare("SELECT * FROM patient WHERE email='" .$email . "' and password = '". $pass."'");
        $result = $sql->execute();
        $row  = $sql->fetch();
        $count=$sql->rowCount();
        if($sql->rowCount() > 0) {
            if($row['status']!='Active'){
                $_SESSION['error'] = 'Account not yet active';
                header('location: ../login.php');
                exit(0);
            }else{
                $_SESSION["patientid"] = $row['patientid'];
                $_SESSION["id"] = $row['patientid'];
                $_SESSION["password"] = $row['password'];
                $_SESSION["email"] = $row['email'];
                $_SESSION["fname"] = $row['fname'];
                $_SESSION["lname"] = $row['lname'];
                $_SESSION['user'] = $_POST['user'];
                $url = '../patient/';
            }

        }
    }

    if($count==1 && isset($_SESSION["email"]) && isset($_SESSION["password"])) {

      $_SESSION['success'] = 'Login Successfully';
        header('location:'.$url);
    }else{
        $_SESSION['error'] = 'Invalid Email or Password';
        header('location:'.$return);
    }

}



function createSalt()
{
    return '2123293dsj2hu2nikhiljdsd';
}

function checkPassword($password){

    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        return false;
    }else{
        return true;
    }
}

//$image = $_FILES['image']['name'];
//$target = "../uploadImage/Profile/".basename($image);
//
//if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
//    // @unlink("uploadImage/Profile/".$_POST['old_image']);
//    $msg = "Image uploaded successfully";
//}else{
//    $msg = "Failed to upload image";
//}


$pdo->close();

