<?php
require_once "header.php";
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
// 检查是否传递了正确的帖子ID
if(isset($_GET['pid'])) {
    $postid = $_GET['pid'];
    // 从数据库中获取帖子信息
    $query = "SELECT * FROM posts WHERE postid = '$postid'";
    $result = mysqli_query($connection, $query);
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $query = "SELECT * FROM users WHERE uid = {$row['uid']}";
        $result = mysqli_query($connection, $query);
        $rows = mysqli_fetch_assoc($result);

        //统计访问量,每次访问使其加一
        $query1 = "UPDATE posts SET visitors = visitors + 1 WHERE postid = '$postid'";
        mysqli_query($connection, $query1);
        //显示帖子信息
echo <<<_END
        <button onclick="window.location.href='index.php'" style="text-decoration: none; color: black; background-color: transparent; border: 1px solid black; border-radius: 3px;
        padding: 5px 10px; margin-top: 20px; margin-left: 20px;"> <<返回</button>
        <div>
        <h2 style='text-align: center;margin-top: 30px;'>{$row['title']}</h2>
        <div style='border-radius: 10px; border: 1px solid black;margin-top: 20px;margin-left: 200px;margin-right: 200px;margin-bottom: 50px;'>
        
        <p style='text-align: center;margin-top:10px'>作者: {$rows['nickname']} | 阅读量: {$row['visitors']}</p>
        <p style='text-align: center;'>发布时间: {$row['created']}</p>
        <p style='margin: 0 50px;'>&nbsp &nbsp &nbsp{$row['words']}</p>
        <img style='text-align: center;margin-top:30px;margin-bottom:30px' src='{$row['image']}' width='400px' class='rounded mx-auto d-block img-fluid' />
        </div>
        </div>
        

_END;

    $query = "SELECT * FROM reviews WHERE postid = '$postid'";
    $result = mysqli_query($connection, $query);
    echo "<div style=' border: 1px solid black;margin-top: 20px;margin-left: 200px;margin-right: 200px;margin-bottom: 50px;'>";
    while($row1 = mysqli_fetch_assoc($result)){
    echo <<<_END
        <div style='margin:30px'>
        <img src='images/avatar.jpg' width='30px' height='30px'>
        <a>&nbsp {$row1['usernick']} &nbsp {$row1['time']} </a>
        <p style="margin-left:40px">{$row1['message']}</p>
        <hr>
        </div>
    _END;
    }
    echo "</div>";

if(isset($_SESSION['uid'])){
    echo <<<_END
    <div style='text-align: center;margin-top: 20px;margin-bottom: 50px;margin-left:69%'>
        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#editModal">
        留言
        </button>
        <div class="modal" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">发表留言</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form method="POST" action="view-post.php?pid=$postid">
                  <div class="mb-3">
                    <textarea class="form-control" name="message" rows="2" cols="50" required></textarea>
                  </div>
                  <div class="modal-footer">
                   <button type="submit" name="msg" class="btn btn-success">发布</button>
                  </div>
                </form>
              </div>
            </div>
        </div>
        </div>
    </div>
    _END;
}
else
{
	echo <<<_END
    <div style='text-align: center;margin-top: 20px;margin-bottom: 50px;'>
    <button onclick="window.location.href='sign_in.php'" class="btn btn-dark"">登录查看留言</button>
    </div>
    _END;
}
        // echo $_SESSION['uid'];
        if(isset($_POST['msg'])) {
            if(!empty($_POST['message'])){
            $id = $_SESSION['uid'];
            $query = "SELECT * FROM users WHERE uid = '$id'";
            $result = mysqli_query($connection, $query);
            $roww = mysqli_fetch_assoc($result);

            $message = $_POST['message'];
            $usernick = $roww['nickname'];
            $userid = $roww['uid'];
            $postid = $row['postid'];
            $time = date('Y-m-d H:i:s'); // 获取当前时间
            // 将留言保存到数据库
            $query = "INSERT INTO reviews (userid, postid, usernick, message, time) VALUES ('$userid', '$postid', '$usernick', '$message', '$time')";
            mysqli_query($connection, $query);
        
            // 提示留言提交成功
            echo "<script>alert('评论成功'); window.location.href = 'view-post.php?pid=$postid';</script>";
            }
        }

} else {
        echo "
        <h1 style='text-align: center;margin:180px'>404 NOT FOUND</h1>
        <h4 style='text-align: center;margin:150px'>没有找到话题信息 可能已经被删除</h4>";
    }
}

require_once "footer.php";
?>
