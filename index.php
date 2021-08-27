<?php
   session_start();
   //include('conn.php');
   
   if (isset($_COOKIE["cookie"]))
      header("location:login.php");
?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <title>User Login</title>
</head>
<body>
   <div class="overlay">
   <!-- LOGN IN FORM by Omar Dsoky -->
   
   <form method="POST" action="login.php">
      <head>
            <link rel="stylesheet" type="text/css" href="css/Login.css">
            <script type="text/javascript" src="js/Login.js"></script>
      </head>
      <!--   con = Container  for items in the form-->
      <div class="con">
      <!--     Start  header Content  -->
      <header class="head-form">
         <h2>Log In</h2>
         <!--     A welcome message or an explanation of the login form -->
         <p>login here using your username and password</p>
      </header>
      <!--     End  header Content  -->
      <br>
      <div class="field-set">
         
         <!--   user name -->
         <span class="input-item">
            <i class="fa fa-user-circle"></i>
         </span>
         <!--   user name Input-->
         <input class="form-input" id="username" type="text" placeholder="Username" name="username" 
         pattern="^([a-zA-Z0-9]([._-](?![._-])|[a-zA-Z0-9]){1,18}[a-zA-Z0-9])$"
          required>
         
         <br>
         
               <!--   Password -->
         
         <span class="input-item">
            <i class="fa fa-key"></i>
         </span>
         <!--   Password Input-->
         <input class="form-input" type="password" placeholder="Password" id="password" name="password" 
         pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[.!@#$%^&*_=+-]).{8,}$" 
         required>
         
         <br><br>
   <!--      Remember me  -->
         <input type="checkbox" name="remember"> Remember me <br>

         <?php
            if (isset($_SESSION['message'])){
               $Color = "gray";
               $Text = $_SESSION['message'];

               echo '<div style="Color:'.$Color.'">'.$Text.'</div>';
               
            }
            unset($_SESSION['message']);
         ?>
         <br>
	<div class="form-group">
            <input type="text" name="vercode" class="form-control" placeholder="Verfication Code" required="required">
        </div>
        <div class="form-group small clearfix">
            <label style="color:gray" class="checkbox-inline">Verification Code</label>
              <img src="checkcaptcha.php" >
        </div> 
   <!--        buttons -->
   <!--      button LogIn -->
         <button class="log-in" type="submit" name="login"> Log In </button>
      </div>
      
   <!--   other buttons -->
      <div class="other">
   <!--      Forgot Password button-->
         <button class="btn submits frgt-pass">Forgot Password?</button>
   <!--     Sign Up button -->
         <button onclick="javascript:location.href='/Signup.php'" class="btn submits sign-up">Sign Up 
   <!--         Sign Up font icon -->
         <i class="fa fa-user-plus" aria-hidden="true"></i>
         </button>
   <!--      End Other the Division -->
      </div>
         
   <!--   End Conrainer  -->
      </div>
      <!-- End Form -->
   </form>
   </div>
</body>
<!-- <script>
   function Login(){
      if (Checknull() && CheckLength())
      {
         document.getElementById("field-set").submit();
      }
   }
   
   //Kiểm tra username password được nhập không
   function Checknull()
   {
      var user = document.getElementById("username").value;
      var pwd = document.getElementById("passwd").value;
      if (user=="" || pwd=="") {
         alert ("Username và password không được bỏ trống!");
         return false;
      }
      else return true;
   }
   function CheckLength()
   {
      var pwd = document.getElementById("passwd").value;
      if (pwd.length<8)
      {
         alert ("Password có tối thiểu 8 kí tự.")
         return false;
      }
      return true;
   } 
</script>-->
</html>
