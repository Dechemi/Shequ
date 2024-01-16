<?php
require_once "header.php";
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$connection){
        die("Connection failed: " . $mysqli_connect_error);
}

$query = "SELECT * FROM users where username='{$_SESSION['username']}'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

if(isset($_SESSION['loggedIn'])){


    $query = "SELECT * FROM users";
    $result = mysqli_query($connection, $query);
    $n = mysqli_num_rows($result);

    if ($n>0){
        echo '<div class="jumbotron" style="background-color: rgb(23, 23, 23); padding: 40px;">
                    <div>
                        <h1 style="color: aliceblue;" class="display-3">Hello, '.$row['nickname'].'!</h1>
                        <h5 style="color: aliceblue;">管理用户的账号和信息</h5>
                    </div>
              </div>

        <div class="container" style="padding-top: 100px;">
             <div class="row" >
                <div class="table-responsive-sm table-responsive-md table-responsive-sm table-responsive-md table-responsive-lg table-responsive-lg">
                <table class="table">
                    <tr> <th scope="col">用户id</th><th scope="col">详细信息</th> <th scope="col"> 联系方式 </th><th scope="col"> 密码 </th> <th scope="col"> 操作</th> </tr>
             ';

             
        for($i=0; $i<$n; $i++) {

        $row = mysqli_fetch_assoc($result);
            
        echo  '<tr> 
                        <th scope="row"> <p> '.$row['uid'].'</p> </th>
                        <td style="text-align:left">
                            <p> 用户名: '.$row['username'].'</p>
                            <p> 昵称: '.$row['nickname'].'</p>
                            <p> 学号: '.$row['stdid'].'</p>
                            <p> 年龄: '.$row['age'].'</p>
                            <p> 专业: '.$row['specialty'].'</p>
                        </td>
                            
                        <td>  
                            <p> 邮箱: '.$row['email'].'</p>
                            <p> 电话: '.$row['phone'].'</p>
                         </td>

                         <td>  
                             <p> 密码: </label> <p>'.$row['password'].'</p>
                         </td>

                         <td class="p-5">

                                <!-- Buttons-->

                                        <!-- Edit Button form -->
                                        <form method="POST" action="edit_user.php">
                                            <input type="hidden" name="uid" value="'.$row['uid'].'"/>
                                            <input type="hidden" name="username" value="'.$row['username'].'"/>
                                            <input type="hidden" name="nickname" value="'.$row['nickname'].'"/>
                                            <input type="hidden" name="stdid" value="'.$row['stdid'].'"/>
                                            <input type="hidden" name="age" value="'.$row['age'].'"/>
                                            <input type="hidden" name="email" value="'.$row['email'].'"/>
                                            <input type="hidden" name="phone" value="'.$row['phone'].'"/>
                                            <input type="hidden" name="password" value="'.$row['password'].'"/>
                                            <input type="hidden" name="specialty" value="'.$row['specialty'].'"/>
                                            <button type="submit" class="btn btn-secondary">修改</button>
                                        </form>

                                        <!-- Delete Button trigger modal -->
                                        <button type="button" style="margin:10px"class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal'.$row['uid'].'">删除</button>
                                        <!--  Modal Delete -->  <!--  -->
                                        <div class="modal fade" id="deleteModal'.$row['uid'].'" aria-hidden="true" aria-labelledby="deleteModalLabel'.$row['uid'].'" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                             <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="deletetoggleLabel">删除用户</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <p> 确定要删除 "'.$row['nickname'].'" 的账号信息吗？<br> 删除后将无法恢复!</p>
                                                </div>
                                                <form method="POST" action="delete-user.php">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                                    <button type="submit" class="btn btn-danger" value="'.$row['uid'].'" name="delete">删除</button>
                                                </div>
                                                </form>
                                             </div>
                                            </div>
                                        </div>
                         </td>

                    </tr>
               ';
}
        echo <<<_END
        
        </table>
        </div>
        </div>
        </div>
_END;
    }

    else {
        echo "<div class='text-center fw-bold p-4'> 没有找到记录 <br> </div>";
    }
}
else {
    echo "你必须登录才能查看此页面";
}

require_once "footer.php";

?>