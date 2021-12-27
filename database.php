<?php
			$connect = mysqli_connect("localhost", "testuser","test", "lampdb");
			if(!$connect){ //verify connection
				die("Couldn't connect to MySQL Server:".mysql_error());
			}
?>
