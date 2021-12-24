<!DOCTYPE html> 

<html>
	<head>

		<?php
			$connect = mysqli_connect("lampsite.com", "root","password", "lampdb");
			$query = "SELECT * FROM people_table ORDER BY ID ASC";
			$result = mysqli_query($connect, $query);
		?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>	
		
		<title>Technical Interview: LAMP website</title>
	</head>

	<body>

		<div class=container>
			<h1 align = "center"> Import CSV </h1> <br/>
			<form id="upload_csv" method = "post" enctype = "multipart/form-data">
			<div>
				<input type = "file" name = "csv_file"/>
			</div>
			<div>
				<input type="submit" name="submit" id="submit" value = "Submit CSV"/>
			</div>
			</form>
			<br/>
			<div class = "table-responsive" id = "people_table">
				<table class = "table">
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

					<td><?php echo $row["Note"]; ?></td>

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
						
						}
					});
				});
			});
</script>
