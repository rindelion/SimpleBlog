<?php 
    session_start();
    //Change these configs according to your MySQL server

    if (!isset($_SESSION['userid']) ||(trim ($_SESSION['userid']) == '')) {
      header('location:index.php');
      exit();
    }
    
    include('conn.php');
    // $userid = $_SESSION['userid'];
    // if (isset($_COOKIE['cookie'])) {
	//$cookie = $_COOKIE['cookie'];
        //$sql = "update users set cookie='$cookie' where userid='$userid'";
	//mysqli_query($conn, $sql);
   // }
?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Blog Game</title>

    <link href='https://fonts.googleapis.com/css?family=Suez One|Varela Round' rel='stylesheet'>

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
  <header>
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
	<?php
	if(!isset($_SESSION['idcheck'])){
		#$_SESSION['idcheck']="y";
		echo'
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		  <ul class="nav navbar-nav navbar-right">
		    <li>
		      <a href="about.html">About</a>
		    </li>
		  </ul>
		</div>';
	}else{
		echo'
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		  <ul class="nav navbar-nav navbar-right">
		    <li>
		      <a href="about.php">About</a>
		    </li>
		    <li>
		      <a href="profile.php">Profile</a>
		    </li>
		    <li>
		      <a href="index.php">Log out</a>
		    </li>
		  </ul>
		</div>';
	}
	?>
        <!-- /.navbar-collapse -->
      </div>
      <!-- /.container -->
    </nav>
      <div class = "banner">
        <div class = "container">
          <h1 class = "banner-title">
            <span>Game.</span> Design Blog
          </h1>
          <p>everything that you want to know about games</p>
          <form class="example" action="Blog.php">
            <input name="search" type = "text" class = "search-input" placeholder="Find your game. . .">           
            <button type = "submit" class = "search-btn">
            <i class = "fas fa-search"></i>
            </button>          
          </form>
        </div>
      </div>
    </header>
    <!-- Navigation -->
    


    
    <!-- Page Content -->
    <div class="container">

      <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-12">
          
          <?php
		function CheckXSS($text){
		    if(preg_match("/script|alert|javascript|prompt|style|address|xss|body|svg|src|href|input|marquee|dialog|draggable|ondrop|onfullscreenchange|oninput|oninvalid|onkeydown|onkeypress|onkeyup|onload|window.|document.|JSON./is", $text)) {
			$text = str_replace("\\", "\\\\", $text);
			$text = preg_replace('/"|\'|\<|\>|\(|\)|\$|\@|\=|\:|\//', " ", $text);
		    }
		    return $text;
		}
          // Create connection
            //$conn = mysqli_connect($servername, $username, $password, $database);
            // Check connection
	    include('conn.php');
            if ($conn->connect_error) {
              //$_SESSION['msg'] = "Connection failed";
                //die("Connection failed: " . $conn->connect_error);
                    echo "connection failed!";
            }
            else{             
              if(isset($_GET['search']))
              {
                
                $search = $_GET['search'];
		$search = CheckXSS($search);
                $sanitized_search = mysqli_real_escape_string($conn, $search);
                $sql_command = "SELECT * FROM posts WHERE (title like '%$sanitized_search%' or content like '%$sanitized_search%')"; 
                            
                $result = mysqli_query($conn, $sql_command);
                if (mysqli_num_rows($result) > 0) {
                          // output data of each row
                          while($row = mysqli_fetch_assoc($result)) {
                            $id = $row["postid"];
                            $title = $row["title"];
                            $username = $row["username"];
                            $timepost = $row["timepost"];
                            $content = $row["content"];
                            $timepost = $row["timepost"];
                         

                            echo '<!-- First Blog Post -->
                            <h2 class="post-title">
                              <a href="post.html">'.$title.'</a>
                            </h2>
                            <p class="lead">
                              by '.$username.'
                            </p>
                            <p><span class="glyphicon glyphicon-time"></span>'.$timepost.'</p>
                            <p>'.$content.'</p>
                            <a class="btn btn-default" href="/readmorepost.php?id='.$id.'">Read More</a>
                            <hr>';
                        }
                    } else {
                        echo "No results";
                    }
                    mysqli_close($conn);
              }
              else{
                $sql_command = "SELECT * FROM posts";
                
                $result = mysqli_query($conn, $sql_command);
                if (mysqli_num_rows($result) > 0) {
                          // output data of each row
                          while($row = mysqli_fetch_assoc($result)) {
                            $id = $row["postid"];
                            $title = $row["title"];
                            $username = $row["username"];
                            $timepost = $row["timepost"];
                            $content = $row["content"];
                            $timepost = $row["timepost"];
                            
  
                            echo '<!-- First Blog Post -->
                            <h2 class="post-title">
                              <a href="post.html">'.$title.'</a>
                            </h2>
                            <p class="lead">
                              by '.$username.'
                            </p>
                            <p><span class="glyphicon glyphicon-time"></span>'.$timepost.'</p>
                            <p>'.$content.'</p>
                            <a class="btn btn-default" href="/readmorepost.php?id='.$id.'">Read More</a>
                            <hr>';
                          }
                      } else {
                          echo "No results";
                      }
  
                mysqli_close($conn);
              }
              }                                       
          ?>
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
            <p>Copyright &copy; Your Website 2021</p>
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
<style>
  
  header{
      min-height: 100vh;
      background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url(https://i.idol.st/u/background/ZrHCUFBackground-MY7B6n.png?fbclid=IwAR3ynQy0rSkUhURtewT4VgYsCXXdEM3Z2mVgfOJtoDP9s1E_s4kJQ1mDkVg.jpg) center/cover no-repeat fixed;
      display: flex;
      flex-direction: column;
      justify-content: stretch;
  }
  .banner{
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: #fff;
  }
  .banner-title{
      font-size: 8rem;
      font-family: "Suez One";
      line-height: 1.2;
  }
  .banner-title span{
      font-family: 'Suez One';
      color: var(--exDark);
  }
  .banner p{
      padding: 1rem 0 2rem 0;
      font-size: 2.1rem;
      text-transform: capitalize;
      font-family: var(--Roboto);
      font-weight: 300;
      word-spacing: 2px;
  }
  .banner form{
      background: #fff;
      border-radius: 2rem;
      padding: 1.5rem 1rem;
      display: flex;
      justify-content: space-between;
  }
  .search-input{
      color:gray;
      font-family: var(--Roboto);
      font-size: 1.6rem;
      width: 100%;
      outline: 0;
      padding: 0.6rem 0;
      border: none;
  }
  .search-input::placeholder{
      text-transform: capitalize;
  }
  .search-btn{
      width: 40px;
      font-size: 1.1rem;
      color: var(--dark);
      border: none;
      background: transparent;
      outline: 0;
      cursor: pointer;
  }
</style>       
</html>
