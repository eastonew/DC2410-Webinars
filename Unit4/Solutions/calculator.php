<!DOCTYPE html>
<html>
<head>
<title>Calculator</title>
</head>
<body>

<?php

$number1 = $_GET['number1'];
$number2 = $_GET['number2'];

/*
if(!is_int($number1) || !is_int($number2)) {
	echo("Inputs must be integers.");
	exit;
}*/

?>

Your first number is <?= htmlspecialchars($number1) ?>.<br>
Your second number is <?= htmlspecialchars($number2) ?>.<br>
Addition result: <?= $number1 + $number2 ?>.<br>
Subtraction result: <?= htmlspecialchars($number1 - $number2) ?>.<br>
Multiplication result: <?= htmlspecialchars($number1 * $number2) ?>.<br>

<?php
if($number2 == 0) {
	echo("Can't divide by zero.<br>");
} else {
	echo("Division result: " . htmlspecialchars($number1 / $number2) . ".<br>");
}

echo("<br>The first number was $number1 again");

?>

</body>
</html>
