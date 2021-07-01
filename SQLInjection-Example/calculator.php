<!DOCTYPE html>
<html>
<head>
<title>Calculator</title>
</head>
<body>
<?php 
    $number1 = $_GET["number1"];
    $number2 = $_REQUEST["number2"];
?>

The first number was <?= $number1 ?><br/>
Division: <?= $number1 / $number2  ?> <br/>
Addition: <?= $number2 + $number1?>

</body>
</html>
