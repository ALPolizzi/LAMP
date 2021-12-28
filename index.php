<!DOCTYPE html> 

<html>
	<head>

		<?php
			include_once "database.php";
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
				<table class = "table table-bordered table-striped" id = "people_table">
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
					
					//as per mockup, 5 records per page will be displayed
					$records_per_page = 5;
					//count records in peopletable
					$num_records = mysqli_fetch_array(mysqli_query($connect,"SELECT COUNT(*) AS num_recs FROM peopletable;"))['num_recs'];
					//calc number of pages needed to display that many records
					$num_pages = ceil($num_records / $records_per_page);
					
					
					
					//get page number
					if(isset($_GET['page_num']) && $_GET['page_num']!="")
					{
						$page_num = $_GET['page_num'];
					} else{
						//defaut to first page
						$page_num = 1;
					}
					
					$offset = ($page_num-1)*$records_per_page;
					$query = "SELECT * FROM peopletable LIMIT ".$offset.", ".$records_per_page.";";	

					$results = mysqli_query($connect, $query);
					$counter=1;

					//generate table rows with incrementing IDs
					while($row= mysqli_fetch_array($results)){
						$counter++;	
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
						$counter--;
						}
					?>
					</tbody>
					
				
				
				</table>
			</div>

			<div>
				Page <?php echo $page_num . " of ". $num_pages; ?>
				
				<!--Pagination buttons composed of a list of labled links to add the ?page_num parameter to the url to be retrieved from the $_GET array above. Not functional for any number of pages aside from the hard coded 3, but gets the job done succinctly-->
					
				<ul class = "pagination">

					<li><a href = '?page_num=1'>Page 1</a></li>
					<li><a href = '?page_num=2'>Page 2</a></li>
					<li><a href = '?page_num=3'>Page 3</a></li>
				</ul>
			</div>
				
		</div>			
		
	</body>
</html>

<script>

			$(document).ready(function(){
				
				//add event listeners to table rows
				$(document).on('click', 'tr', function(){
					alert("test alert");
				});
				 

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
