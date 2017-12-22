#!/usr/bin/env php
<?php
require_once './php-mf2/Mf2/Parser.php';
require_once './htmlpurifier/library/HTMLPurifier.auto.php';

function create_notes($data) {
    foreach ($data as $note) {
    	print_r($note);
    	echo "\n";
    	$hash = hash ('sha1' , json_encode($note));
    	echo $hash."\n";
    	$date_split = date_parse($note['date']);
    	$isodate = sprintf("%04d-%02d-%02d", $date_split['year'], $date_split['month'], $date_split['day']);
    	$permdate = sprintf("%04d/%02d/%02d", $date_split['year'], $date_split['month'], $date_split['day']);
    	$mdfile = fopen($hash.".md", "w");
    	
    	
    			fwrite($mdfile, "---\n");
				fwrite($mdfile, "layout: notes_".$note['type']."\n");
				fwrite($mdfile, "type: ".$note['type']."\n");
				//fwrite($mdfile, "date: ".$isodate."\n");
				fwrite($mdfile, "date: ".$permdate."\n");				
				//fwrite($mdfile, "permalink: /notes/".$note['type']."/".$permdate."/".$hash.".html\n");
				
		switch ($note['type']) {
		
			case "twitter":

				//fwrite($mdfile, "ext-url: ".$note['url']."\n");
				fwrite($mdfile, "---\n");
				fwrite($mdfile, $note['message']."\n");
				break;
				
			case "like":
				$html = file_get_contents($note['url']);
				$config = HTMLPurifier_Config::createDefault();
				$purifier = new HTMLPurifier($config);
				$cleanhtml = $purifier->purify($html);
				$mf = Mf2\parse($cleanhtml, $note['url']);
				print_r($mf);
				fwrite($mdfile, "ext-url: ".$note['url']."\n");
				fwrite($mdfile, "---\n");
				//fwrite($mdfile, $note['message']."\n");
				break;	
				
			case "read";
				//fwrite($mdfile, "ext-url: ".$note['url']."\n");
				fwrite($mdfile, "---\n");
				fwrite($mdfile, $note['message']."\n");
			break;
			
			
			default:
				fwrite($mdfile, "---\n");
				fwrite($mdfile, $note['message']."\n");
				break;
			}
			
    	fclose($mdfile);
    }
}


function csv_parse_file ( $file ) {
if (($handle = fopen($file, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
 			 $res['type'] = $data['0'];
 			 $res['date'] = $data['4'];
 			 $res['message'] = $data['2'];
 			 $res['tag'] = $data['1'];
 			 $res['url'] = $data['3'];
 			 $ret[] = $res;
 			 print_r($data);
 			 print_r($res);
    }
    }
		fclose($handle);
		return $ret;
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
    					$data = csv_parse_file ( $file );
    					create_notes($data);
						break;
					}
			}
	}
}
?>
