<?php
	if(isset($_POST['login'])){
		
		session_start();
		include('conn.php');
	
		$username=$_POST['username'];
		$password=$_POST['password'];
		
		$sanitized_username = mysqli_real_escape_string($conn, $username);
      	$sanitized_password = mysqli_real_escape_string($conn, $password);
	
		$query=mysqli_query($conn,"select * from users where username='$sanitized_username' && password='$sanitized_password'");
	
		if (mysqli_num_rows($query) == 0){
			$_SESSION['message']="Login Failed. User not Found!";
			header('location:login.php');
		}
		else{
			$row=mysqli_fetch_array($query);
			
			//set up cookie
			setcookie("user", $row['username'], time() + (86400 * 30)); 
			setcookie("pass", $row['password'], time() + (86400 * 30));
			
			$_SESSION['id']=$row['iduser'];
			header('location:success.php');
		}
	}
	else{
		header('location:index.php');
		$_SESSION['message']="Please Login!";
	}
?>