<?php
require_once "header.php";


$show_signUp_form = false;
$errors= "";

$username_err="";
$password_err="";
$nikname_rrr="";
$sid_err="";
$email_err="";
$age_err="";
$specialty_err="";
$phone_err="";

if(isset($_POST['update'])){
if (strtolower($_SESSION['username']) == 'admin')
{
    

  $uid = $_POST['uid'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $nickname = $_POST['nickname'];
  $stdid = $_POST['stdid'];
  $email = $_POST['email'];
  $age = $_POST['age'];
  $specialty = $_POST['specialty'];
  $phone = $_POST['phone'];


  $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);


  if(!$connection){
    die("Connection failed: " . $mysqli_connect_error);
  }

  //输入验证
  $username = sanitise($username, $connection);
  $password = sanitise($password, $connection);
  $nickname = sanitise($nickname , $connection);
  $stdid = sanitise($stdid, $connection);
  $email = sanitise($email, $connection);
  $specialty = sanitise($specialty, $connection);
  
  $username_errors = validateString($username, 3, 32);
  $password_errors = validateString($password, 4, 64);
  $nickname_errors = validateString($nickname, 1, 64);
  $stdid_errors = validateString($stdid, 1, 64);
  $email_errors = validateString($email, 3, 128);
  $age_errors = validateInt($age, 1, 150);
  $specialty_errors = validateString($specialty, 1, 32);
  $phone_errors = validateString($phone, 4, 14);

  $errors = $username_errors . $password_errors . $nickname_errors . $stdid_errors . $email_errors . $age_errors . $specialty_errors . $phone_errors;
  // echo $errors;
  if($errors == ""){
    $query = "UPDATE users SET username = '{$username}', password = '{$password}', nickname = '{$nickname}', stdid = '{$stdid}', email = '{$email}', age = '{$age}', specialty = '{$specialty}', phone = '{$phone}'  WHERE uid = '{$uid}'";
    
    $result =  mysqli_query($connection, $query);

    if($result){
        echo "<script>alert('修改用户成功'); window.location.href = 'manage_users.php';</script>";
    }
    else {

            $show_signup_form = true;

            $msg = "没有找到该用户信息,请重新尝试<br>";
    }

     mysqli_close($connection);
  }
  else {
    echo "<b>修改失败";
    echo "<br><br></b>";
    $show_signup_form = true;
  }
}
}
else {
    $show_signUp_form = true;
}

if($show_signUp_form){
  echo '<!-- Log in form container  -->
<div class="container-fluid body">
  <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5 logo">
        <img src="images/logo.png" class="img-fluid  list-inline"
        alt="Post it logo" width="480px" height="130px">
    <h1>交流 · 触及 · 心灵 <br>&<br> 分享你的<b style=" color: #9E7757;">生活</b></h1>
        </div>

        <div class="col-7 col-sm-6  col-md-5 col-lg-4 col-lg-4 offset-xl">
              <form method="POST" action="edit_user.php">

                 <!-- Instruction -->
                <div class="divider d-flex align-items-center my-4">
                  <p class="text-center fw-bold mx-auto">修改信息</p>
                </div>

                
                <div class="form-outline mb-4">
                <label class="form-label" id="uid" for="uid">Uid</label>
                  <input type="text" name="uid" value="'.$_POST['uid'].'" class="form-control form-control-md" maxlength="3" required/>
                </div>

                <div class="form-outline mb-4">
                <label class="form-label" id="username" for="username">用户名</label>
                  <input type="text" name="username" value="'.$_POST['username'].'" class="form-control form-control-md" maxlength="32" required/>
                </div>

                
                <div class="form-outline mb-3">
                <label class="form-label" id="password" for="form3Example4">密码</label>
                  <input type="text" name="password" value="'.$_POST['password'].'" class="form-control form-control-md" maxlength="64" required/>
                </div>
                
                
                <div class="form-outline mb-4">
                <label class="form-label" id="nickname" for="nickname">昵称</label>
                  <input type="text" name="nickname" value="'.$_POST['nickname'].'" class="form-control form-control-md" maxlength="64" required/>
                </div>

                
                <div class="form-outline mb-4">
                <label class="form-label" id="stdid" for="stdid">学号</label>
                  <input type="text" name="stdid" value="'.$_POST['stdid'].'" class="form-control form-control-md" maxlength="64" required/>
                </div>

                
                <div class="input-outline mb-3">
                <label class="form-label" id="email" for="email">邮箱</label>
                  <input type="email" name="email" value="'.$_POST['email'].'" class="form-control form-control-md" maxlength="128" required/>
                </div>

                
                <div class="form-outline mb-4">
                <label class="form-label" id="age" for="age">年龄</label>
                  <input type="number" name="age" class="form-control form-control-md" value="'.$_POST['age'].'" min="0" max="150" required/>
                </div>

                
                <div class="form-outline mb-4">
                <label class="form-label" id="specialty" for="specialty">专业</label>
                  <input type="text" name="specialty" class="form-control form-control-md" value="'.$_POST['specialty'].'" maxlength="32" required/>
                </div>

                
                
                <div class="form-outline mb-4">
                <label class="form-label" id="phone" for="phone">电话</label>
                  <input type="number" name="phone" class="form-control form-control-md" value="'.$_POST['phone'].'" minlength="4" maxlength="24" required/>
                </div>
                
                
                <div class="text-center text-lg-start mt-4 pt-2">
                  <button type="submit" name="update" class="btn btn-dark btn-lg" style="margin-bottom: 2em; background-color: rgb(166, 213, 255); color:#000000E6;; border-color: rgb(141, 196, 245);">修改</button>
                </div>
              </form>
          </div>
    </div>
</div>';
}
require_once "footer.php";
?>