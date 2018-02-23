#!/usr/bin/env php
<?php
// key: qhNU8kMDrqS2Ryk8ExmyA
//secret: 1tICNtAofpr0Coycb4eacrf4FcFCWSOzW8novjYL8
require './vendor/autoload.php';

require_once './goodreads-api/GoodReads.php';
date_default_timezone_set('Australia/Brisbane');
use Ramonztro\SimpleScraper\SimpleScraper;
	
	

function create_notes($data,$logfile, $WM_recv) {

   foreach ($data as $note) {
//    	json_encode($data);
    	
   	if (isset($note['tags']) && !is_array($note['tags'])) {
   			//fwrite($logfile,json_encode($temp)."\n");
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
				$md_array['redirect_from'][] = "/sl/n/".$note['type'][0]."/d".date("YmdHis", strtotime($note['date'])).".html";
				$md_array['redirect_from'][] = "/sl/n/".$note['type'][0]."/h.".$hash.".html";
				
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
										
										if (isset($note['syndication'])) {
												$md_array['syndication'] = $note['syndication'];
										}
				
		switch ($note['type']) {
// -------------------------------------------------------------------------------------------------------------------------------------
		
// #####################################################################################################################################
			case "scrobble":
			
				$categories_array[] = $tag_array['title'];
				$categories_array[] = $tag_array['artist'];
				$categories_array[] = $tag_array['album'];
				$md_array['hidden'] = "true";
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
				$md_array['mf'] = $mf;
				$scraper = new SimpleScraper($note['url']);
				$ogp = $scraper->getOgp();
				//$md_array['ogp'] = $ogp;
				$twitCard = $scraper->getTwitter();
				//$md_array['twitCard'] = $twitCard;
				
				$md_array['ext']['url'] = $note['url'];
				$md_array['ext']['title'] =  $ogp['title'];
				$md_array['ext']['description'] = $ogp['description'];
				$md_array['ext']['image_url'] = $ogp['image'];
				$md_array['ext']['image_width'] = $ogp['image:width'];
				$md_array['ext']['image_height'] = $ogp['image:height'];				
				
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
					
					$book = $note['book'];
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
				if (array_key_exists("message",$data)) {
					fwrite($mdfile, $note['message']."\n");
				}
				fclose($mdfile);
				$WM_array[]="";
				$WM_recv_array['"'.$md_array['permalink'].'"']=$WM_array;
    	fwrite($logfile, "\n".$frontmatter."\n"); 
    }
    return $WM_recv_array;
    }

// ================================
function json_parse_file( $file,$logfile ) {

 
	// Read the input as a string to handle both form-encoded and JSON requests
	$xray = new p3k\XRay();
 
	// Read the input as a string to handle both form-encoded and JSON requests
	$input = file_get_contents($file);

 
	// Output as an Mf2 array
	//$item = $request->toMf2();
 
	// Turn it into an Mf2 page
	//$mf2 = ['items' => [$item]];
 
	// Process via XRay
	//$parsed = $xray->process(false, $mf2);
	$parsed = $xray->parse('', $input);
	print_r($parsed);

	$ret["date"] = $parsed['data']['published'];
	if (isset($parsed['data']['content']['text'])) {
		$ret["message"] = $parsed['data']['content']['text'];
	} else {$ret["message"]="";}

	$ret["syndication"] = $parsed['data']['syndication'];


						$ret['type'] ="twitter";
						switch (true) {
								case isset($parsed['data']['like-of']):
									$ret['type'] ="like";
									$ret['url'] = $parsed['data']['like-of'][0];
									break;
								case isset($parsed['data']['in-reply-to']):
									$ret['type'] ="reply";
										$ret['url'] = $parsed['data']['in-reply-to'][0];
									break;
								case isset($parsed['data']['bookmark-of']):
										$ret['type'] ="bookmark";
										$ret['url'] = $parsed['data']['bookmark-of'][0];
									break;

								}
 
/*
$json = file_get_contents($file); 
$json_array = json_decode($json);
	foreach ($json_array as $value){	
	    		unset($res);
			$json = json_encode($value);
			$data = json_decode($json,TRUE);
			if (is_array($data)) {
					if (array_key_exists("published",$data)) {
					
						$pub = $note["published"];
						if (is_array($pub)) {
							$res["date"] = $pub['0'];
							} else {$
								$res["date"] = $pub;} 
						$content = $note['content'];
						if (is_array($content)) {
							$res["message"] = $content[0];
								} else {
									$res["message"] = $content;
								} 
						if (isset($note['syndication'])) {
							$syndication_array = $note['syndication'];
							$tags['syndication'] = $syndication_array;
							//$res['tags'] = $tags;
						}
						$res['type'] ="twitter";
								
						switch (true) {
								case isset($note['like-of']):
									$res['type'] ="like";
									$res['url'] = $note['like-of'];
									break;
								case isset($note['photo']):
									$res['type'] ="photo";
									$tags['photo'] = $note['photo'];
									break;
								case isset($note['in-reply-to']):
									$res['type'] ="reply";
										$res['url'] = $note['in-reply-to'];
									break;
								case isset($note['bookmark-of']):
										$res['type'] ="bookmark";
										$res['url'] = $note['bookmark-of'];
									break;

								}
									if (isset($tags)) {$res['tags'] = $tags;}								
					}
			}
			if (isset($res)) {$ret[] = $res;;}	 
 		}
 		
 		*/
 		print_r(json_encode($ret,JSON_PRETTY_PRINT));
 		echo "\n";
 		fwrite($logfile,json_encode($ret,JSON_PRETTY_PRINT)."\n");
 	$r[] = $ret;
 		return $r;
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
 			$res['type'] = $note['0'];
 			$tmpdate = date_create_from_format('d/m/Y', $note['4']);
 			$res['date'] = date_format($tmpdate, 'Y-m-d');
 			$res['message'] = $note['2'];
			$res['source']="csv";

			// tags ===============================================
			    unset($tags_array);
			  //$note['3']  = urldecode ( $note['3'] );
			if (!strlen($note['3']) == 0 && !is_null($note['3'])) {
				
				
				//parse_str($note['3'], $tags_array);
				
				
				$oldtags_array = explode(',', $note['3']);
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
		
		if (!strlen($note['1']) == 0 && !is_null($note['1'])) {
		    //print_r($note['1']);
		    //echo "\n";
			switch (true) {
			
				case stristr($note['1'], 'http'):
			//	echo "found http\n";
					$res['url'] = $note['1'];			
		//			echo "url===============================================\n";
    		//		print_r($res['url']);
    			//	echo "===============================================\n";
					break;
					
				case parse_url($note['1'], PHP_URL_QUERY);
				//	echo "found query\n";
					$query = parse_url($note['1'], PHP_URL_QUERY);
					parse_str($query, $query_array);
					$key_value = explode(':', $note['1']);
					$url_array[$key_value [0]] = $query_array;
				    $res['urls'] = $url_array;
				 //   echo "url===============================================\n";
    			//	print_r($res['urls']);
    			//	echo "===============================================\n";
			//		echo "\n";
					
					break;
							
				case stristr($note['1'], 'ASIN'):
					//echo "found asin\n";	
				    $key_value = explode(':', $note['1']);
				    $url_array['asin'] = $key_value [1];
				    $res['urls'] = $url_array;
				//	echo "url===============================================\n";
    			//	print_r($res['urls']);
    			//	echo "===============================================\n";
					break;
					
				case stristr($note['1'], 'ISBN'):
					//echo "found isbn\n";	
				    $key_value = explode(':', $note['1']);
				    $url_array['isbn'] = $key_value [1];
				    $res['urls'] = $url_array;
				//	echo "url===============================================\n";
    			//	print_r($res['urls']);
    			//	echo "===============================================\n";
				//	break;
						
				case stristr($note['1'], 'IMDB'):
					//echo "found IMDB\n";	
				    $key_value = explode(':', $note['1']);
				    $url_array['imdb'] = $key_value [1];
				    $res['urls'] = $url_array;
				//	echo "url===============================================\n";
    			//	print_r($res['urls']);
    			//	echo "===============================================\n";
					break;
					
				case stristr($note['1'], 'TVDB'):
					//echo "found TVDB\n";	
				    $key_value = explode(':', $note['1']);
				    $url_array['tvdb'] = $key_value [1];
				    $res['urls'] = $url_array;
				//	echo "url===============================================\n";
    			//	print_r($res['urls']);
    			//	echo "===============================================\n";
					break;
				case stristr($note['1'], 'MB'):
					//echo "found MB (metabrainz)\n";	
				    $key_value = explode(':', $note['1']);
				    $url_array['mb'] = $key_value [1];
				    $res['urls'] = $url_array;
				//	echo "url===============================================\n";
    			//	print_r($res['urls']);
    			//	echo "===============================================\n";
					break;
							
/*										
				case strstr($note['1'], ','):
					$oldurl_array = explode(',', $note['1']);
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
$webmention_path = str_replace("_rake",".jekyll-cache",$path);
$wb_recv_file = $webmention_path."/webmention_io_received.yml"; 
$WM_recv="";
	
	
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
    				case strstr($file, "temp"):
    					//echo $file." skipping md file\n";
    					fwrite($logfile,$file." skipping temp file\n");
    					continue 2;
    					
					case strstr($file, "yml"):
    					echo "Found ".$file."yml file\n";
    					fwrite($logfile,"Found ".$file."yml file :) \n");
    					$data = yaml_parse_file ( $file );
						fwrite($logfile,"\n-----S-CONTENTS-------------\n".yaml_emit($data)."\n-----E-CONTENTS-------------\n");
    					$WM_recv[] = create_notes($data, $logfile,$WM_recv);
    					break;
					/*case strstr($file, "csv"):
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

    					$WM_recv[] = create_notes($data, $logfile,$WM_recv);
						break;						
					}
			}
	}
}
#mkdir($webmention_path."/", 0755, true);
#	yaml_emit_file($webmention_path."/webmention_io_received.yml",$WM_recv);
    	fclose($logfile);
?>
