#!/usr/bin/env php
<?php
// key: qhNU8kMDrqS2Ryk8ExmyA
//secret: 1tICNtAofpr0Coycb4eacrf4FcFCWSOzW8novjYL8
require_once './php-mf2/Mf2/Parser.php';
require_once './htmlpurifier/library/HTMLPurifier.auto.php';
require_once './goodreads-api/GoodReads.php';
date_default_timezone_set('Australia/Brisbane');


function create_notes($data,$logfile) {
    foreach ($data as $note) {
    	//print_r($note);
    	
   	if (isset($note['tags']) && !is_array($note['tags'])) {
 //  			//fwrite($logfile,json_encode($temp)."\n");
   	  		//$note['tags'] = tag2tags($note['$tags'],$logfile);
  			$temp  = urldecode ( $note['tags'] );
 			parse_str($temp, $tag_array);
 			$note['tags'] = $tag_array;

}


  		
    	//echo "\n";
    	$hash = hash ('sha1' ,json_encode($note));
    	//fwrite($logfile, $hash."\n");
  //  	echo $hash."\n";
    	fwrite($logfile, "\n--------------------\nhash: ".$hash."\njson_encode: ".json_encode($note)."\n--------------------\n");  
    	    	
    	    	
    	if (isset($note['url'])) {
    	$url = str_ireplace("www.","",parse_url($note['url'], PHP_URL_HOST));
    	}
    	
    	$date_split = date_parse($note['date']);
    	$isodate = date("c", strtotime($note['date']));
    	$permdate = sprintf("%04d/%02d/%02d", $date_split['year'], $date_split['month'], $date_split['day']);
    	
    	$months = array (1=>'January',2=>'February',3=>'March',
    	4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',
    	9=>'September',10=>'October',11=>'November',12=>'December');
    	unset($md_array);
    	
    	$md_array['layout'] = "notes_".$note['type'];
    	$md_array['date'] = $isodate;
    	$md_array['type'] = $note['type'];
    	
    	//$mdfile = fopen($hash.".md", "w");
    	
    	
    			//fwrite($mdfile, "---\n");
				//fwrite($mdfile, "layout: notes_".$note['type']."\n");
				//fwrite($mdfile, "date: ".$isodate."\n");	
				//fwrite($mdfile, "type: ".$note['type']."\n");
				//fwrite($mdfile, "date: ".$isodate."\n");
				unset($categories_array);			
				$categories_array[] = $note['type'];
				$categories_array[] = $months[(int)$date_split['month']];
				$categories_array[] = $date_split['year'];
				$categories_array[] = $date_split['day'];
				//fwrite($mdfile, "categories: \n");
				//fwrite($mdfile, " - ".$note['type']."\n");
				
				// dates
				//fwrite($mdfile, " - ".$date_split['year']."\n");
				//fwrite($mdfile, " - ".$months[(int)$date_split['month']]."\n");
				//fwrite($mdfile, " - ".$date_split['day']."\n");				
				
				// url
				if (isset($url)) {
				//	fwrite($mdfile, " - ".$url."\n");
				$categories_array[] = $url;
				}
				
				$md_array['permalink'] ="/notes/".$note['type']."/".$permdate."/".$hash.".html";
				
   	//if (isset($note['tags']) && is_array($note['tags'])) {				
		//		 $tag_array = $note['tags'];
		//}
		
		//$tag_array = $note['tags'];
		
	//	if (is_array($note['tags'])) {
	//			print_r($note['tags']);
	//			$tag_array = $note['tags'];
	//			print_r($tag_array['syndication']);
	//	}
	//	print_r($note['tags']);
	//	print_r($tag_array['syndication']);
		if (isset($note['tags']) && is_array($note['tags'])) {
						$tag_array = $note['tags'];
						if (isset($tag_array['syndication'])) {
								$md_array['syndication'] = $tag_array['syndication'];
							}
					}
				
				
		switch ($note['type']) {
// -------------------------------------------------------------------------------------------------------------------------------------
		
// #####################################################################################################################################
			case "scrobble":
			
				$categories_array[] = $tag_array['title'];
				$categories_array[] = $tag_array['artist'];
				$categories_array[] = $tag_array['album'];
				
				$md_array['music-title'] = $tag_array['title'];
				$md_array['music-artist'] = $tag_array['artist'];
				$md_array['music-album'] = $tag_array['album'];
				$md_array['music-play-count'] = $tag_array['play-count'];
				$md_array['title'] = "Played ".$md_array['music-title']." by ".$md_array['music-artist'];  
				$md_array['permalink'] ="/notes/".$note['type']."/".urlencode($tag_array['artist'])."/".urlencode($tag_array['album'])."/".$hash.".html";
				break;
// #####################################################################################################################################
			case "photo":
				$md_array['title'] = "photo(s)";
				$md_array['photo'] = $tag_array['photo'];
				  
				//$md_array['permalink'] ="/notes/".$note['type']."/".urlencode($tag_array['artist'])."/".urlencode($tag_array['album'])."/".$hash.".html";
				break;				
// #####################################################################################################################################
			case "twitter":
				$md_array['permalink'] ="/notes/".$note['type']."/".$permdate."/".$hash.".html";
				$md_array['title'] = "twitted: ".$hash;
				//fwrite($mdfile, "ext-url: ".$note['url']."\n");
				//fwrite($mdfile, "---\n");
				//fwrite($mdfile, $note['message']."\n");
				break;
				
// #####################################################################################################################################
			case 'reply':
				$md_array['permalink'] ="/notes/".$note['type']."/".$url."/".$permdate."/".$hash.".html";
				$html = file_get_contents($note['url']);
				$config = HTMLPurifier_Config::createDefault();
				$purifier = new HTMLPurifier($config);
				$cleanhtml = $purifier->purify($html);
				$mf = Mf2\parse($cleanhtml, $note['url']);
				$md_array['ext-url'] = $note['url'];
				$md_array['title'] = "reply to: ".$note['url'];
				break;
				
// #####################################################################################################################################
				
			case "like":
				$md_array['permalink'] ="/notes/".$note['type']."/".$url."/".$permdate."/".$hash.".html";
				$html = file_get_contents($note['url']);
				$config = HTMLPurifier_Config::createDefault();
				$purifier = new HTMLPurifier($config);
				$cleanhtml = $purifier->purify($html);
				$mf = Mf2\parse($cleanhtml, $note['url']);
				$md_array['ext-url'] = $note['url'];
				$md_array['title'] = "Liked a page on ".$url;  				
				//fwrite($mdfile, $note['message']."\n");
				break;	
				
// #####################################################################################################################################		
			case "read";
					$md_array['permalink'] ="/notes/".$note['type']."/".$permdate."/".$hash.".html";
					$goodreads_api = new GoodReads('qhNU8kMDrqS2Ryk8ExmyA', '/home/tom/github/blog/website/_rake/tmp/');
					$urls = $note['urls'];
					
					$page = $tag_array['page'];
					
					if ($page =="finshed") {$status ="Finished";} else {$status ="Currently";}
					
					fwrite($logfile,json_encode($urls)."\n");
					if (array_key_exists("asin",$urls)) {
						if (!is_array($urls['asin'])) {
							$data = $goodreads_api->getBookByISBN($urls['asin']);
						} else {
							$temp = $urls['asin'];
							$data = $goodreads_api->getBookByISBN($temp['name']);
						}
					}
					
					if (array_key_exists("isbn",$urls)) {
						if (!is_array($urls['isbn'])) {
							$data = $goodreads_api->getBookByISBN($urls['asin']);
						} else {
							$temp = $urls['isbn'];
							$data = $goodreads_api->getBookByISBN($temp['name']);
						}
					}
					
					$book = $data['book'];
					fwrite($logfile,json_encode($book)."\n");
					$md_array['book-title'] =$book['title'];
					$md_array['book-image_url'] =$book['small_image_url'];
					$md_array['book-url'] = $book['url'];	
					$md_array['page'] =$page;				
					$md_array['status'] =$status;
					if ($status =="Finished") {$md_array['title'] = "Completed Reading ".$md_array['book-title']." by ".$md_array['book-author'];  } else {$status ="Currently Reading ".$md_array['book-title']." by ".$md_array['book-author'];}
					$md_array['title'] = " ".$url;  
									
			break;
			
// #####################################################################################################################################
			default:
								$md_array['title'] = $permdate." ".$note['type'];  
				$md_array['permalink'] ="/notes/".$note['type']."/".$permdate."/".$hash.".html";
				break;
				
// -------------------------------------------------------------------------------------------------------------------------------------
			}

				$md_array['categories']=$categories_array;
				$frontmatter = yaml_emit ($md_array);
				$frontmatter = str_ireplace("...","---",$frontmatter);
				$mdfile = fopen($hash.".md", "w");
				fwrite($mdfile, $frontmatter);
				if (array_key_exists("message",$note)) {
					fwrite($mdfile, $note['message']."\n");
				}
				fclose($mdfile);
    	fwrite($logfile, "\n".$frontmatter."\n"); 
    }
}


