#!/usr/bin/env php
<?php
// key: qhNU8kMDrqS2Ryk8ExmyA
//secret: 1tICNtAofpr0Coycb4eacrf4FcFCWSOzW8novjYL8
require_once './php-mf2/Mf2/Parser.php';
require_once './htmlpurifier/library/HTMLPurifier.auto.php';
require_once './goodreads-api/GoodReads.php';



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
				fwrite($mdfile, "date: ".$isodate."\n");	
				fwrite($mdfile, "type: ".$note['type']."\n");
				//fwrite($mdfile, "date: ".$isodate."\n");
			
				fwrite($mdfile, "permalink: /notes/".$note['type']."/".$permdate."/".$hash.".html\n");
				
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
				fwrite($mdfile, "ext-url: ".$note['url']."\n");
				fwrite($mdfile, "---\n");
				//fwrite($mdfile, $note['message']."\n");
				break;	
				
			case "read";
					$goodreads_api = new GoodReads('qhNU8kMDrqS2Ryk8ExmyA', '/home/tom/github/blog/website/_rake/tmp/');
					$tags = $note['tags'];
					if (array_key_exists("asin",$tags)) {
					$data = $goodreads_api->getBookByISBN($tags['asin']);
					}
					if (array_key_exists("ASIN",$tags)) {
					$data = $goodreads_api->getBookByISBN($tags['ASIN']);
					}
					
					$book = $data['book'];
					fwrite($mdfile, "book-title: \"".$book['title']."\"\n");
					fwrite($mdfile, "book-image_url: \"".$book['small_image_url']."\"\n");
					fwrite($mdfile, "book-url: \"".$book['url']."\"\n");					
					
				    //foreach($note['tags'] as $tagkey => $tag_value) {
				    //fwrite($mdfile, "tags-".$tagkey.": ".$tag_value."\n");
				    //}
				    
				    //foreach($note['urls'] as $urlkey => $url_value) {
				    //fwrite($mdfile, "urls-".$urlkey.": ".$url_value."\n");
				    //}
				fwrite($mdfile, "---\n");
				fwrite($mdfile, $note['message']."\n");
				//fwrite($mdfile,json_encode($book)."\n");
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
echo "opening ".$file."....";
if (($handle = fopen($file, "r")) !== FALSE) {
echo "Done\n";
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    print_r($data);
 			 $res['type'] = $data['0'];
 			 $tmpdate = date_create_from_format('d/m/Y', $data['4']);
 			 $res['date'] = date_format($tmpdate, 'Y-m-d');
 			 $res['message'] = $data['2'];
// 			 $res['tag'] = $data['1'];
 			 
 //			 $my_string = "key0:value0,key1:value1,key2:value2";


// tags
$oldtags_array = explode(',', $data['1']);
$tags_array = "";

for($i=0; $i < count($oldtags_array ); $i++){
    $key_value = explode(':', $oldtags_array [$i]);
   $tags_array[$key_value [0]] = $key_value [1];
}
$res['tags'] = $tags_array;


// url tags
if (strpos($data['3'], 'http') !== false) { $res['url'] = $data['3'];
 	} else {
 	
		$oldurl_array = explode(',', $data['3']);
		$url_array = "";

		for($i=0; $i < count($oldurl_array ); $i++){
    			$key_value = explode(':', $oldurl_array [$i]);
    			$url_array[$key_value [0]] = $key_value [1];
		}
		$res['urls'] = $url_array;
 		}
 			 $ret[] = $res;
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
