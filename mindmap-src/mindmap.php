#!/usr/bin/env php
<?php
// https://en.wikipedia.org/w/api.php?action=query&prop=revisions&rvprop=content&format=json&titles=Chris_Huelsbeck&rvsection=0
// infobox

// https://en.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exintro=&explaintext=&titles=Chris_Huelsbeck
// summary

include './music_functions.php';
include './tv_movies_functions.php';
include './output.php';
$treedb = array ("id"=>"Me","name"=>"Tom Sparks");
$gobaldb = array ("id"=>"Me","name"=>"Tom Sparks");

//print_r($database);

$path = getcwd();

//$md_path = str_replace("_rake","_notes",$path);
//$media_path = str_replace("_mindmap","mindmap",$path);

chdir($path);
//$path = getcwd();
//$path = str_replace("_","",$path);
//mkdir($path);
echo $path."\n";
//$treedb = array2tree($treedb,$gobaldb,$path);
//print_r($treedb);


$filelist = scandir($path);
foreach ($filelist as $file) {
	if ($file === "." or $file === "..") {continue;}
		switch(true) {
			case strstr($file, "log"):
    			echo "\n".$file." skipping log file\n";
    			continue 2;
			case strstr($file, "html"):
    			echo "\n".$file." skipping html file\n";
    			continue 2;
    		case strstr($file, "temp"):
    			echo "\n".$file." skipping md file\n";
    			continue 2;
    					
			case strstr($file, "tv_movies.yml"):
    			echo "found tv_movies.yml :)\n";
    			$arr = tv_movies_levels($treedb,$gobaldb);
				$treedb = $arr['treedb'];
				yaml_emit_file("tree.yml",$treedb);
				$gobaldb = $arr['gobaldb'];
    			break;	
    		case strstr($file, "music.yml"):
    			echo "found music.yml :)\n";
    			$arr = music_levels($treedb,$gobaldb);
				$treedb = $arr['treedb'];
				yaml_emit_file("tree.yml",$treedb);
				$gobaldb = $arr['gobaldb'];	
    			break;				
					}
	}
	array2tree($treedb,$gobaldb,$path);
yaml_emit_file("tree.yml",$treedb);
//echo yaml_emit($gobaldb);

?>
