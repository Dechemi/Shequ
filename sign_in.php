<?php
require_once "header.php";

$show_signIn_form = false;
$wrong_detail_message = false;
$msg="";
$errors= "";

$username_err="";
$password_err="";

if (isset($_SESSION['loggedIn']))
{

    echo "你已经登录过了,请先登出<br>";
}
elseif(isset($_POST['username'])){

  $username = $_POST['username'];
  $password = $_POST['password'];


$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

  if(!$connection){
    die("Connection failed: " . $mysqli_connect_error);
  }


  $username = sanitise($username, $connection);
  $password = sanitise($password, $connection);
  
  $username_errors = validateString($username, 0, 32);
  $password_errors = validateString($password, 4, 64);

  $errors = $username_errors . $password_errors;
  
  if($errors == ""){
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    
    $result =  mysqli_query($connection, $query);

    $n = mysqli_num_rows($result);

    if($n >0){
      $row = mysqli_fetch_assoc($result);
      // 设置一个会话变量来记录该用户已成功登录：
      $_SESSION['loggedIn'] = true;

      $_SESSION['username'] = $username;
      $_SESSION['uid'] = $row['uid'];


      if(strtolower($_SESSION['username']) == 'admin'){
     header("Location: manage_posts.php");
      }
      else {
        header("Location: index.php");
      }

    } else {
      // 没有找到匹配的凭据，因此重新显示登录表单，并附带一个失败消息：
        $show_signIn_form = true;
        $wrong_detail_message = true;
    }
     mysqli_close($connection);
  }
  else {
    $show_signIn_form = true;
    $wrong_detail_message = true;
  }
}
else {
    $show_signIn_form = true;
}

if($show_signIn_form) {
echo <<<_END
<div class="container-fluid body">
  <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5 logo">
        <img src="images/logo.png" class="img-fluid  list-inline"
            alt="Post it logo" width="480px" height="130px">
            <br><br>
        <h1>交流 · 触及 · 心灵 <br>&<br> 分享你的<b style=" color: #9E7757;">生活</b></h1>
            
        </div>

        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl">
              <form method="POST" action="sign_in.php">
_END;          

                if(!$wrong_detail_message){
                echo <<<_END
                <div class="divider d-flex align-items-center my-4">
                  <p class="text-center fw-bold mx-auto">请输入用户名和密码</p>
                </div>
_END;   
                }
                else {
                  echo <<<_END
                <div class="divider d-flex align-items-center my-4 text-center">
                  <p class="text-center fw-bold mx-auto link-danger">输入错误,请再次尝试</p>
                </div>
_END;
                }
                  echo <<<_END
              
                <div class="form-outline mb-4">
                  <label class="form-label" id="username" for="username">用户名</label>
                  <input type="text" name="username" class="form-control form-control-lg"
                    placeholder="请输入用户名" required/>
                </div>

                <div class="form-outline mb-1">
                  <label class="form-label" id="password" for="password">密码</label>
                  <input type="password" name="password" class="form-control form-control-lg"
                    placeholder="请输入密码" required/>
                
                </div>

                <div class="text-center text-lg-start mt-4 pt-2">
                  <button type="submit" class="btn btn-dark btn-lg"
                    style="padding-left: 2.5rem; padding-right: 2.5rem; background-color: rgb(166, 213, 255); color:#000000E6;; border-color: rgb(141, 196, 245);">登录</button>
                  <p class="small fw-bold mt-2 pt-1 mb-0">还没有账号? <a href="sign_up.php"
                      class="link-danger">前往注册</a></p>
                </div>
              </form>
          </div>
    </div>
</div>
_END;
}

echo '</body>
<footer class="page-footer font-small footer"  style="background-color:black; color:aliceblue; width: 100%;  position: absolute; bottom: 0;">
  <div class="footer-copyright text-center py-3">© 2023 版权所有: wc sjx
  </div>
<script src="js/custom.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</footer>';
?>