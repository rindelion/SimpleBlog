
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
    if (!isset($_SESSION['userid']) ||(trim ($_SESSION['userid']) == '')) {
      header('location:index.php');
      exit();
    }
    include_once('conn.php');

    $_SESSION['token'] = random_str(24);
    $userid = $_SESSION['userid'];

?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Post - Simple Blog Template</title>

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

</head>

  <body>

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


    <!-- Page Content -->
    <div class="container">

      <div class="row">

       <!-- Blog Post Content Column -->
        <div class="col-lg-12">
           <!-- Blog Post -->

          <!-- Title -->
        <?php
        // Create connection
          include('conn.php');

          $postid = $_GET['id'];
          $_SESSION['postid'] = $postid;
          #$idpost = $_GET['id'];
              
          $sql = "SELECT * FROM posts WHERE postid='".$postid."'";
        
          $result = mysqli_query($conn, $sql);

          if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
              $title = $row["title"];
              $username = $row["username"];
              $timepost = $row["timepost"];
              $content = $row["content"];

              echo '<br><br><h1 class="post-title">'.$title.'</h1>
              <!-- Author -->
              <p class="lead">
                by '.$username.'
              </p>
                
              <hr>

              <!-- Date/Time -->
              <p><span class="glyphicon glyphicon-time"></span>'.$timepost.' </p>

              <hr>

              <!-- Post Content -->
              <p>'.$content.'</p>
          

              <hr>';
            }
          } else {
             echo "No posts.";
          }

	mysqli_close($conn);
            
          ?>

          <!-- Blog Comments -->

          <!-- Comments Form -->
          <div class="well">
            <h4>Leave a Comment:</h4>
            <form role="form" method="POST" action="comment.php">
              <div class="form-group">
                <textarea class="form-control" rows="3" name="comment"></textarea>
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                <input type="hidden" name="id" value="<?php echo $userid ?>" />
              </div>
              <button type="submit" class="btn btn-primary" name="post">Submit</button>
            </form>
          </div>

	  <hr>
          
          <!-- Posted Comments -->

          <!-- Comment -->
          <?php

            include('conn.php');

            $idpost = $_GET['id'];
            $_SESSION['postid'] = $idpost;
                
            $sql = "SELECT * FROM comments WHERE postid='".$postid."'";
          
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
              // output data of each row
              while($row = mysqli_fetch_assoc($result)) {
                $postid = $row["postid"];
                $commentid = $row["commentid"];
                $username = $row["username"];
                $content = $row["contentcmt"];
                $time = $row["timecmt"];

                echo '<div class="media">
                  <a class="pull-left" href="#">
                    <img class="media-object" src="http://placehold.it/64x64" alt="">
                  </a>
                  <div class="media-body">

          	    <h4 class="media-heading">'.$username.'
                      <small>'.$time.'</small>
                      <small><a href="#" onclick="delCmt('.$commentid.')">Delete</a></small>
                    </h4>
                    '.$content.'
                    <form id="'.$commentid.'" type="hidden" method="POST" action="del_cmt.php">
                      <input type="hidden" name="commentid" value="'.$commentid.'" />
                      <input type="hidden" name="id" value="'.$userid.'" />
                      <input type="hidden" name="token" value="'.$_SESSION['token'].'" />
                    </form>
                  </div>
                </div>';
                if (isset($_SESSION['message'])){
                    echo $_SESSION['message'];
                }
                unset($_SESSION['message']);
                echo '<hr>';

              }

            } else {
              echo "No comment.";
            }

            mysqli_close($conn);
          ?>
	<script>
            function delCmt(id) {
                document.getElementById(id).submit();
            }
          </script>

        </div>
      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <p>Copyright &copy; Your Website 2014</p>
          </div>
	<!-- /.col-lg-12 -->

       </div>
        <!-- /.row -->
      </div>
    </footer>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

  </body>

</html>
