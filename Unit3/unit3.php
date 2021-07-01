<!DOCTYPE html>
<html>
<head>
  <title>Unit 3 Basic PHP Programing - Tasks </title>
</head>

<body>
	<h1>Unit 3 tasks</h1>
	<!-- Task 1: String-->
	<!-- write your solution to Task 1 here -->
	<div class="section">
		<h2>Task 1 : String</h2>
		<?php 
			$stringVariable = "I Love Programming";
			print $stringVariable;
			print nl2br("\r\n");
			print nl2br("The first letter is: ".$stringVariable[0]."\r\n");
			print nl2br("\r\n");
			print "The length of the string is: ".strlen($stringVariable);
			print nl2br("\r\n");
			print "The last letter is: ".$stringVariable[strlen($stringVariable)-1];
			print nl2br("\r\n");
			print "The first 6 letters are: \"".substr($stringVariable, 0, 6)."\"";
			print nl2br("\r\n");
			print "In capitals: ".strtoupper($stringVariable);
		?>
	
	
	</div>

	<!-- Task 2: Array and image-->
	<!-- write your solution to Task 2 here -->
	<div class="section">
		<h2>Task 2 : Array and image</h2>
		<?php
			$images = array("earth", "flower", "plane", "tiger");
			$imagesLength = count($images);
			$randomValue = rand()%$imagesLength;
			$imageName = $images[$randomValue];
			print "<img src=\"images/{$imageName}.jpg\" alt=\"{$imageName}\" width=\"20%\">"
		?>
		<img src="images/<?php print $imageName?>.jpg" alt="<?php print $imageName?>" width="20%">
	</div>	

	<!-- Task 3: Function definition dayinmonth  -->
	<!-- write your solution to Task 3 here -->
	<div class="section">
		<h2>Task 3 : Function definition</h2>
		<?php


			function daysInMonth($month)
			{
				$days = 0;
				switch($month)
				{
					case 1: //Januaury
					case 3: //March
					case 5: //May
					case 7: //July
					case 8: //August
					case 10: //October
					case 12: //December
						$days = 31;
						break;
					case 4: //April
					case 6: //June
					case 9: //September
					case 11: //November
						$days = 30;
						break; 
					case 2: //February
						$days = 28;
						break;
				}
				return $days;
			}

			function daysInMonthCal($month, $year)
			{
				return cal_days_in_month(CAL_GREGORIAN, $month, $year);
			}

			for ($x = 1; $x <= 12; $x++)
			{
				print nl2br("Month {$x} has ".daysInMonthCal($x, 2020)." days\r\n");
			}
		?>
	
	
	</div>
	

	
        <!-- Task 5: including external files -->
	<!-- write your solution to Task 5 here -->
	
	
	<!-- Task 6: Directory operations -->
	<!-- write your solution to Task 6 here -->
	<div class="section">
		<h2>Task 5 : Directory operations</h2>


		
	</div>

	<!-- Task 6 optional: Directory operations -->
	<!-- write your solution to Task 6 optional here -->
	<div class="section">
		<h2>Task 6 optional: Directory operations optional</h2>
			<?php
				$files = scandir(".");
				print "<ul>";
					foreach($files as &$file)
					{
						print "<li>{$file}</li>";
					}

				print "</ul>"
			?>
	
	
	</div>

	<div class="section">
		<h2>Task 5: including external files</h2>
			<?php include("footer.php"); ?>			
	</div>
	</div>
</body>
</html>
