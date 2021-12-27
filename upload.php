<?php

include_once 'database.php';



if(!empty($_FILES["csv_file"]["name"])){

	$fileMimes = array(
		'text/comma-seperated-values',
		'text/csv',
		'application/csv'
	);

	//if is csv and not empty
	if(!empty($_FILES['csv_file']['name']) && in_array($_FILES['csv_file']['type'], $fileMimes)){
				
		//open file
		$csvFile = fopen($_FILES['csv_file']['tmp_name'], 'r');

		//parse
		while (($data = fgetcsv($csvFile, 10000, ",")) != FALSE)
		{
			$FirstName = addslashes($data[0]);
			$LastName = addslashes($data[1]);
			$Address = addslashes($data[2]);
			$City = addslashes($data[3]);
			$State = addslashes($data[4]);
			$Zip = addslashes($data[5]);
			$Note = addslashes($data[6]);

			//query to insert newly read row
			$query_escaped="INSERT INTO peopletable (FirstName, LastName, Address, City, State, Zip, Notes) VALUES ('"
			       	. $FirstName . "', '" . $LastName . "', '" . $Address . "', '" . $City . "', '".$State."', '" . $Zip . "', '" . $Note . "');";
			//echo($query_escaped); 
			mysqli_query($connect, $query_escaped);

		/*parameterized query to insert newly read row:
		mysqli_query($connect, "CALL importPerson("
			.$FirstName.", "
			.$LastName.", "
			.$Address.", "
			.$City.", "
			.$State.", "
			.$Zip.", "
			.$Note
			.");");
		*/

		}

		fclose($csvFile);
		echo "Successfully imported CSV";
		header("Location: index.php");
	}
	else
	{
		echo "Error, not csv";
	}
}
else
{
	echo "Error, csv empty";
}

?>
