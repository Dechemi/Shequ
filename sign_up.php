<?php
require_once "header.php";


$show_signUp_form = false;//验证标记,默认失败
$msg="";
$errors= "";

$username_err="";
$password_err="";
$nikname_err="";
$sid_err="";
$email_err="";
$age_err="";
$specialty_err="";
$phone_err="";


if (isset($_SESSION['loggedIn']))
{
    echo "你已经登录过了,请先退出登录<br>";

}
elseif(isset($_POST['username'])){


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

 //防止sql注入攻击
  $username = sanitise($username, $connection);
  $password = sanitise($password, $connection);
  $nickname = sanitise($nickname , $connection);
  $stdid = sanitise($stdid, $connection);
  $email = sanitise($email, $connection);
  $specialty = sanitise($specialty, $connection);
  
  //服务器端验证，检查长度
  $username_errors = validateString($username, 0, 32);
  $password_errors = validateString($password, 4, 64);
  $nickname_errors = validateString($nickname, 1, 64);
  $stdid_errors = validateString($stdid, 1, 64);
  $email_errors = validateString($email, 3, 128);
  $age_errors = validateInt($age, 1, 150);
  $specialty_errors = validateString($specialty, 1, 32);
  $phone_errors = validateString($phone, 4, 14);

  $errors = $username_errors . $password_errors . $nickname_errors . $stdid_errors . $email_errors . $age_errors . $specialty_errors . $phone_errors;
  echo $errors;
  if($errors == ""){

    $count_query = "SELECT * FROM users";

    $query = "INSERT INTO users(username,password,nickname,stdid,email,age,specialty,phone) VALUES('$username','$password','$nickname','$stdid','$email','$age','$specialty','$phone')";
    
    $result =  mysqli_query($connection, $query);

    if($result){
        echo "<div class='text-center fw-bold p-4'> 注册成功!.<br> <a href='index.php'> 点击查看 </a> 所有话题.</div>";


    }
    else {
            $show_signup_form = true;
            $msg = "注册失败, 请重新尝试<br>";
    }

     mysqli_close($connection);
  }
  else {
    echo "<b>注册失败";
    echo "<br><br></b>";
    $show_signup_form = true;
  }
}
else {
    $show_signUp_form = true;
}


if($show_signUp_form){
  echo <<<_END
  <!-- Log in form container  -->
<div class="container-fluid body">
  <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5 logo">
        <img src="images/logo.png" class="img-fluid  list-inline"
            alt="Post it logo" width="480px" height="130px">
        <h1>交流 · 触及 · 心灵 <br>&<br> 分享你的<b style=" color: #9E7757;">生活</b></h1>
            
        </div>

        <div class="col-7 col-sm-6  col-md-5 col-lg-4 col-lg-4 offset-xl">
              <form method="POST" action="sign_up.php">

                <div class="divider d-flex align-items-center my-4">
                  <p class="text-center fw-bold mx-auto">完善注册资料</p>
                </div>

                <div class="form-outline mb-4">
                <!-- <label class="form-label" id="username" for="username">用户名</label>-->
                  <input type="text" name="username" class="form-control form-control-md" placeholder="用户名" maxlength="32" required/>
                </div>

                <div class="form-outline mb-3">
                <!-- <label class="form-label" id="password" for="form3Example4">密码</label>-->
                  <input type="password" name="password" class="form-control form-control-md" placeholder="密码" maxlength="64" required/>
                </div>
                
                <div class="form-outline mb-4">
                <!-- <label class="form-label" id="nickname" for="nickname">昵称</label>-->
                  <input type="text" name="nickname" class="form-control form-control-md" placeholder="昵称" maxlength="64" required/>
                </div>

                <div class="form-outline mb-4">
                <!-- <label class="form-label" id="stdid" for="stdid">Stdid name</label>-->
                  <input type="text" name="stdid" class="form-control form-control-md" placeholder="学号" maxlength="64" required/>
                </div>

                <div class="input-group mb-3">
                <!-- <label class="form-label" id="email" for="email">Email</label>-->
                <span class="input-group-text" id="basic-addon1">@</span>
                  <input type="email" name="email" class="form-control form-control-md" placeholder="邮箱" maxlength="128" required/>
                </div>

                <div class="form-outline mb-4">
                <!-- <label class="form-label" id="age" for="age">Age</label>-->
                  <input type="number" name="age" class="form-control form-control-md" placeholder="年龄" min="0" max="150" required/>
                </div>

                <div class="form-outline mb-4">
                <!-- <label class="form-label" id="specialty" for="specialty">specialty</label>-->
                  <input type="text" name="specialty" class="form-control form-control-md" placeholder="专业" maxlength="32" required/>
                </div>
                
                <div class="form-outline mb-4">
                <!-- <label class="form-label" id="phone" for="phone">Phone</label>-->
                  <input type="number" name="phone" class="form-control form-control-md" placeholder="电话" minlength="4" maxlength="24" required/>
                </div>
                
                <div class="text-center text-lg-start mt-4 pt-2">
                  <button type="submit" class="btn btn-dark btn-lg"
                    style="padding-left: 2.5rem; padding-right: 2.5rem; background-color: rgb(166, 213, 255); color:#000000E6;; border-color: rgb(141, 196, 245);">注册</button>
                  <p class="small fw-bold mt-2 pt-1 mb-0">已有账号? <a href="sign_in.php"
                      class="text-primary">前往登录</a></p>
                  
                </div>
              </form>
          </div>
    </div>
</div>
_END;
}

echo $msg;
require_once "footer.php";
?>