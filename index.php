<!DOCTYPE html> 

<html>
	<head>
		<link rel = "stylesheet" href = "style.css">
		<?php
			include_once "database.php";
		?>
		<!--inport jquery and css bootstrap for styling and data inporting-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>	
		
		<title>Technical Interview: LAMP website</title>
	</head>

	<body>
		
		<div class=container>
			<h2 align = "center"> Coding Interview: Anthony Polizzi </h2> <br/>
			<p>aliampolizzi@gmail.com</p>
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

			<div id=details-label>
				<h2>Details view</h2>
			</div>
			
			<div class = 'dtable' id="dtable">
			
				<p>First Name: </p>
				<p>Last Name: </p>
				<p>Address: </p>
				<p>City: </p>
				<p>State: </p>
				<p>Zip: </p>
				<p>Notes: </p>
				<p>ID: </p>
				
			</div>
			

		</div>			
		
	</body>
</html>

<script>

			$(document).ready(function(){
				
				//add event listeners to table rows
				$(document).on('click', 'tr', function(e){
					e.preventDefault();
					$.ajax({
						method:"POST",

						success: function(data){
						$($(e.target).parent()).toggleClass("active");

						//convoluted but effective way to get an array of the td values from the clicked tr			
						
						$text_array = $(e.target).parent().text().split("\n");
						$mod_text_array=[];
						for(i =0; i< $text_array.length; i++)
						{
							$text_array[i] = $text_array[i].trim();
							if ($text_array[i] != "" && $text_array[i] !=","){
								$mod_text_array.push($text_array[i]);
							}
						}

			      						

						$fname ="<p>First Name: "+$mod_text_array[0]+"</p>";
						$lname = "<p>Last Name: "+$mod_text_array[1]+"</p>";
	
						$add = "<p>Address: "+$mod_text_array[2]+"</p>";

						$city = "<p>City: "+$mod_text_array[3]+"</p>";

						$state = "<p>State: "+$mod_text_array[4]+"</p>";

						$zip = "<p>Zip Code: "+$mod_text_array[5]+"</p>";

						$notes = "<p>Notes: "+$mod_text_array[6]+"</p>";

						$id = "<p>Database ID: "+$mod_text_array[7]+"</p>";

						
						$(".dtable").empty();
						$(".dtable").append($fname, $lname, $add, $city, $state, $zip, $notes, $id);	
						}

						});
					});
				
				 

				$('#upload_csv').on('submit',function(e){
					e.preventDefault();
					$.ajax({
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
