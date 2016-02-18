<?php 
	// I do the Submit form in the same file, at least I wont need to craete some session variables with 'errors'
	require_once 'Database.php'; // if there is a problem with connection, the rest of a site will not display. I do not need to include Database.php more than once
	// Firstly, I check whether there is some POST variable - I mean, if the user clicked Submit button
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		// Now, I create empty error variables that at the beginning will hold empty values
		$NameError = $SurnameError = $Teleph_NumbError = $AddressError = "";
		//Now, I am scanning the POST variables inputed by the user and I am getting rid of unnecessary characters like new line, unnecessary spaces etc.
		//To do this I declare the function to truncate all those unnecessary stuffs:
		
		$Name = htmlentities($_POST['Name'],ENT_QUOTES,"UTF-8"); // ENT_QUOTES tell to change " to entities
		$Surname =  htmlentities($_POST['Surname'],ENT_QUOTES,"UTF-8");
		$Teleph_Numb =  htmlentities($_POST['Teleph_Numb'],ENT_QUOTES,"UTF-8");
		$Address =  htmlentities($_POST['Address'],ENT_QUOTES,"UTF-8");
		
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
		
		// to insert datas we need to have invalid inputs:
		if($is_valid)
		{
			$conn = Database::Connect();
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			// I can do a query on a few ways, as a prepared statement (first "prepare" and next "execute" or i can use direct query() method. I think the first method is more professional for that example
			$sql_ins_q = "INSERT INTO person (Name, Surname, Telephone_Number, Address) VALUES ('$Name', '$Surname', '$Teleph_Numb', '$Address')";
			$q = $conn->prepare($sql_ins_q);
			$q->execute(array($Name, $Surname, $Teleph_Numb, $Address));
			Database::disconnect();
			$after_insert= '<span style="color:green">The row has been added to the Database successfully.</span><br />';
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
</ul>

<div align="center">
	<h3> Create a new Person: </h3>
	<form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method="post"> 
		Name: <br /> <input type="text" name="Name" maxlength="100"/> <br />
		<?php 
			if (!empty($NameError)){
				echo $NameError;
			}
		?>
		Surname: <br /> <input type="text" name="Surname" maxlength="100"/> <br />
		<?php 
			if (!empty($SurnameError)){
				echo $SurnameError;
			}
		?>
		Telephone Number: <br /> <input type="number" name="Teleph_Numb" maxlength="9"/> <br />
		<?php 
			if (!empty($Teleph_NumbError)){
				echo $Teleph_NumbError;
			}
		?>
		Address: <br /> <input type="text" name="Address" /> <br />
		<?php 
			if (!empty($AddressError)){
				echo $AddressError;
			}
		?>
		<div>
			<input type="submit" href="create.php" value="Create">
		</div>
		<?php 
			if (!empty($after_insert)){
				echo $after_insert;
			}
		?>
	</form>

</div>

</body>
</html>