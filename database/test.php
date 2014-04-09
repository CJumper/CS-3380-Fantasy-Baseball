<?php

	$file = fopen("Batting.txt", "r");
	$currentfile = 'nextData.sql';
	$newfile = file_get_contents($currentfile);
	$count = 0;
	while(!feof($file)){
		
    	$line = trim(fgets($file));
   		# do same stuff with the $line

   		$tok = explode(",", $line);




		if($tok[1] >= 2010){

			$commatest = substr($line, -1);
   			if($commatest == ","){
	   			//echo "\n".$line."\n\n";

	   			$line = substr($line, 0, -1);
	   		}
			// while((strpos($line, ',,'))){
			// 		$commas = ",,";
			// 		$zeros = ",0,";
	  //  				$line = str_replace($commas, $zeros, $line);
	  //  			//echo $line."\n\n";
   // 			}
   			$line = str_replace('"', "'", $line);
			$newline = "INSERT INTO baseball.batting VALUES (".$line;
   			$newline .= ");\n";
			$newfile .= $newline;
   			file_put_contents($currentfile, $newfile);
   		}



	}
fclose($file);

?>