// ================================
function json_parse_file( $file,$logfile ) {
$json = file_get_contents($file); 
$json_array = json_decode($json);
	foreach ($json_array as $value){	
	    		unset($res);
			$json = json_encode($value);
			$data = json_decode($json,TRUE);
			if (is_array($data)) {
					if (array_key_exists("published",$data)) {
					
						$pub = $data["published"];
						if (is_array($pub)) {$res["date"] = $pub['0'];} else {$res["date"] = $pub;} 
						$content = $data['content'];
						if (is_array($content)) {$res["message"] = $content[0];} else {$res["message"] = $content;} 
						if (isset($data['syndication'])) {
							$syndication_array = $data['syndication'];
							$tags['syndication'] = $syndication_array;
							//$res['tags'] = $tags;
						}
						$res['type'] ="twitter";
								
						switch (true) {
								case isset($data['like-of']):
									$res['type'] ="like";
									$res['url'] = $data['like-of'];
									break;
								case isset($data['photo']):
									$res['type'] ="photo";
									$tags['photo'] = $data['photo'];
									break;
								case isset($data['in-reply-to']):
									$res['type'] ="reply";
										$res['url'] = $data['in-reply-to'];
									break;
								case isset($data['bookmark-of']):
										$res['type'] ="bookmark";
										$res['url'] = $data['bookmark-of'];
									break;

								}
									if (isset($tags)) {$res['tags'] = $tags;}								
					}
			}
			if (isset($res)) {$ret[] = $res;;}	 
 		}
 		
 		
 		print_r(json_encode($ret));
 		echo "\n";
 		fwrite($logfile,json_encode($ret)."\n");
 	
 		return $ret;
}

