<?php

    function random_str(
      int $length = 64,
      string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string {
      if ($length < 1) {
          throw new \RangeException("Length must be a positive integer");
      }
      $pieces = [];
      $max = mb_strlen($keyspace, '8bit') - 1;
      for ($i = 0; $i < $length; ++$i) {
          $pieces []= $keyspace[random_int(0, $max)];
      }

      return implode('', $pieces);
    }
 
    session_start();

    if (!isset($_SESSION['userid']) || (trim ($_SESSION['userid']) == '')) {
      header('location:index.php');
      exit();
    }

    if (isset($_SESSION['userid'])) //&& is_numeric($_GET['userid']))
    {
        $userid = $_SESSION['userid'];
	$_SESSION['token'] = random_str(24);
        include('conn.php');

        /*$sql_command = "SELECT iduser, username, email, bio FROM user WHERE iduser=$userid";
        $result = mysqli_query($conn, $sql_command);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $username = $row["username"];
                $email = $row["email"];
                $bio = $row["bio"];
                //$avatar = base64_encode($row["avatar"]);
                //$avatar = $row['avatar'];
            }
            mysqli_close($conn);
        }*/
        $sql_command = "SELECT username, email, bio FROM users WHERE userid=?";
        $stmt = $conn->prepare($sql_command);
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $stmt->bind_result($bind_username, $bind_email, $bind_bio);
        $stmt->fetch();
        $username = $bind_username;
        $email = $bind_email;
        $bio = $bind_bio;
        $stmt->close();
        $conn->close();
    }
    else {echo '
    <style>
        div {
        margin-bottom: 20px;
        margin-left: 400px;
        }
    </style>
    <form action="index.php">
    <div><h1 style="color:DarkTurquoise;margin-left:100px">OOPS SOMETHING WENT WRONG?</h></div>
    <div><button type="submit" style="background-color:Azure;color:Teal;margin-left:320px;font:Tahoma"> GO BACK </button></div>
    <div><img src="https://cdn.dribbble.com/users/1449854/screenshots/4136663/no_data_found.png" alt=""></div>
    </form>'; header("Location: index.php"); }
?>

<!DOCTYPE html>
<html lang="eng">

    <head>

      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
  
      <title>Profile</title>
  
      <!-- Bootstrap Core CSS -->
      <link href="css/bootstrap.min.css" rel="stylesheet">
  
      <!-- Custom CSS -->
      <link href="css/simple-blog-template.css" rel="stylesheet">

      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->

      <link href="css/profile-template.css" rel="stylesheet">
  
      <!--  This file has been downloaded from bootdey.com @bootdey on twitter -->
      <!--  All snippets are MIT license http://bootdey.com/license -->
      <script type="text/javascript" src="https://ff.kis.v2.scr.kaspersky-labs.com/FD126C42-EBFA-4E12-B309-BB3FDD723AC1/main.js?attr=wV1EdEBOyHJxPgEwO2q5cKQm7FADbNjQf5JTSceyiICeZdwqDfPUT1GzpyFn8xuHfy7bjTkiGvpPwHdTsKgrPpy1PSJWNkrTFvjd154qsPViD4lQ0pMFKt7jiwAmmj2ubRfVtfp8nEDaVLbNKAW9yw" charset="UTF-8"></script><script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
      <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
      <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    </head>

    <body oncontextmenu="return false">
      <!-- Navigation -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="Blog.php">Simple Blog</a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
              <li>
                <a href="about.php">About</a>
              </li>
              <li> 
                  <a href="profile.php">Profile</a>
              </li>
              <li>
                <a href="index.php">Logout</a>
              </li>
            </ul>
          </div>
          <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
      </nav>

      <div class="container"> 
        <div class="col-md-12">  
          <div class="col-md-4">      
            <div class="portlet light profile-sidebar-portlet bordered">
                <!-- ***************
                    PROFILE PICTURE
                ******************** -->
              <div class="profile-userpic">
                <img src="https://cdn.shopify.com/s/files/1/0262/9228/9641/t/10/assets/pf-a6beb393--03usagyuuuncharacter01_400x3000.png?v=1597831326" 
                    class="img-responsive" alt="">
                  <!--?php
                    if ($avatar==NULL) echo '<img 
                    src="https://cdn.shopify.com/s/files/1/0262/9228/9641/t/10/assets/pf-a6beb393--03usagyuuuncharacter01_400x3000.png?v=1597831326" 
                    class="img-responsive" alt="">';
                    else echo '<img src="data:image;base64,'.$avatar.'" class="img-responsive" alt="">'; 
                  ?-->
               </div>
                <!-- ************************
                    PROFILE NAME, EMAIL, BIO
                ***************************** -->
              <div class="profile-usertitle">
                <div class="profile-usertitle-name"> <!-- USERNAME -->
                  <?php 
                    echo $username;
                  ?> 
                </div> 
                <div class="profile-usertitle-job"> Reviewer </div>
              </div>
              <div class="profile-userinfo"> 
                <ul class="nav">
                  <li class="active"> <!-- USER'S BIOGRAPHY -->
                    <a href="#">
                    <i class="profile-userinfo-bio"></i> 
                    <?php 
                        echo $bio;
                    ?>
                    </a>
                  </li>
                  <li> <!-- USER'S EMAIL -->
                    <a href="#">
                    <i class="profile-userinfo-email"></i> 
                        <?php 
                            echo $email;
                        ?> </a> 
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-8"> 
            <div class="portlet light bordered">
              <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                  <i class="icon-globe theme-font hide"></i>
                  <span class="caption-subject font-blue-madison bold uppercase">PROFILE</span>
                </div>
              </div>
              <div class="portlet-body">
                <div>
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#edit" aria-controls="edit" role="tab" data-toggle="tab">Edit</a></li>
                    <li role="presentation"><a href="#blogs" aria-controls="blogs" role="tab" data-toggle="tab">Blogs</a></li>
                    <li role="presentation"><a href="#newpost" aria-controls="newpost" role="tab" data-toggle="tab">NewPost</a></li>
                  </ul>
                  <!-- Tab panes -->
                  <div class="tab-content">
                        <!-- **************
                             EDIT PROFILE
                        ******************* -->
                    <div role="tabpanel" class="tab-pane active" id="edit">
                      <form id="edit" action="updateprofile.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group"> <!-- EMAIL -->
                          <label for="InputEmail">Email address</label>
                          <input type="email" class="form-control" id="InputEmail" name="InputEmail" placeholder="Email" maxlenth="30"
                          pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" tittle="Example: rin@gmail.com" value="<?php echo $email ?>">
                        </div>
                        <div class="form-group"> <!-- CURRENT PASSWORD -->
                          <label for="CurrentPassword">Current Password</label>
                          <input type="password" class="form-control" id="CurrentPassword" name="CurrentPassword" placeholder="Password" minlength="8"
                                 pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,}$" 
                                 title="Password must be from 8 to 12 characters, includes uppercases, lowercases, numbers and special characters:!@#$%^&*_=+-"
                                 required>
                        </div>
                        <div class="form-group"> <!-- NEW PASSWORD -->
                          <label for="InputPassword">Password</label>
                          <input type="password" class="form-control" id="InputPassword" name="InputPassword" placeholder="Password" minlength="8"
                                 pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,}$" 
                                 title="Password must be from 8 to 12 characters, includes uppercases, lowercases, numbers and special characters:!@#$%^&*_=+-">
                        </div>
                        <div class="form-group"> <!-- BIOGRAPHY -->
                          <label for="InputBio">Biography</label>
                          <input type="text" class="form-control" id="InputBio" name="InputBio" placeholder="Speak yourself!" maxlength="100" value="<?php echo $bio ?>">
                        </div>
			<div>
                      	  <input type="hidden" name="id" value="<?php echo $userid ?>" />
                      	  <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
			</div>
                        <!--<div class="form-group"> IMAGE
                          <label for="InputFile">File input</label>
                          <input type="file" class="form-control" id="InputFile" name="InputFile" onchange=fileValidation()>
                          <p class="help-block">Only accepted .jpg, .jpeg and .png, maximum 5MB.</p>
                        </div> -->
                        <!-- SUBMIT BUTTON -->
                        <button type="submit" class="btn btn-default" onclick=CheckPass()>Submit</button> 
                      </form>
                    </div>
                    <!-- ********
                           BLOG
                         ******** -->
                    <div role="tabpanel" class="tab-pane" id="blogs">
                        <?php 
                            //$sql_command_blog = "SELECT * FROM blog, user WHERE blog.iduser=2 AND blog.iduser=user.iduser";
                            $sql_command_blog = "SELECT * FROM posts WHERE username='$username'";
                            include ("conn.php");
                            $result_blog = mysqli_query($conn, $sql_command_blog);
                            if (mysqli_num_rows($result_blog) > 0) {
                                // output data of each row
                                while($value = mysqli_fetch_assoc($result_blog)) {
                                    $postid = $value["postid"];
                                    $title = $value["title"];
                                    $blog_username = $value["username"];
                                    $timepost = $value["timepost"];
                                    $content = $value["content"];
        
                                    echo '<!-- First Blog Post -->
                                    <h2 class="post-title">
                                    <a href="post.html">'.$title.'</a>
                                    </h2>
                                    <p class="lead">
                                    by '.$blog_username.'
                                    </p>
                                    <p><span class="glyphicon glyphicon-time"></span>'.$timepost.'</p>
                                    <p>'.$content.'</p>
                                    <a class="btn btn-default" href="readmorepost.php?id='.$postid.'">Read More</a>
                                    <hr>';
                                }
                                mysqli_close($conn);
                            } else {
                                echo "0 results";
                            }
                        ?>
                    </div>
                    <!-- ************
                           NEW POST
                         ************ -->
                    <div role="tabpanel" class="tab-pane" id="newpost">
                      <!-- Newpost form -->
                      <form action="newpost.php" method="POST" class="newpost-form">
                        <div class="form-group"> <!-- TITLE -->
                          <label for="title">Title</label>
                          <input type="text" id="title" name="title" class="form-control" required>
                        </div>

                        <div class="form-group"> <!-- CONTENT -->
                          <label for="content">Content</label>
                          <textarea rows="5" id="content" name="content" class="form-control"></textarea>
                        </div>

			<div>
                      	  <input type="hidden" name="id" value="<?php echo $userid ?>" />
                      	  <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
			</div>

                        <button type="submit" class="btn btn-primary">Post</button>

                      </form>
                      <!-- /form -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <script>
