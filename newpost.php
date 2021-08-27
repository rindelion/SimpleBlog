<?php
session_start();
include_once("conn.php");

    //if (!isset($_SESSION['userid']) ||(trim ($_SESSION['userid']) == '')) {
      //header('location:index.php');
      //exit();
    //}

if (($_SERVER["REQUEST_METHOD"] == "POST") && hash_equals($_SESSION['token'], $_POST['token']) && ($_SESSION['userid']==$_POST['id'])) {
    unset($_SESSION['token']);
    $username = $_SESSION['username'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $timezone = date_default_timezone_set("Asia/Ho_Chi_Minh");
    $timepost= date("d-m-Y h:i:s");

    //$sql_command = "INSERT INTO post (username, title, content, timepost) VALUES ('$username', '$title', '$content', '$timepost')";
    /*if ($conn->query($sql_command) == TRUE) {
        header("location: profile.php");
    } else { $_SESSION['msg'] = $conn->error;}
    mysqli_close($conn);*/

    $title = CheckXSS($title);
    $content = CheckXSS($content);

    $sql_command = "INSERT INTO posts (username, title, content, timepost) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_command);
    $stmt->bind_param("ssss", $username, $title, $content, $timepost);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header("Location: http://".$_SERVER['HTTP_HOST']."/profile.php");
}
else header("Location: http://".$_SERVER['HTTP_HOST']."/profile.php");

function CheckXSS($text){
    if(preg_match("/script|alert|javascript|prompt|style|address|xss|body|svg|src|href|input|marquee|dialog|draggable|ondrop|onfullscreenchange|oninput|oninvalid|onkeydown|onkeypress|onkeyiup|onload|window.|document.|JSON./is", $text)) {  
        $text = str_replace("\\","\\\\", $text);
        $text = preg_replace('/\"|\'|\<|\>|\(|\)|\$|\@|\=|\:|\//', " ", $text);
     }
     return $text;
}
?>
