#!/usr/bin/env php
<?php

function create_notes($data) {
    foreach ($data as $note) {
    	print_r($note);
    	echo "\n";
    	$hash = hash ('sha1' , json_encode($note));
    	echo $hash."\n";
    	
    	$mdfile = fopen($hash.".md", "w");
    	
		switch ($note['type']) {
			case "twitter":
				fwrite($mdfile, "---\n");
				fwrite($mdfile, "layout: notes_".$note['type']."\n");
				fwrite($mdfile, "type: ".$note['type']."\n");
				fwrite($mdfile, "date: ".$note['date']."\n");
				//fwrite($mdfile, "ext-url: ".$note['url']."\n");
				fwrite($mdfile, "---\n");
				fwrite($mdfile, $note['message']."\n");
				break;
			case "like":
				fwrite($mdfile, "---\n");
				fwrite($mdfile, "layout: notes_".$note['type']."\n");
				fwrite($mdfile, "type: ".$note['type']."\n");
				fwrite($mdfile, "date: ".$note['date']."\n");
				fwrite($mdfile, "ext-url: ".$note['url']."\n");
				fwrite($mdfile, "---\n");
				//fwrite($mdfile, $note['message']."\n");
				break;	
			}
			
    	fclose($mdfile);
    }
}

$path = getcwd();

$notes_path = str_replace("_rake","_notes",$path);
chdir($notes_path);

$notes_dir = scandir($notes_path);

foreach ($notes_dir as $dir) {
	if ($dir === "." or $dir === ".." ) {continue;}
	chdir($notes_path."/".$dir);  
	$year_dir = scandir($notes_path."/".$dir);
	
	foreach ($year_dir as $ydir) {
		if ($ydir === "." or $ydir === "..") {continue;}
		chdir($notes_path."/".$dir."/".$ydir);  
		echo getcwd()."\n";
		$filelist = scandir($notes_path."/".$dir."/".$ydir);
			
		foreach ($filelist as $file) {
			if ($file === "." or $file === "..") {continue;}
			switch(true) {
					case strstr($file, "md"):
    					echo "skipping md file\n";
    					continue 2;
					case strstr($file, "yml"):
    					echo "yml file\n";
    					$data = yaml_parse_file ( $file );
    					create_notes($data);
    					break;
					case strstr($file, "csv"):
    					echo "CSV file\n";
						break;
					}
			}
	}
}
?>
