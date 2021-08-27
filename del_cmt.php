<?php
	session_start();
	include('conn.php');

	if (!isset($_SESSION['userid']) ||(trim ($_SESSION['userid']) == '')) {
      		header('location:index.php');
      		exit();
    	}

	if (isset($_POST['commentid']) && hash_equals($_SESSION['token'], $_POST['token']) && ($_SESSION['userid']==$_POST['id'])){
		echo ("hello");

		//$unset($_SESSION['token']);
		$username = $_SESSION['username'];
		$postid = $_SESSION['postid'];
		$commentid = $_POST['commentid'];
		echo $username;echo $postid; echo $commentid;

		$query=mysqli_query($conn,"select * from comments where username='$username'");
		
		$row=mysqli_fetch_array($query);

		if ($username == $row['username']){
			$sql = "delete from comments where commentid='$commentid'";
			if ($conn->query($sql) === TRUE) {echo"success";
				header("location:readmorepost.php?id=".$postid);
			} else {
				echo "Error: " . $conn->error;
			}
		}
		else {
			$_SESSION['message']="You can only delete your comments.";
			header("location:readmorepost.php?id=".$postid);
		}

	} else {
		header("location:readmorepost.php?id=".$postid);
	}

	mysqli_close($conn);
?>
