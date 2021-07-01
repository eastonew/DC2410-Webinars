<!DOCTYPE html>
<html>
<head>
<title>Vehicle list</title>
<style type="text/css">
table { border: 1px solid black; }
th, td { padding: 5px; }
</style>
</head>
<body>

<?php require_once('connectdb.php'); ?>

<h1>Vehicles available:</h1>

<table>
<thead>
<tr>
	<th>Reg. No</th>
	<th>Category</th>
	<th>Brand</th>
	<th>Description</th>
	<th>Daily Rate</th>
</tr>
</thead>
<tbody>
<?php
try {
	$rows = $db->query("SELECT * FROM vehicles");
	
	if($rows->rowCount() > 0) {
		foreach($rows as $row) {
			?>
			
			<tr>
				<td><?= $row['reg_no'] ?></td>
				<td><?= $row['category'] ?></td>
				<td><?= $row['brand'] ?></td>
				<td><?= $row['description'] ?></td>
				<td><?= $row['dailyrate'] ?></td>
			</tr>
			
			<?php
		}
	} else {
		echo("<tr><td colspan=5>No results.</td></tr>");
	}
} catch(PDOException $ex) {
	echo("Failed to get data from database.<br>");
	echo($ex->getMessage());
	exit;
}
?>
</tbody>
</table>

</body>
</html>