var _0x4d09=['InputFile','304087ylhIdT','files','result','<img\x20src=\x22','target','getElementsByName','568357slvfil','620330cWhrnF','75ewGuBp','Invalid\x20file\x20type!','2MKPeLV','1ibCeoM','5550EvRYYY','getElementById','Your\x20current\x20password\x20and\x20password\x20are\x20different.\x20Do\x20you\x20want\x20to\x20change\x20your\x20current\x20password\x20to\x20new\x20password?','exec','162143KZNjqi','655243gpCYrH','CurrentPassword','InputPassword','\x22/>','44123GfOhpk','value'];(function(_0x3a519f,_0x318cad){var _0x4b3c90=_0x3a20;while(!![]){try{var _0x5b42d4=parseInt(_0x4b3c90(0x100))*-parseInt(_0x4b3c90(0x104))+parseInt(_0x4b3c90(0xff))+-parseInt(_0x4b3c90(0x108))+-parseInt(_0x4b3c90(0xfe))+parseInt(_0x4b3c90(0x109))+parseInt(_0x4b3c90(0x102))*-parseInt(_0x4b3c90(0x10d))+-parseInt(_0x4b3c90(0x110))*-parseInt(_0x4b3c90(0x103));if(_0x5b42d4===_0x318cad)break;else _0x3a519f['push'](_0x3a519f['shift']());}catch(_0x1f3c11){_0x3a519f['push'](_0x3a519f['shift']());}}}(_0x4d09,0x54258));function _0x3a20(_0x361dea,_0x5f2234){return _0x3a20=function(_0x4d0931,_0x3a20eb){_0x4d0931=_0x4d0931-0xf9;var _0x791ad7=_0x4d09[_0x4d0931];return _0x791ad7;},_0x3a20(_0x361dea,_0x5f2234);}function fileValidation(){var _0x35da84=_0x3a20,_0x1870a7=document['getElementById'](_0x35da84(0x10f)),_0x422af5=_0x1870a7['value'],_0x17137f=/(\.jpg|\.jpeg|\.png)$/i;if(!_0x17137f[_0x35da84(0x107)](_0x422af5))return alert(_0x35da84(0x101)),_0x1870a7[_0x35da84(0x10e)]='',![];else{if(_0x1870a7[_0x35da84(0xf9)]&&_0x1870a7[_0x35da84(0xf9)][0x0]){var _0x28efa6=new FileReader();_0x28efa6['onload']=function(_0x2d0cb5){var _0x5b7c0b=_0x35da84;document[_0x5b7c0b(0x105)]('imagePreview')['innerHTML']=_0x5b7c0b(0xfb)+_0x2d0cb5[_0x5b7c0b(0xfc)][_0x5b7c0b(0xfa)]+_0x5b7c0b(0x10c);},_0x28efa6['readAsDataURL'](_0x1870a7[_0x35da84(0xf9)][0x0]);}}}function CheckPass(){var _0x17b5aa=_0x3a20,_0x16c159=document[_0x17b5aa(0xfd)](_0x17b5aa(0x10a)),_0x49985f=document[_0x17b5aa(0xfd)](_0x17b5aa(0x10b));if(!empty(_0x49985f)&&_0x16c159!==_0x49985f){if(confirm(_0x17b5aa(0x106)))return!![];else return![];}}
      </script>

    </body>
</html>
