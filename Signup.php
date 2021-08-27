<?php 
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>User Signup</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <!-- <script>
        $(document).ready(function() {
            var name = $("#name").val();
            var email = $("#email").val();
            var password = $("#password").val();
            var formData = 'name=' + name + '&email=' + email + '&password=' + pass;
            $.ajax({
                type: "POST",
                url: "Submit_Form.php",
                data: formData,
                cache: false,
                //success: function(result) {
                    //alert(result);
                //}
            }).done(function(response){
                $("#server-results").html(response);
            });
            return false;
        });
        </script> -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <div class="content-wrapper">
            <div class="content">
                <div class="signup-wrapper shadow-box">
                    <div class="company-details ">
                        <div class="shadow"></div>
                        <div class="wrapper-1">
                            <!-- <div class="logo">
                                <div class="icon-food">

                                </div>
                            </div> -->
                            <h1 class="title">Blog.com</h1>
                            <div class="slogan">Create a blog and share
                                your voice in minutes.</div>
                        </div>

                    </div>
                    <div class="signup-form ">
                        <div class="wrapper-2">
                            <div class="form-title">Sign Up Today!</div>
                            <div class="form">
                                <form id="signup" method="POST" action="Submit_Form.php">
                                    <head>
                                        <link rel="stylesheet" type="text/css" href="css/Signup.css">
                                    </head>
                                    <p class="content-item">
                                        <label>
                                            Username
                                            <input type="text" placeholder="Lorem ipsum" name="username" pattern="^([a-zA-Z0-9]([._-](?![._-])|[a-zA-Z0-9]){1,18}[a-zA-Z0-9])$"
                                            title="Username only have upper-case, lower-case and special character:._- " required>
                                        </label>
                                    </p>

                                    <p class="content-item">
                                        <label>
                                            email address
                                            <input type="text" placeholder="lorem@loremipsum.com" name="email"
                                            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"  
                                            title="Email is invalid format. It must include characters:@.(example@gmail.com)" required>
                                        </label>
                                    </p>

                                    <p class="content-item">
                                        <label>
                                            password
                                            <input type="password" placeholder="*****" name="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[.!@#$%^&*_=+-]).{8,}$" 
                                             title="Password must be from 8 to 12 characters, includes upper-case, lower-case, number and special characters:!@#$%^&*_=+-" required>
                                        </label>
                                    </p>
                                    <br>
                                    <?php
                                        if (isset($_SESSION['message'])){
                                            $Color = "gray";
                                            $Text = $_SESSION['message'];

                                            echo '<div style="Color:'.$Color.'">'.$Text.'</div>';
                                        }
                                        unset($_SESSION['message']);
                                    ?>
                                   

                                    <button name="signup" type="submit" class="signup">Sign Up </button>
                    
                                    <p class="content-item">
                                        <div id="server-results"></div>
                                    </p>

                                </form>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    </body>
</html>
