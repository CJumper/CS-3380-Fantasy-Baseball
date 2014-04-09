<?php

	$file = fopen("newMaster.txt", "r");
	$currentfile = 'nextData.sql';
	$newfile = file_get_contents($currentfile);
	$count = 0;
	while(!feof($file)){
		
    	$line = trim(fgets($file));
   		# do same stuff with the $line

   		$tok = explode(",", $line);


//FOR MASTER ONLY KEEP 0,1,16, AND 17

		// if(($tok[4] >= 1972)){

		// 	$commatest = substr($line, -1);
  //  			if($commatest == ","){
	 //   			//echo "\n".$line."\n\n";

	 //   			$line = substr($line, 0, -1);
	 //   		}
		// 	while((strpos($line, ',,'))){
		// 			$commas = ",,";
		// 			$zeros = ",0,";
	 //   				$line = str_replace($commas, $zeros, $line);
	 //   			echo $line."\n\n";
  //  			}
   			$line = str_replace('"', "'", $line);
			$newline = "INSERT INTO baseball.master VALUES (".$line;
   			$newline .= ");\n";
   			//$newline = $tok[0].",".$tok[1].",".$tok[16].",".$tok[17]."\n";
			$newfile .= $newline;
   			file_put_contents($currentfile, $newfile);
   		//}

	}
fclose($file);

?>
