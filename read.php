<?php
	require 'Database.php';
	$id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: index.php");
    } else {
        $conn  = Database::connect();
        $conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM person where id = ?";
        $q = $conn->prepare($sql);
        $q->execute(array($id));
		if ($q->rowCount()<=0){
			header("Location: index.php");
		}
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CRUD - Capgemini </title>
	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<style>
		h1 {text-align:center;}
	</style>
</head>

<body>
<ul>
  <li><a class="active" href="index.php">Main Page</a></li>
  <li><a href="create.php">Create</a></li>
</ul>
<h2> Read a person: </h2>
<div>
Name: <?php echo $data['Name'];?>
</div>

<div>
Surname: <?php echo $data['Surname'];?>
</div>

<div>
Telephone Number: <?php echo $data['Telephone_Number'];?>
</div>

<div>
Address: <?php echo $data['Address'];?>
</div>

	
</body>
</html>
