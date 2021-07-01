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
			define("TITLE", "I love programming \r\n");
			$title2 = "I Love Programming";
			// print TITLE;
			 print nl2br("The variable is ".$title2."\r\n");
			// //concatenate using dot or inter polation
			// print nl2br($title2.TITLE);
			//First letter
			//print nl2br("\r\n");
			print "The first letter is ".$title2[0];
			//Length of variable
			print nl2br("\r\n");
			echo "The length of the variable is ".strlen($title2);
			//Last letter
			print nl2br("\r\n");
			print "The last letter is ".substr($title2, 17, 1);
			//First 6 letters
			print nl2br("\r\n");
			print "The first 6 letters are \"".substr($title2, 0, 6)."\"";
			//capitalised
			print nl2br("\r\n");
			print "The capitalised version of the variable is \"".strtoupper($title2)."\"";
		?>
	
	</div>

	<!-- Task 2: Array and image-->
	<!-- write your solution to Task 2 here -->
	<div class="section">
		<h2>Task 2 : Array and image</h2>
		<?php 
			$images = array("earth", "flower", "plane", "tiger");
			$random = rand()%count($images); 
			$imageName = $images[$random];
			print "<img src=\"images/{$imageName}.jpg\" alt=\"{$imageName}\" width=\"20%\">";
		?>
		<img src="images/<?php print $imageName?>.jpg" alt="<?php print $imageName?>" width="20%">
	</div>	

	<!-- Task 3: Function definition dayinmonth  -->
	<!-- write your solution to Task 3 here -->
	<div class="section">
		<h2>Task 3 : Function definition</h2>
		<?php 
			function daysInMonth($month, $year)
			{
				return cal_days_in_month(CAL_GREGORIAN, $month, $year);
			}
			function daysInMonthSwitch($month)
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
			print nl2br("Using switch statement \r\n");
			for ($x = 1; $x <= 12; $x++)
			{
				print nl2br("Month {$x} has ".daysInMonthSwitch($x)." days\r\n");
			}

			print nl2br("Using calendar \r\n");
			for ($x = 1; $x <= 12; $x++)
			{
				print nl2br("Month {$x} has ".daysInMonth($x, 2020)." days\r\n");
			}
		?>
	</div>
	

	
	<!-- Task 4: Favorite Artists from a File (Files) -->
	<!-- write your solution to Task 4 here -->
	<div class="section">
		<h2>Task 4: My Favorite Artists from a file</h2>
		<?php
			print nl2br("Disclaimer: The following favourite artists may not represent the views of the author\r\n\r\n");
			$artists = file ("favorite.txt");
			foreach($artists as &$artist)
			{
				print nl2br("{$artist}");
			}
			print nl2br("\r\n");
			foreach($artists as &$artist)
			{
				$artist = str_replace(array("\n", "\r"), "", $artist);
				$sanitisedArtist = strtolower(str_replace(" ", "-", $artist));
				print nl2br("<a href=\"http://www.mtv.com/artists/{$sanitisedArtist}/\" target=\"_blank\">{$artist}</a>\r\n");
			}
		?>

		
	</div>
	
	<!-- Task 6: Directory operations -->
	<!-- write your solution to Task 6 here -->
	<div class="section">
		<h2>Task 6 : Directory operations</h2>
				<?php
				$files = scandir(".");
				print "<ol>";
				foreach($files as &$file)
				{
					if(!is_dir($file))
					{					
						print "<li>{$file}</li>";
					}
					else
					{
						print "<li>{$file}</li>";
						print "<ol>";
						$subFiles = scandir($file);
						foreach($subFiles as &$subFile)
						{
							if(!is_dir($subFile))
							{					
								print "<li>{$subFile}</li>";
							}
						}
						print "</ol>";
					}
				}
				print "</ol>";
				?>
	</div>

	    <!-- Task 5: including external files -->
	<!-- write your solution to Task 5 here -->
	<div class="section">
		<h2>Task 5: including external files</h2>
		<?php
			include("footer.php");
		?>
			
	</div>

</body>
</html>
