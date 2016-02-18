
<!DOCTYPE html>
<html lang="en">
<head>
	<title>CRUD - Capgemini </title>
	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>

<ul>
  <li><a class="activeM" >Main Page</a></li>
  <li><a href="create.php">Create</a></li>
</ul>

<div class="container">
	<table class="table table-hover" align="center">
	<tr style="background-color:#DDDDDD">
		<th>Action</th>
		<th>ID</th>
		<th>Name</th>
		<th>Surname</th>
		<th>Telephone_Number</th>
		<th>Address</th>
	</tr>
		<?php 
			include 'Database.php'; // if there is a problem with connection, the rest of a site is displayed
			$conn = Database::Connect();
			$sql_q = 'SELECT * FROM person';
			foreach ($conn->query($sql_q) as $r){			
				echo '<tr>';
				echo '<td>';
					echo '<a style="color:blue" href="read.php?id='.$r['id'].'">Read</a> | ';
					echo '<a style="color:green" href="update.php?id='.$r['id'].'">Update</a> | ';
					echo '<a style="color:red"href="delete.php?id='.$r['id'].'">Delete</a>';
				echo '</td>';
				echo '<td>'.$r['id'].'</td><td>'.$r['Name'].'</td><td>'.$r['Surname'].'</td><td>'.$r['Telephone_Number'].'</td><td>'.$r['Address'].'</td>';
				echo '</tr>';
			}
			Database::disconnect();
		?>
	</table>
</div>

</body>
</html>










