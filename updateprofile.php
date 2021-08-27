<?php
session_start();
    //if (!isset($_SESSION['userid']) ||(trim ($_SESSION['userid']) == '')) {
      //header('location:index.php');
      //exit();
    //}
include("conn.php"); 

//echo $_SESSION['token'];
//echo $_POST['token'];

if (($_SERVER["REQUEST_METHOD"] == "POST") && hash_equals($_SESSION['token'], $_POST['token']) && ($_SESSION['userid']==$_POST['id'])) {
    //unset($_SESSION['token']);
    $username= $_SESSION['username'];
    $email = $_POST['InputEmail'];
    $currpass = $_POST['CurrentPassword'];
    $password = $_POST['InputPassword'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $bio = $_POST['InputBio'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($query)==0) {GoBack();}
    else { 
	$row=mysqli_fetch_array($query);
	$hpass= $row["password"];
	$umail=$row["email"]; 
	mysqli_close($conn);}
 
    //$sql_command = "SELECT * FROM users WHERE username='$username'";
    //$result = mysqli_query($conn, $sql_command);
        //if (mysqli_num_rows($result) > 0) {
            //while($row = mysqli_fetch_assoc($result)) {
                //$hpass = $row['password'];
                //$umail = $row['email'];
		//echo $hpass;
            //} 
            //
        //}

			   
    //if(empty($_SESSION['username']) || !checkusername($username)) GoBack();
    
    /*$sql_command = "SELECT password, email FROM users WHERE username=?";
    $stmt = $conn->prepare($sql_command);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($bind_password, $bind_email);
    $stmt->fetch();
    $stmt->close();
    $hpass = $bind_password;*/
    if(!CheckEmail($email)) $email = $umail;//$bind_email;

    $bio = CheckXSS($bio);

    //if (CheckPassword($currpass) && (hash_equals($pass, $currpass)))
    if (CheckPassword($currpass) && password_verify($currpass, $hpass))
    { 
        //$sql_command = "UPDATE users SET email=?, bio=?, password=? WHERE username=?";

          /******************/
         /* CHECK PASSWORD */
        /******************/
        if (!empty($_POST['InputPassword']) && CheckPassword($password) && !hash_equals($currpass, $password)) {
            //$sql_command = $sql_command.",password='$password'"; //password='$hashed_password'";
            $password = $hashed_password;
        } else $password = $hpass;

        include("conn.php");
	//$stmt = mysqli_prepare($conn, $sql_command);
	//mysqli_stmt_bind_param($stmt, "ssss", $email, $bio, $password, $username);
	//mysqli_stmt_execute($stmt);
	//mysqli_stmt_close($stmt);
	
	$query = mysqli_query($conn, "UPDATE users SET email='$email', bio='$bio', password='$password' WHERE username='$username'");
	mysqli_close($conn);
	
        /*$stmt = $conn->prepare($sql_command);
        $stmt->bind_param("ssss", $email, $bio, $password, $username);
        $stmt->execute();
        $stmt->close();
        $conn->close();*/
        header("Location: http://".$_SERVER['HTTP_HOST']."/profile.php");

        /*include("conn.php");
        if ($conn->query($sql_command) == TRUE) {
            header("Location: http://".$_SERVER['HTTP_HOST']."/profile.php");
        } else { $_SESSION['msg'] = $conn->error;}
        mysqli_close($conn);*/

          /********************/
         /* CHECK FILE IMAGE */
        /********************/
        /*if (!empty($_FILES['InputFile']['name']))  {
            //$imageType = $_FILES['InputFile']['type'];
            $imageName = $_FILES['InputFile']['name'];
            //$image = $_FILES['InputFile']['tmp_name'];
            //$image = file_get_contents($image);
            //$image = base64_encode($image);

            $target = "images/".basename($imageName);
            if(move_uploaded_file($_FILES['InputFile']['tmp_name'], $target)){
                $image = file_get_contents($target);
                include("conn.php");
                $sql_addimage = "UPDATE user SET avatar='$target' WHERE username='$username'";

                /*$sql_addimage = "UPDATE user SET avatar='?' WHERE username='?'";
                $stmt = $conn->prepare($sql_addimage);
                $stmt->bind_param("ss", $image, $username);
                $stmt->execute();
                $stmt->close();
                $conn->close();
            }
            else
            {
                header("location:profile.php?error=fail");
            }
        }
        else {
            header("location: profile.php?error=noimagedetect");
        }*/
    }
    else
    {
        GoBack();
    }
}
function GoBack(){
    echo '<script>alert("Your password is not correct. Please try again.") </script>
        <style>
            div {
            margin-bottom: 20px;
            margin-left: 400px;
            }
        </style>
        <form action="profile.php">
         
        <div><h1 style="color:DarkTurquoise;margin-left:100px">OOPS SOMETHING WENT WRONG?</h></div>
        <div><button type="submit" style="background-color:Azure;color:Teal;margin-left:320px;font:Tahoma"> GO BACK </button></div>
        <div><img src="https://cdn.dribbble.com/users/1449854/screenshots/4136663/no_data_found.png" alt=""></div>
        </form>
        ';
        //header("location: profile.php?error=IncorrectPassword");  
}
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
function CheckXSS($text){
    if(preg_match("/script|alert|javascript|prompt|style|address|xss|body|svg|src|href|input|marquee|dialog|draggable|ondrop|onfullscreenchange|oninput|oninvalid|onkeydown|onkeypress|onkeyup|onload|window.|document.|JSON./is", $text)) {
        $text = str_replace("\\", "\\\\", $text);
        $text = preg_replace('/"|\'|\<|\>|\(|\)|\$|\@|\=|\:|\//', " ", $text);
    }
    return $text;
}
?>


