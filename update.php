<?php
	session_start();
	require 'Database.php';
	$id = "";
	//if there is no a person with a given ID, then you cant enter to the update.php page
    if ( !empty($_GET['id'])) {
		// I make a session to carry the variable ID after submitting the update button
        $_SESSION['id'] = $_GET['id'];
    } 
	
    if ( null==$_SESSION['id'] ) {
        header("Location: index.php");
    }
	
	if (!empty($_POST)){
		$NameError = $SurnameError = $Teleph_NumbError = $AddressError = "";
        $Name = htmlentities($_POST['Name'],ENT_QUOTES,"UTF-8"); // ENT_QUOTES tell to change " to entities
		$Surname =  htmlentities($_POST['Surname'],ENT_QUOTES,"UTF-8");
		$Teleph_Numb =  htmlentities($_POST['Teleph_Numb'],ENT_QUOTES,"UTF-8");
		$Address =  htmlentities($_POST['Address'],ENT_QUOTES,"UTF-8");
		$id = $_SESSION['id'];
		
		// If some of the field will be empty, then the query INPUT shouldn't be executed. To do this I initiate the variable $is_valid and set it to "true" at the beginning
		$is_valid = true;
		
		//Let's say that the Name and Surname cannot has more than 40 characters
		if (empty($Name) || strlen($Name)>=40){
			$is_valid = false;
			$NameError = '<span style="color:red">*The length of Name should be less than 40 chararacters.</span><br />';
		}
		if (empty($Surname) || strlen($Surname) >= 40){
			$is_valid = false;
			$SurnameError = '<span style="color:red">*The length of Surname should be less than 40 chararacters.</span><br />';
		}
		
		if (strlen($Teleph_Numb) != 9 && strlen($Teleph_Numb) != 7){
			$is_valid = false;
			$Teleph_NumbError = '<span style="color:red">*The length of Telephone Number should consist of NINE or SEVEN digits.</span><br />';
			
		}
		if (empty($Address)){
			$is_valid = false;
			$AddressError = '<span style="color:red">*This field cannot be empty.</span>';
		}

		if($is_valid)
		{
			$conn = Database::Connect();
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			// I can do a query on a few ways, as a prepared statement (first "prepare" and next "execute" or i can use direct query() method. I think the first method is more professional and safe for that example
			$sql_upd_q = "UPDATE person set Name = ?, Surname = ?, Telephone_Number = ?, Address = ? where id = ?";
			// each '?' will be substitiuted with some values from the array in exec function.
			$q = $conn->prepare($sql_upd_q);
			$q->execute(array($Name, $Surname, $Teleph_Numb, $Address, $id));
			Database::disconnect();
			$after_update= '<span style="color:green">The row has been updated in the Database successfully.</span><br />';	
		}	
    }
	
	// But... if there was not an action form submitting the form, then I copy the current information from the row with a given id and substitute in the particular field as a 'value'
	$conn = Database::connect();
	$conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//first i need to find the person with a given ID
	$sql = "SELECT * FROM person where id = ?";
	$q = $conn ->prepare($sql);
	$q->execute(array($_SESSION['id']));
	
	//I need to check whether there is some id in database in case of the situation where someone manually add the ID to the URL that, for example doesnt exist:
	if ($q->rowCount()){
		$data = $q->fetch(PDO::FETCH_ASSOC);	
		Database::disconnect();
	}else{
		header("Location: index.php");
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
<div align="center">
	<h3> Update a Person: </h3>
	<form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method="post"> 
		Name: <br /> <input type="text" name="Name" maxlength="100" value="<?php echo $data['Name'];?>"/> <br />
		<?php 
			if (!empty($NameError)){
				echo $NameError;
			}
		?>
		Surname: <br /> <input type="text" name="Surname" maxlength="100" value="<?php echo $data['Surname'];?>"/> <br />
		<?php 
			if (!empty($SurnameError)){
				echo $SurnameError;
			}
		?>
		Telephone Number: <br /> <input type="number" name="Teleph_Numb" maxlength="9" value="<?php echo $data['Telephone_Number'];?>"/> <br />
		<?php 
			if (!empty($Teleph_NumbError)){
				echo $Teleph_NumbError;
			}
		?>
		Address: <br /> <input type="text" name="Address" value="<?php echo $data['Address'];?>"/> <br />
		<?php 
			if (!empty($AddressError)){
				echo $AddressError;
			}
		?>
		<div>
			<input type="submit" href="update.php" value="Update">
		</div>
		<?php 
			if (!empty($after_update)){
				echo $after_update;
			}
		?>
	</form>
</div>
</body>
</html>