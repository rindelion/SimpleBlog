<?php	
	//Change these configs according to your MySQL server
	session_start();
    /*if (!isset($_SESSION['userid']) ||(trim ($_SESSION['userid']) == '')) {
      header('location:index.php');
      exit();
    }*/
	include('conn.php');
	//echo("1");
	// Create connection
	#mysqli_set_charset('utf8', $conn);
		// Check connection
	function checkusername($name) {
    		if (preg_match("/^[a-zA-z0-9-_.]{3;20}$/", $name)) return true;
	}
	function CheckEmail($mail) {
   		 if (preg_match ("/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/", $mail))
        return true;
	}
	function CheckPassword($checkpass){
   		if(preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,}$/", $checkpass)) return true;
	}	
	if(!$conn)
	{
		echo "conection success";
	}
	if (isset($_POST['signup'])){ 
			// 2 ways to get fields in form, the later is more secure
		$name = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
				
		$sanitized_name = mysqli_real_escape_string($conn, $name);
		$sanitized_password = mysqli_real_escape_string($conn, $password);
		$sanitized_email = mysqli_real_escape_string($conn, $email);
		$hashed_password = password_hash($sanitized_password, PASSWORD_DEFAULT);//&&checkusername($name)
      
		if(CheckEmail($email)&&CheckPassword($password))
		{
			$query=mysqli_query($conn,"select * from users where username='".$sanitized_name."'");

			if (mysqli_num_rows($query) > 0){
				$_SESSION['message']="Signup failed. Username existed!";	
				header('location:Signup.php');
			}	
			else {
			
			
			
			
				//Create SQL command to insert data to database
				$sql_command = "INSERT INTO users (username, password,email) VALUES ('$sanitized_name','$hashed_password','$sanitized_email')";
			
				if (mysqli_query($conn,$sql_command)){
				
					header('location:index.php');
				}
				else
				{
				
					$_SESSION['message']="Signup failed. Try again!";
					header('location:Signup.php');
				}
			}
		}else{
			$_SESSION['message']="Something is wrong. Try again!";
			header('location:Signup.php');
		}
	}
	mysqli_close($conn);
	
?>
