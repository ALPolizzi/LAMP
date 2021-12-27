<!DOCTYPE html> 

<html>
	<head>

		<?php
			include_once "database.php";
			$query = "SELECT * FROM peopletable ORDER BY ID ASC";
			$results = mysqli_query($connect, $query);
		?>
		//import jquery and css bootstrap for styling and data importing
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>	
		
		<title>Technical Interview: LAMP website</title>
	</head>

	<body>

		<div class=container>
			<h2 align = "center"> Import CSV </h2> <br/>
			<form action= "upload.php" id="upload_csv" method = "post" enctype = "multipart/form-data">
			<div>
				<input type = "file" name = "csv_file"/>
			</div>
			<div>
				<input type="submit" name="submit" id="submit" value = "Submit CSV"/>
			</div>
			</form>
			<br/>
			<div class = "table-responsive" id = "people_table_container">
				<table class = "table" id = "people_table">
					<thead>
					<tr>

						<th>First Name</th>
						<th>Last Name</th>
						<th>Address</th>
						<th>City</th>
						<th>State</th>
						<th>Zip Code</th>
						<th>Note</th>
						<th>ID</th>
					</tr></thead>
					<tbody>
					<?php
					while($row= mysqli_fetch_array($results)){
					?>
					<tr>

					<td><?php echo $row["FirstName"]; ?></td>

					<td><?php echo $row["LastName"]; ?></td>

					<td><?php echo $row["Address"]; ?></td>

					<td><?php echo $row["City"]; ?></td>

					<td><?php echo $row["State"]; ?></td>

					<td><?php echo $row["Zip"]; ?></td>

					<td><?php echo $row["Notes"]; ?></td>

					<td><?php echo $row["ID"]; ?> </td>

					</tr>
					<?php
						}
					?>
					</tbody>
					
				
				
				</table>
			</div> 
				
		</div>			
		
	</body>
</html>

<script>
			$(document).ready(function(){
				$('#upload_csv').on('submit',function(e){
					e.preventDefaut();
					$.ajax({url:"import.php",
						method:"POST",
						data: new FormData(this),
						contentType:false,
						cache:false,
						processData:false,
						success:function(data){
							switch(data){

							case "Error1":
							  alert("File is Invalid");
							  break;
							case "Error2":
							  alert("No File Selected");
							  break;
							case "Success":
							  alert("File Already Imported");
							  //clear upload
							  $('#upload_csv')[0].reset();
							  break;
							default:
							  //put data into table
							  
							  $('people_table').html(data);
							  alert("populated people table");
							}
						}
					});
				});
			});
</script>
