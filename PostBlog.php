<?php

	session_start();
	//if (!isset($_SESSION['userid']) ||(trim ($_SESSION['userid']) == '')) {
      		//header('location:index.php');
	        //exit();
    	//}
	//Change these configs according to your MySQL server
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$database = "blogdb";
	$table = "posts";

	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $database);
		// Check connection
		if ($conn->connect_error) {
			//$_SESSION['msg'] = "Connection failed";
		    //die("Connection failed: " . $conn->connect_error);
            echo "connection failed!";
		}
		else{
            echo "connection ok!";
			$sql_command = "SELECT * FROM posts";

			$result = mysqli_query($conn, $sql_command);
			if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                  echo "<strong> title: " . $row["title"]." </strong> <br>";
                }
            } else {
                echo "No results";
            }

			mysqli_close($conn);
		}
        
?>
