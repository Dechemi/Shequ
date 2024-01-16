<?php
 echo <<<_END
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: black; padding: 10px;">
                <div class="container-fluid">
                    <button style="background-color: white;" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <img src="images/logo2.jpg" class="img-fluid  list-inline" width="80px" height="80px">
                    <div class="collapse navbar-collapse" id="navbarNav" style="padding-top:15px;margin-left:35px;">
                        <ul class="navbar-nav mr-auto mb-2 mb-md-0">
                            <li class="nav-item"><a style="color: aliceblue;" class="nav-link" href="index.php">主页</a></li>
                            <li class="nav-item"><a style="color: aliceblue;" class="nav-link" href="create_post.php">创建话题</a></li>
 _END;
?>