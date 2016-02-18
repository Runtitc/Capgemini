<?php
	session_start();
	require 'Database.php';
	//to clear the previous prompts
	unset($_SESSION['deleted']);
	
	//if there is no a person with a given ID, then you cant enter to the update.php page
    if ( !empty($_GET['id'])) {
		// I make a session to carry the variable ID after submitting the update button
        $_SESSION['id'] = $_GET['id'];
    }
	
	if (null == $_SESSION['id']){
		header("Location: index.php");
	}
	// I am looking for a person with given ID
	$conn = Database::connect();
	$sql_s = "SELECT * FROM person where id = ?";
	$q = $conn->prepare($sql_s);
	$q->execute(array($_SESSION['id']));
	//I need to check whether there is some id in database in case of the situation where someone manually add the ID to the URL that, for example doesnt exist:
	if ($q->rowCount()<=0){
		header("Location: index.php");
	}
	// Now, when I know that there is a person with a given ID I can just delete it. 
	// The fact that assure me that there is only one person with a given ID is that ID column has the PRIMIARY KEY Constraint
	if (!empty($_POST)) {
		//I checked if there was some POST request
		$sql_delete = "Delete from person WHERE id = ?";
		$qd = $conn->prepare($sql_delete);
		$qd->execute(array($_SESSION['id']));
		if ($qd->rowCount()==0){
			$_SESSION['deleted']='<span style="color:red">The row has been already deleted!</span>';
		}else{
			$_SESSION['deleted']='<span style="color:green">The row has been removed successfully :)</span>';
		}
	}
?>

<!DOCTYPE html>
<html>
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
  <li><a class="active" href="index.php">Main Page</a></li>
  <li><a href="create.php">Create</a></li>
</ul>
<div align=center>

<?php if (isset($_SESSION['deleted'])):
	echo $_SESSION['deleted']; 
else: ?>
	<h3>Are you sure that you want to delete the row with ID = <?php echo $_SESSION['id']; ?>?</h3>
	<form method="post" action="delete.php">
		<input type="submit" value="YES" name="yes"/>
		<a href="index.php"><input type="button" value="NO" name="no"/></a>
	</form>
<?php endif; ?>


</div>
</body>
</html>