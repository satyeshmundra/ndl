<?php
// $file1 = file("./all.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$file1 = fopen ( './person_dbpedia.csv', 'r' );

$filewrite = "./final2.txt";

while ( ($line = fgetcsv ( $file1 )) != FALSE ) {
	$name = $line [0];
	if ($name) {
		$surnames = explode("||", $name);
		if (count ( $surnames ) > 1)
			file_put_contents ( $filewrite, substr(end ( $surnames ), 0, -3) . PHP_EOL, FILE_APPEND );
		}
	}


?>