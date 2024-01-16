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
  
    $query = "SELECT * FROM posts";
    $result = mysqli_query($connection, $query);

    $n = mysqli_num_rows($result);

    if ($n>0){
        echo '<div class="jumbotron" style="background-color: rgb(23, 23, 23); padding: 40px;">
                <div>
                    <h1 style="color: aliceblue;" class="display-3">Hello, '.$row['nickname'].'!</h1>
                    <h5 style="color: aliceblue;">修改或者删除社区的任何话题</h5>
                </div>
              </div>

          <div class="container" style="padding-top: 100px;">
             <div class="row" >';

        for($i=0; $i<$n; $i++) {

        $row = mysqli_fetch_assoc($result);
            
        echo  '<div style="padding-bottom:20px;">
                  <table class="table table-bordered">
                    <tr scope="row">
                        <td style="text-align:left">
                            <h3> 标题: '.$row['title'].'</h3>
                            <p> 时间: '.$row['created'].'</p>
                            <P> 话题id: '.$row['postid'].'</p>
                            <p> 概述: '.$row['content'].'</p>
                            <!-- Buttons-->
                            <div style="padding-bottom: 10px;">
                              <hr>
                                <!-- Edit Button trigger modal -->
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal'.$row['postid'].'">修改</button>
                                <!-- Modal Edit -->
                                <div class="modal" id="editModal'.$row['postid'].'" tabindex="-1" aria-labelledby="editModalLabel'.$row['postid'].'" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-scrollable">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel'.$row['postid'].'">修改话题</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body">
                                            <input type="text" value="'. '话题id: ' .$row['postid'].'" readonly/>
                                            <form method="POST" action="edit_post.php">
                                              <div class="mb-3">
                                                <label for="title" class="col-form-label">标题:</label>
                                                <input type="text" class="form-control" name="title" value="'.$row['title'].'" required>
                                              </div>
                                              <div class="mb-3">
                                                <label for="content" class="col-form-label">概述:</label>
                                                <textarea class="form-control" name="content" rows="3" cols="50" required>'.$row['content'].'</textarea>
                                              </div>
                                              <div class="mb-3">
                                                <label for="content" class="col-form-label">正文:</label>
                                                <textarea class="form-control" name="words" rows="5" cols="50" required>'.$row['words'].'</textarea>
                                              </div>
                                              <div class="mb-3">
                                                <label for="image" class="col-form-label">图片:</label>
                                                <input type="hidden" name="postid" value="'.$row['postid'].'"/>
                                                <input type="text" class="form-control" readonly name="image" value="'.$row['image'].'" required>
                                              </div>
                                              <div class="modal-footer">
                                              <button type="submit" class="btn btn-success">重新发布</button>
                                              </div>
                                            </form>
                                          </div>
                                      </div>
                                  </div>
                                </div>

                                <!-- Delete Button trigger modal -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal'.$row['postid'].'">删除</button>
                                <!--  Modal Delete -->  <!--  -->
                                <div class="modal fade" id="deleteModal'.$row['postid'].'" aria-hidden="true" aria-labelledby="deleteModalLabel'.$row['postid'].'" tabindex="-1">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="deletetoggleLabel">删除话题</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                          <p> 你确定要删除这个话题吗? 话题id: "'.$row['postid'].'"<br> 已删除的话题将无法访问.</p>
                                        </div>
                                        <form method="POST" action="delete-posts.php">
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                            <button type="submit" class="btn btn-danger" value="'.$row['postid'].'" name="delete">删除</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
              </div>';

          if($row['image'] != NULL){
            echo <<<_END
            <td class="col-3">
            <img src="{$row['image']}" width="200px" class='rounded mx-auto d-block img-fluid'/>
            </td>
_END;
          }
          
          echo '</tr></table> </div>';
}
        echo <<<_END
        </div>
          </div>
_END;
    }

    else {
        echo "<div class='text-center fw-bold p-4'> 没有找到记录<br> </div>";
    }
}
else {
    echo "你必须登录才能查看该页面";
}

require_once "footer.php";

?>