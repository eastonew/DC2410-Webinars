<!DOCTYPE html>
<html>
<head>
<title>Add vehicle data</title>
</head>
<body>

<form method="post" action="addvehicle.php">
Reg. No:
<input type="text" name="reg_no" maxlength=8>
<br><br>

Category:
<input type="radio" name="category" value="car" checked> Car
<input type="radio" name="category" value="truck"> Truck
<br><br>

Brand:
<input type="text" name="brand" maxlength=30>
<br><br>

Description:<br>
<textarea name="description">
</textarea>
<br><br>

Daily rate:
<input type="number" name="dailyrate" value="10" step="0.01">
<br><br>

<input type="submit" value="Add vehicle">
</form>
<br><br>

<?php

if(!empty($_POST)) {
	require_once('connectdb.php');
	
	$reg_no = $_POST['reg_no'];
	if(empty($reg_no)) {
		echo("You must enter a registration number.");
		exit;
	}
	
	$category = $_POST['category'];
	if(empty($category)) {
		echo("You must enter a category.");
		exit;
	}
	
	$brand = $_POST['brand'];
	$description = $_POST['description'];
	
	$dailyrate = round($_POST['dailyrate'], 2);
	if(empty($dailyrate) || $dailyrate <= 0) {
		echo("Invalid daily rate.");
		exit;
	}
	
	try {
		$stmt = $db->prepare("INSERT INTO `vehicles` (`reg_no`, `category`, `brand`, `description`, `dailyrate`) "
			. "VALUES (?,?,?,?,?)");
		$stmt->execute(array($reg_no, $category, $brand, $description, $dailyrate));
		echo("Successful.");
	} catch(PDOException $ex) {
		echo("Failed to save data to database.<br>");
		echo($ex->getMessage());
		exit;
	}
}

?>
</body>
</html>