// ================================
function csv_parse_file ( $file,$logfile ) {
 
	//echo "opening ".$file."....";
	if (($handle = fopen($file, "r")) !== FALSE) {
		//echo "Done\n";
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
			$res['source']="csv";

			// tags ===============================================
			    unset($tags_array);
			  //$data['3']  = urldecode ( $data['3'] );
			if (!strlen($data['3']) == 0 && !is_null($data['3'])) {
				
				
				//parse_str($data['3'], $tags_array);
				
				
				$oldtags_array = explode(',', $data['3']);
				$tags_array = "";
	
				for($i=0; $i < count($oldtags_array ); $i++){
					$key_value = explode(':', $oldtags_array [$i]);
					$tags_array[$key_value [0]] = $key_value [1];
				
				}
		
			//echo "tags_array===============================================\n";
		
    		//print_r($tags_array);
    		fwrite($logfile,json_encode($tags_array)."\n");
    		//echo "===============================================\n";
			$res['tags'] = $tags_array;
		}
		
		// ======================================================	
		
		// url tags	===========================================
		unset($url_array);
		
		if (!strlen($data['1']) == 0 && !is_null($data['1'])) {
		    //print_r($data['1']);
		    //echo "\n";
			switch (true) {
			
				case stristr($data['1'], 'http'):
			//	echo "found http\n";
					$res['url'] = $data['1'];			
		//			echo "url===============================================\n";
    		//		print_r($res['url']);
    			//	echo "===============================================\n";
					break;
					
				case parse_url($data['1'], PHP_URL_QUERY);
				//	echo "found query\n";
					$query = parse_url($data['1'], PHP_URL_QUERY);
					parse_str($query, $query_array);
					$key_value = explode(':', $data['1']);
					$url_array[$key_value [0]] = $query_array;
				    $res['urls'] = $url_array;
				 //   echo "url===============================================\n";
    			//	print_r($res['urls']);
    			//	echo "===============================================\n";
			//		echo "\n";
					
					break;
							
				case stristr($data['1'], 'ASIN'):
					//echo "found asin\n";	
				    $key_value = explode(':', $data['1']);
				    $url_array['asin'] = $key_value [1];
				    $res['urls'] = $url_array;
				//	echo "url===============================================\n";
    			//	print_r($res['urls']);
    			//	echo "===============================================\n";
					break;
					
				case stristr($data['1'], 'ISBN'):
					//echo "found isbn\n";	
				    $key_value = explode(':', $data['1']);
				    $url_array['isbn'] = $key_value [1];
				    $res['urls'] = $url_array;
				//	echo "url===============================================\n";
    			//	print_r($res['urls']);
    			//	echo "===============================================\n";
				//	break;
						
				case stristr($data['1'], 'IMDB'):
					//echo "found IMDB\n";	
				    $key_value = explode(':', $data['1']);
				    $url_array['imdb'] = $key_value [1];
				    $res['urls'] = $url_array;
				//	echo "url===============================================\n";
    			//	print_r($res['urls']);
    			//	echo "===============================================\n";
					break;
					
				case stristr($data['1'], 'TVDB'):
					//echo "found TVDB\n";	
				    $key_value = explode(':', $data['1']);
				    $url_array['tvdb'] = $key_value [1];
				    $res['urls'] = $url_array;
				//	echo "url===============================================\n";
    			//	print_r($res['urls']);
    			//	echo "===============================================\n";
					break;
				case stristr($data['1'], 'MB'):
					//echo "found MB (metabrainz)\n";	
				    $key_value = explode(':', $data['1']);
				    $url_array['mb'] = $key_value [1];
				    $res['urls'] = $url_array;
				//	echo "url===============================================\n";
    			//	print_r($res['urls']);
    			//	echo "===============================================\n";
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
			//echo "res===============================================\n";
    		//print_r($res);
    		//echo "===============================================\n";	
 		//fwrite($logfile,json_encode($res)."\n");
 		$ret[] = $res;
 			 
	}
}


		fclose($handle);
		return $ret;
}


$path = getcwd();

$logfile = fopen("log.log", "w");
global $logfile;

$notes_path = str_replace("_rake","_notes",$path);
chdir($notes_path);


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
					case strstr($file, "log"):
    					//echo $file." skipping log file\n";
    					fwrite($logfile,$file." skipping log file\n");
    					continue 2;
					case strstr($file, "md"):
    					//echo $file." skipping md file\n";
    					fwrite($logfile,$file." skipping md file\n");
    					continue 2;
					/*case strstr($file, "yml"):
    					//echo $file."yml file\n";
    					fwrite($logfile,$file." yml file :) \n");
    					$data = yaml_parse_file ( $file );
						//fwrite($logfile,"\n-------------------\n".json_encode($data)."\n-------------------\n");
    					create_notes($data, $logfile);
    					break;
					case strstr($file, "csv"):
    					//echo $file." CSV file\n";
    					fwrite($logfile,$file." csv file :) \n");
    					$data = csv_parse_file ( $file, $logfile );

    					create_notes($data, $logfile);
						break;
						*/
					case strstr($file, "json"):
    					//echo $file." json file\n";
    					fwrite($logfile,$file." json file :) \n");
    					$data = json_parse_file ( $file, $logfile );

    					create_notes($data, $logfile);
						break;						
					}
			}
	}
}
    	fclose($logfile);
?>
