#!/usr/bin/env php
<?php
// key: qhNU8kMDrqS2Ryk8ExmyA
//secret: 1tICNtAofpr0Coycb4eacrf4FcFCWSOzW8novjYL8
require_once './php-mf2/Mf2/Parser.php';
require_once './htmlpurifier/library/HTMLPurifier.auto.php';
require_once './goodreads-api/GoodReads.php';

// void parse_str ( string $encoded_string [, array &$result ] )

function create_notes($data) {
    foreach ($data as $note) {
    	print_r($note);
    	//echo "\n";
    	$hash = hash ('sha1' , json_encode($note));
  //  	echo $hash."\n";
    	
    	if (isset($note['url'])) {
    	$url = str_ireplace("www.","",parse_url($note['url'], PHP_URL_HOST));
    	}
    	
    	$date_split = date_parse($note['date']);
    	$isodate = sprintf("%04d-%02d-%02d", $date_split['year'], $date_split['month'], $date_split['day']);
    	$permdate = sprintf("%04d/%02d/%02d", $date_split['year'], $date_split['month'], $date_split['day']);
    	
    	$months = array (1=>'January',2=>'February',3=>'March',
    	4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',
    	9=>'September',10=>'October',11=>'November',12=>'December');
    	
    	
    	
    	$mdfile = fopen($hash.".md", "w");
    	
    	
    			fwrite($mdfile, "---\n");
				fwrite($mdfile, "layout: notes_".$note['type']."\n");
				fwrite($mdfile, "date: ".$isodate."\n");	
				fwrite($mdfile, "type: ".$note['type']."\n");
				//fwrite($mdfile, "date: ".$isodate."\n");
				
			if (isset($url)) {
				fwrite($mdfile, "permalink: /notes/".$url."/".$note['type']."/".$permdate."/".$hash.".html\n");
				} else {
				fwrite($mdfile, "permalink: /notes/".$note['type']."/".$permdate."/".$hash.".html\n");
				}				
				
				fwrite($mdfile, "categories: \n");
				fwrite($mdfile, " - ".$note['type']."\n");
				
				// dates
				fwrite($mdfile, " - ".$date_split['year']."\n");
				fwrite($mdfile, " - ".$months[(int)$date_split['month']]."\n");
				fwrite($mdfile, " - ".$date_split['day']."\n");				
				
				// url
				if (isset($url)) {
					fwrite($mdfile, " - ".$url."\n");
				}
				
		switch ($note['type']) {
		
			case "twitter":

				//fwrite($mdfile, "ext-url: ".$note['url']."\n");
				fwrite($mdfile, "---\n");
				fwrite($mdfile, $note['message']."\n");
				break;
				
			case 'reply':
				$html = file_get_contents($note['url']);
				$config = HTMLPurifier_Config::createDefault();
				$purifier = new HTMLPurifier($config);
				$cleanhtml = $purifier->purify($html);
				$mf = Mf2\parse($cleanhtml, $note['url']);
				fwrite($mdfile, "ext-url: ".$note['url']."\n");
				//fwrite($mdfile, "title: Replyed to a page @ ".$url."\n"); 				
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
				fwrite($mdfile, "title: Liked a page on ".$url."\n");  				
				fwrite($mdfile, "---\n");
				//fwrite($mdfile, $note['message']."\n");
				break;	
				
			case "read";
					$goodreads_api = new GoodReads('qhNU8kMDrqS2Ryk8ExmyA', '/home/tom/github/blog/website/_rake/tmp/');
					$urls = $note['urls'];
					$tags = $note['tags'];
					$page = $tags['page'];
					if ($page =="finshed") {
					status ="Finished"
					} else {status ="Currently"}
					
					if (array_key_exists("asin",$urls)) {
					$data = $goodreads_api->getBookByISBN($urls['asin']);
					}
					if (array_key_exists("ASIN",$urls)) {
					$data = $goodreads_api->getBookByISBN($urls['ASIN']);
					}
					
					$book = $data['book'];
					fwrite($mdfile, "book-title: \"".$book['title']."\"\n");
					fwrite($mdfile, "book-image_url: \"".$book['small_image_url']."\"\n");
					fwrite($mdfile, "book-url: \"".$book['url']."\"\n");	
					fwrite($mdfile, "page: ".$page."\n");				
					fwrite($mdfile, "status: ".$status."\n");				

				    //foreach($note['tags'] as $tagkey => $tag_value) {
				    //fwrite($mdfile, "tags-".$tagkey.": ".$tag_value."\n");
				    //}
				    
				    //foreach($note['urls'] as $urlkey => $url_value) {
				    //fwrite($mdfile, "urls-".$urlkey.": ".$url_value."\n");
				    //}
				//fwrite($mdfile, "title: Read ".$book['title']."\n");    
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

// ================================
function csv_parse_file ( $file ) {
 
	echo "opening ".$file."....";
	if (($handle = fopen($file, "r")) !== FALSE) {
		echo "Done\n";
    	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    		fwrite($logfile,json_encode($data)."\n");
    		/*
    		0: type
    		1: url
    		2: messages
    		3: tags
    		4: date 
    		*/
    		unset($res);
 			$res['type'] = $data['0'];
 			$tmpdate = date_create_from_format('d/m/Y', $data['4']);
 			$res['date'] = date_format($tmpdate, 'Y-m-d');
 			$res['message'] = $data['2'];


			// tags ===============================================
			    unset($tags_array);
			if (!strlen($data['3']) == 0 && !is_null($data['3'])) {
				$oldtags_array = explode(',', $data['3']);
				$tags_array = "";
	
				for($i=0; $i < count($oldtags_array ); $i++){
					$key_value = explode(':', $oldtags_array [$i]);
					$tags_array[$key_value [0]] = $key_value [1];
				}
			echo "tags_array===============================================\n";
		
    		print_r($tags_array);
    		fwrite($logfile,json_encode($tags_array)."\n");
    		echo "===============================================\n";
			$res['tags'] = $tags_array;
		}
		// ======================================================	
		
		// url tags	===========================================
		unset($url_array);
		
		if (!strlen($data['1']) == 0 && !is_null($data['1'])) {
		    print_r($data['1']);
		    echo "\n";
			switch (true) {
			
				case stristr($data['1'], 'http'):
				echo "found http\n";
					$res['url'] = $data['1'];			
					echo "url===============================================\n";
    				print_r($res['url']);
    				echo "===============================================\n";
					break;
					
				case parse_url($data['1'], PHP_URL_QUERY);
					echo "found query\n";
					print_r(parse_url($url, PHP_URL_QUERY));
					break;
							
				case stristr($data['1'], 'ASIN'):
					echo "found asin\n";	
				    $key_value = explode(':', $data['1']);
				    $url_array[$key_value [0]] = $key_value [1];
				    $res['urls'] = $url_array;
					echo "url===============================================\n";
    				print_r($res['urls']);
    				echo "===============================================\n";
					break;
					
				case stristr($data['1'], 'ISBN'):
					echo "found isbn\n";	
				    $key_value = explode(':', $data['1']);
				    $url_array[$key_value [0]] = $key_value [1];
				    $res['urls'] = $url_array;
					echo "url===============================================\n";
    				print_r($res['urls']);
    				echo "===============================================\n";
					break;
						
				case stristr($data['1'], 'IMDB'):
					echo "found IMDB\n";	
				    $key_value = explode(':', $data['1']);
				    $url_array[$key_value [0]] = $key_value [1];
				    $res['urls'] = $url_array;
					echo "url===============================================\n";
    				print_r($res['urls']);
    				echo "===============================================\n";
					break;
					
				case stristr($data['1'], 'TVDB'):
					echo "found TVDB\n";	
				    $key_value = explode(':', $data['1']);
				    $url_array[$key_value [0]] = $key_value [1];
				    $res['urls'] = $url_array;
					echo "url===============================================\n";
    				print_r($res['urls']);
    				echo "===============================================\n";
					break;
							
/*										
				case strstr($data['1'], ','):
					$oldurl_array = explode(',', $data['1']);
					$url_array = "";
					for($i=0; $i < count($oldurl_array ); $i++){
    					$key_value = explode(':', $oldurl_array [$i]);
    					$url_array[$key_value [0]] = $key_value [1];

					}
	 				$res['urls'] = $url_array;
	 				echo "url_array===============================================\n";
    				print_r($res['urls']);
    				echo "===============================================\n";
    				$url_array="";; 
			    	break;
			    	*/
 			}
 			
 		}
 		// ===========================================
			echo "res===============================================\n";
    		print_r($res);
    		echo "===============================================\n";	
 		fwrite($logfile,json_encode($res)."\n");
 		$ret[] = $res;
 			 
	}
}


		fclose($handle);
		return $ret;
}


$path = getcwd();

$notes_path = str_replace("_rake","_notes",$path);
chdir($notes_path);

$logfile = fopen("log.log", "w");
$notes_dir = scandir($notes_path);

fwrite($logfile,json_encode($notes_dir)."\n");
foreach ($notes_dir as $dir) {
	fwrite($logfile,$dir."\n");
	if ($dir === "." or $dir === ".." ) {continue;}
	chdir($notes_path."/".$dir);  
	$year_dir = scandir($notes_path."/".$dir);
	fwrite($logfile,json_encode($year_dir)."\n");
	foreach ($year_dir as $ydir) {
		fwrite($logfile,$ydir."\n");
		if ($ydir === "." or $ydir === "..") {continue;}
		chdir($notes_path."/".$dir."/".$ydir);  
		echo getcwd()."\n";
		$filelist = scandir($notes_path."/".$dir."/".$ydir);
			fwrite($logfile,json_encode($filelist)."\n");
			
		foreach ($filelist as $file) {
			if ($file === "." or $file === "..") {continue;}
			switch(true) {
					case strstr($file, "md"):
    					echo $file." skipping md file\n";
    					fwrite($logfile,$file." skipping md file\n");
    					continue 2;
					case strstr($file, "yml"):
    					echo $file."yml file\n";
    					fwrite($logfile,$file." yml file :) \n");
    					$data = yaml_parse_file ( $file );
    					create_notes($data);
    					break;
					case strstr($file, "csv"):
    					echo $file." CSV file\n";
    					fwrite($logfile,$file." csv file :) \n");
    					$data = csv_parse_file ( $file );
    					create_notes($data);
						break;
					}
			}
	}
}
    	fclose($logfile);
?>
