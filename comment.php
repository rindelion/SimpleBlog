<?php
	session_start();
	include('conn.php');

	function clean($value) {
		return htmlspecialchars($value, ENT_QUOTES, 'UTF_8');
	}

	if (!isset($_SESSION['userid']) ||(trim ($_SESSION['userid']) == '')) {
      		header('location:index.php');
      		exit();
    	}
	function CheckXSS($text){
	    if(preg_match("/script|alert|javascript|prompt|style|address|xss|body|svg|src|href|input|marquee|dialog|draggable|ondrop|onfullscreenchange|oninput|oninvalid|onkeydown|onkeypress|onkeyup|onload|window.|document.|JSON./is", $text)) {
		$text = str_replace("\\", "\\\\", $text);
		$text = preg_replace('/"|\'|\<|\>|\(|\)|\$|\@|\=|\:|\//', " ", $text);
	    }
	    return $text;
	}
	if (isset($_POST['post']) && hash_equals($_SESSION['token'], $_POST['token']) && ($_SESSION['userid']==$_POST['id'])){

		unset($_SESSION['token']);
		$username = $_SESSION['username'];
		$postid = $_SESSION['postid'];
		$comment = clean($_POST['comment']);
		
		$comment = CheckXSS($comment);
		$sql = "insert into comments (username, postid, contentcmt) values ('$username', '$postid', '$comment')";

		if ($comment != "") {
			if ($conn->query($sql) === TRUE) {
				header("location:readmorepost.php?id=".$postid);
			} else {
				echo "Error: " . $conn->error;
			}
		}
		else {
			header("location:readmorepost.php?id=".$postid);
		}

	} else {
		header("location:readmorepost.php?id=".$postid);
	}

	mysqli_close($conn);
?>
