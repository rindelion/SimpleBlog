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
	function checkusername($name) {
    		if (preg_match("/^[a-zA-z0-9-_.]{3;20}$/", $name)) return true;
	}
	function CheckPassword($checkpass){
   		if(preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,}$/", $checkpass)) return true;
	}	

	session_start();
	include('conn.php');

	if (isset($_POST['login'])){
		//echo $_POST['vercode']; echo $_SESSION['check'];
		if($_POST['vercode'] != $_SESSION['check'])		
		{
			$_SESSION['message']="Login Failed. Verification code is wrong!";
			header('location:index.php');
		}else{

		$username=$_POST['username'];
		$password=$_POST['password'];
		$sanitized_username = mysqli_real_escape_string($conn, $username);
      		$sanitized_password = mysqli_real_escape_string($conn, $password);//checkusername($username)&&
		if(CheckPassword($password)){
			$query=mysqli_query($conn,"select * from users where username='$sanitized_username'");
	
			if (mysqli_num_rows($query) == 0){
				$_SESSION['message']="Login Failed. User not Found!";
				
				header('location:index.php');
			}
			else {
					$row=mysqli_fetch_array($query);
					$hashed_password= $row["password"];
					//echo ($hashed_password);
				
					if(password_verify($password,$hashed_password))
					{
					
					
						//set up cookie
						if (isset($_POST['remember'])){
							//set up cookie 
							setcookie("cookie", random_str(), time() + (86400 * 30));
						}

						$_SESSION['userid']=$row['userid'];
						$_SESSION['username']=$row['username'];
						$_SESSION['idcheck']="yes";
						header('location:Blog.php');
					}
					else{

						$_SESSION['message']="Login Failed. Password was wrong!";
						//echo ($hashed_password);
						header('location:index.php');
					}
			
			}
		}
		else {
			$_SESSION['message']="Login Failed. Something was wrong!";
			header('location:index.php');
		}
	}
	
	}
	else{
		if (isset($_COOKIE['cookie'])){

			$cookie=$_COOKIE['cookie'];

			$query=mysqli_query($conn,"select * from users where cookie='$cookie'");
			$row=mysqli_fetch_array($query);

			$_SESSION['userid']=$row['userid'];
			$_SESSION['username']=$row['username'];
			header('location:blog.php');
		} else {
			header('location:index.php');
			$_SESSION['message']="Please Login!";
		}
	}

	mysqli_close($conn);
?>
