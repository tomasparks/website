#!/usr/bin/env php
<?php
/*
youtube-dl -f 'best' --download-archive archive.txt --playlist-end 100 -u 'tomasparks.ts@gmail.com' -p 'blU8l6PLW!#X' -o '%(title)s.%(ext)s'  https://www.youtube.com/feed/history
youtube-dl -f 'best' --download-archive archive.txt --playlist-end 10 -o '%(title)s.%(ext)s' https://www.youtube.com/user/rpgmp3/videos

*/
/*
if (file_exists('./tomasparks_lb-2018-02-09.json')) {
	$str = file_get_contents('./tomasparks_lb-2018-02-09.json');
	$json = json_decode($str, true);
	//// echo "\n".yaml_emit($json)."\n";
		foreach ($json as $value){
		// print_r($value);
		}
	
}*/
//date_default_timezone_set("Australia/Brisbane")."\n";

echo "loading Settings.....\n";
$GLOBALS["settings"] = yaml_parse_file("/home/tom/github/website/sources/notes-src/_php/rhythmdb_settings.yml");
echo "loading rewrite_rules.....\n";
$GLOBALS["rewrite_rules"] = yaml_parse_file("/home/tom/github/website/sources/notes-src/_php/rewrite_rules.yml");
echo "loading IA_S3s.....\n";
$GLOBALS["IA_S3"] = yaml_parse_file("/home/tom/github/website/sources/notes-src/_php/IA_S3.yml");
echo "Completed loading config files\n";



//$GLOBALS["settings"]["skip"]["type"]["postcast"]=false;
//$GLOBALS["settings"]["skip"]["type"]["audio"]=false;
$GLOBALS["settings"]["debug"]=0;

//$GLOBALS["rewrite_rules"]["twitter"] = false;
//$GLOBALS["rewrite_rules"]["filenames"][""] = false;


function rewrite_BucketName($tmp,$type) {
// echo "doing rewrite_BucketName(".$tmp,$type.") work........\n";

//$GLOBALS["rewrite_rules"]["twitter"][][$tmp] = $tmp;

	if ($type=="author") {
	    // echo "doing author........\n";
	    // echo "ISSET: ".(isset($GLOBALS["rewrite_rules"]["BucketName"]["author"][$tmp]));
		if (isset($GLOBALS["rewrite_rules"]["BucketName"]["author"][$tmp])) {
		    // echo "ISSET: ".(isset($GLOBALS["rewrite_rules"]["BucketName"]["author"][$tmp]));
			$ret = $GLOBALS["rewrite_rules"]["BucketName"]["author"][$tmp];
			}  else {

//remove non alpha numeric characters
$ret = preg_replace("/[^A-Za-z0-9 ]/", '', $tmp);

//replace more than one space to underscore
$ret  = preg_replace('/([\s])\1+/', '_', $ret );

//convert any single spaces to underscrore
$ret  = str_replace(" ","_",$ret); 
			$GLOBALS["rewrite_rules"]["BucketName"]["author"][$tmp] = $ret;
			//$ret = $tmp;
		}
	}
		if ($type=="album") {
	    // echo "doing album........\n";
	    // echo "ISSET: ".(isset($GLOBALS["rewrite_rules"]["BucketName"]["album"][$tmp]));
		if (isset($GLOBALS["rewrite_rules"]["BucketName"]["album"][$tmp])) {
			$ret = $GLOBALS["rewrite_rules"]["BucketName"]["album"][$tmp];
			} else {
			 //remove non alpha numeric characters
            $ret = preg_replace("/[^A-Za-z0-9 ]/", '', $tmp);

            //replace more than one space to underscore
            $ret  = preg_replace('/([\s])\1+/', '_', $ret );

            //convert any single spaces to underscrore
            $ret  =str_replace(" ","_",$ret);
			$GLOBALS["rewrite_rules"]["BucketName"]["album"][$tmp] = $ret;
			//$ret =$tmp;
		}
	} 
		yaml_emit_file("/home/tom/github/website/sources/notes-src/_php/rewrite_rules.yml",$GLOBALS["rewrite_rules"]);	
return $ret;


}


function rewrite_twitter($tmp,$type) {

//$GLOBALS["rewrite_rules"]["twitter"][][$tmp] = $tmp;

	if ($type=="author") {
		if (isset($GLOBALS["rewrite_rules"]["twitter"]["author"][$tmp])) {
			$ret = $GLOBALS["rewrite_rules"]["twitter"]["author"][$tmp];
			} else {
			
			$GLOBALS["rewrite_rules"]["twitter"]["author"][$tmp] = $tmp;
			$ret =$tmp;
		} 
	}
		if ($type=="album") {
		if (isset($GLOBALS["rewrite_rules"]["twitter"]["album"][$tmp])) {
			$ret = $GLOBALS["rewrite_rules"]["twitter"]["album"][$tmp];
			} else {
			$GLOBALS["rewrite_rules"]["twitter"]["album"][$tmp] = $tmp;
			$ret =$tmp;
		} 
	} 
	
	

return $ret;
}

function ias3_upload($src,$bucket,$filename) {
	// echo "doing ias3_upload(".$src,$bucket,$filename.") work........\n";
	passthru("wget '".$src."' -O /tmp/".$filename."");
	//Your S3 access key: kLHQfJXQZDtIK8FE
//Your S3 secret key: OXENcmgCoESWDBTp
			/* $ch = curl_init("http://s3.us.archive.org/".$bucket."/".$filename."");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'x-amz-auto-make-bucket:1',
    'authorization: LOW kLHQfJXQZDtIK8FE:OXENcmgCoESWDBTp',
    'x-archive-meta01-collection:opensource_audio',
    'x-archive-meta-mediatype:audo'
));
curl_setopt($ch,CURLOPT_POSTFIELDS,array(
'file' => '@' . '/tmp/'.$filename.'')
));
// echo $ch;
			curl_exec($ch);
			$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			// echo $retcode; */
passthru("curl --location --header 'x-amz-auto-make-bucket:1' \
         --header 'authorization: LOW kLHQfJXQZDtIK8FE:OXENcmgCoESWDBTp' \
         --header 'x-archive-meta-collection:opensource_audio' \
         --header 'x-archive-meta-mediatype:audo' \
         --header 'x-archive-meta-title:".str_replace("_"," ",$bucket)."' \
         --header 'x-archive-meta-creator:' \
         --upload-file '/tmp/".$filename."' \
         'http://s3.us.archive.org/".$bucket."/".$filename."'" );	
           
passthru("rm '/tmp/".$filename."'");	
			
			

	   // curl --location --header 'x-amz-auto-make-bucket:1' \
       //  --header 'x-archive-meta01-collection:opensource' \
       //  --header 'x-archive-meta-mediatype:texts' \
       //  --header 'x-archive-meta-sponsor:Andrew W. Mellon Foundation' \
       //  --header 'x-archive-meta-language:eng' \
       //  --header "authorization: LOW kLHQfJXQZDtIK8FE:OXENcmgCoESWDBTp" \
       //  --upload-file /home/samuel/public_html/intro-to-k.pdf \
       //  "http://s3.us.archive.org/".$bucket."/".$filename.""
}


function ias3($src,$dest,$bucket,$filename) {
	// echo "doing ias3(\n".$src."\n".$dest."\n".$bucket."\n".$filename."\n) ........\n";
	
	//$ch = curl_init();
	//curl_setopt($ch, CURLOPT_URL, "http://s3.us.archive.org/".$bucket."/".$filename."");  

		    echo "Checking http://s3.us.archive.org/".$bucket."/".$filename."....";
			$ch = curl_init("http://s3.us.archive.org/".$bucket."/".$filename."");
			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_exec($ch);
			$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			if ($retcode >=400) {
					echo "FAILED (".$retcode.")\n";

					ias3_upload($src,$bucket,$filename);
					$GLOBALS["IA_S3"][$bucket]["$filename"] = false;
	}
				elseif ($retcode ==200) {
					echo "OK (".$retcode.")\n";
					$GLOBALS["IA_S3"][$bucket]["$filename"] = true;
					//ias3_upload($src,$bucket,$filename);
				
	}
	
	//// echo yaml_emit($GLOBALS)."\n";
		//// echo "\nreturning with retcode: ".$retcode."\n";
//sleep(1);
		yaml_emit_file("/home/tom/github/website/sources/notes-src/_php/IA_S3.yml",$GLOBALS["IA_S3"]);
//sleep(60);		
}



function audiourls($data,$type) {
 echo yaml_emit($data);
    if (isset($data['mountpoint'])) {
	    if ( (parse_url($data['mountpoint'], PHP_URL_SCHEME)=="http") OR (parse_url($data['mountpoint'], PHP_URL_SCHEME)=="https") ) {
	    	$ret[] =$data['mountpoint'];
	    	$url=urldecode($data['mountpoint']);
	    }
	}
	if ( (parse_url($data['location'], PHP_URL_SCHEME)=="http") OR (parse_url($data['location'], PHP_URL_SCHEME)=="https") ) {
		$ret[] =$data['location'];	
		$url =urldecode($data['location']);	
	}

	echo "url: ".$url."\n";
	$GLOBALS["rewrite_rules"]["HowToRewrite"][parse_url($url, PHP_URL_HOST)]["BucketName"]['author']='rewrite';
	$GLOBALS["rewrite_rules"]["HowToRewrite"][parse_url($url, PHP_URL_HOST)]["BucketName"]['album']='rewrite';
//	$GLOBALS["rewrite_rules"]["HowToRewrite"][parse_url($url, PHP_URL_HOST)]["fielname"]=false;
	$GLOBALS["rewrite_rules"]["HowToRewrite"][parse_url($url, PHP_URL_HOST)]["url"]=false;		
	
	$bucket="";
	if ($GLOBALS["rewrite_rules"]["HowToRewrite"][parse_url($url, PHP_URL_HOST)]["BucketName"]['author']=='rewrite') 
	{$bucket .= "".rewrite_BucketName($data['album'], "album");
	}
	

    if ($GLOBALS["rewrite_rules"]["HowToRewrite"][parse_url($url, PHP_URL_HOST)]["BucketName"]['album']=='rewrite') {
	//// echo $type."\n";
	    $bucket .="-by-".rewrite_BucketName($data['artist'], "author")."";
	 }
	    
	    if ($GLOBALS["rewrite_rules"]["HowToRewrite"][parse_url($url, PHP_URL_HOST)]["fielname"]) {
	    
	    			 //remove non alpha numeric characters
            $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $data['title']);

            //replace more than one space to underscore
            $filename  = preg_replace('/([\s])\1+/', '_', $filename );

            //convert any single spaces to underscrore
            $filename  =str_replace(" ","_",$filename);
            
            $filename = $filename.".mp3";} else {$filename = basename(parse_url($url, PHP_URL_PATH));
            $GLOBALS["rewrite_rules"]["HowToRewrite"][parse_url($url, PHP_URL_HOST)]["fielname"]=false;}

	$archive_url = "http://archive.org/download/".$bucket."/".$filename;
//    // echo "calling ias3(".$url."\n".$archive_url."\n".$bucket."\n".$filename."\n".")";
	ias3(urldecode($url),$archive_url,$bucket,$filename);

	$ret[] =$archive_url; 
	
return $ret;
}

function data2mf($data,$db,$type) {

	if (isset($data['play-count']) && $data['play-count'] >= "1") {
if ($GLOBALS["settings"]["debug"])  {echo "doing data2mf2(\n";echo yaml_emit ($data);echo "\n)....\n";}		
				$epoch = $data['last-played'];
				$date = new DateTime("@$epoch");
				$date_split = date_parse($date->format('Y-m-d H:i:s'));
				
				$res['type'] = "entry";
				$res['published'] = $date->format('Y-m-d\TH:i:sP'); 
				$res['category'][] = "scrobble";
				$res['category'][] = "audio";
				$res['category'][] = $data['album'];
				$res['category'][] = $data['artist'];
				
				$res["listen-of"]["h-cite"]['url'] = $data['subtitle'];
				$res["listen-of"]["h-cite"]['photo'] ="";
				// echo "\tcalling audiourls(\n";
		       // print_r ($data);
		       // print_r ($type);
		       // echo "\t)\n";
				$res["listen-of"]["h-cite"]['audio'] = audiourls($data,$type); 
				$res["listen-of"]["h-cite"]['name'] = $data['title'];
				$res["listen-of"]["h-cite"]["author"] = $data['artist'];
				$res["listen-of"]["h-cite"]["content"] = strip_tags($data['description']);
				$res['content']['text'] = " \ud83c\udfa7 Listened to ".$data['title']." by ".rewrite_twitter($data['artist'], "author")." From ".rewrite_twitter($data['album'], "album");
				
				$db[$date_split['year']]
				[str_pad($date_split['month'], 2, '0', STR_PAD_LEFT)]
				[str_pad($date_split['day'], 2, '0', STR_PAD_LEFT)]
				[]=$res;				
				//$ret[] =$res;
				unset($res);				

			}
				if ($GLOBALS["settings"]["debug"])  {echo "returning from data2mf2(\n";echo yaml_emit ($db); echo "\n)\n";}	
	return $db;
}

// start here
if ($GLOBALS["settings"]["debug"])  {echo"Redading rhythmdb.xml....";}	
if (file_exists('/home/tom/.local/share/rhythmbox/rhythmdb.xml')) {
		$xml = simplexml_load_file('/home/tom/.local/share/rhythmbox/rhythmdb.xml');
		//$json = json_encode($xml);
		//$data = json_decode($json,TRUE);
	//	$path = getcwd();


		chdir("/home/tom/github/website/sources/notes-src/_php/");

	foreach ($xml as $value){
				if ($GLOBALS["settings"]["debug"]==10)  {  echo "-----\n"; 	}
		$json = json_encode($value);
		$data = json_decode($json,TRUE);
		if ($GLOBALS["settings"]["debug"]==10)  { print_r($data);}
		if ($GLOBALS["settings"]["debug"]==10)  { echo "\n---\n".json_encode($data)."\n----\n";}

		$att = $data['@attributes'];
	
	
		//if ($att['type']== "song") {
		//	$db = data2mf($data,$db,"audio");
		//	$db = $db;		
			//// echo "--\n";
		//}
	
			if ($att['type']== "podcast-feed") {
			$GLOBALS["podcast-feeds"][] = $data;
	}	
	
		if ($att['type']== "podcast-post") {
		    if ($GLOBALS["settings"]["debug"]==10)  { echo "calling data2mf(\n";
		       print_r ($data);
		       echo "\t$db\n";
		       echo "\"podcast\")\n"; }
			$db = data2mf($data,$db,"podcast");
			$db = $db;
	}	

//// echo yaml_emit($db)."\n";

}


foreach ($db as $ykey => $year){
  	if(is_array($year))	{
    		// echo "year == is_array true\n";
    	//	// echo yaml_emit($year)."\n";
   // 		// echo "\n";
 			foreach ( $year as $mkey => $month)	{
         		 if(is_array($month)){
                	// echo "month == is_array true\n";
    				//// print_r($month);
    	//			// echo "\n";
                  // // echo yaml_emit($month)."\n";
                    mkdir("/home/tom/github/website/sources/notes-src/_data/notes/".str_pad($ykey, 2, '0', STR_PAD_LEFT)."/", 0755, true);
            		chdir("/home/tom/github/website/sources/notes-src/_data/notes/".str_pad($ykey, 2, '0', STR_PAD_LEFT)."/");
            		
            		foreach ($month as $dkey => $day) {
            		
            			yaml_emit_file ("db-".str_pad($mkey, 2, '0', STR_PAD_LEFT)."-".str_pad($dkey, 2, '0', STR_PAD_LEFT).".yml" , $day);  
            		
            		}
            		
            		if (file_exists("db-".str_pad($mkey, 2, '0', STR_PAD_LEFT)."-".str_pad($dkey, 2, '0', STR_PAD_LEFT).".yml")) {
            			$tmp_db = yaml_parse_file("db-".str_pad($mkey, 2, '0', STR_PAD_LEFT)."-".str_pad($dkey, 2, '0', STR_PAD_LEFT).".yml");
            			$day = array_merge($day,$tmp_db);
            			$day = array_unique(array_merge($day,$tmp_db), SORT_REGULAR);
           		}
                  	//yaml_emit_file ("db-".str_pad($mkey, 2, '0', STR_PAD_LEFT)."-00.yml" , $month);   
           }
          // chdir("./..");
           
       }
	}

	}
		yaml_emit_file ("/home/tom/github/website/sources/notes-src/_php/rhythmdb_settings.yml", $GLOBALS["settings"]); 
		yaml_emit_file("/home/tom/github/website/sources/notes-src/_php/rewrite_rules.yml",$GLOBALS["rewrite_rules"]);
		yaml_emit_file("/home/tom/github/website/sources/notes-src/_php/IA_S3.yml",$GLOBALS["IA_S3"]);
		yaml_emit_file("/home/tom/github/website/sources/notes-src/_php/podcast-feeds.yml",$GLOBALS["podcast-feeds"]);
		//yaml_emit_file("/home/tom/github/blog/notes-src/_php/globals.yml", $GLOBALS);
		
				
		yaml_emit_file ("/home/tom/github/website/sources/notes-src/_php/output.yml", $db);  
 		// // echo yaml_emit($ret)."\n";
 	//	// print_r (scandir($notes_path));
 		//mkdir($notes_path."/local/".date("Y")."/", 0755, true);
 		

	
  			//chdir($notes_path."/local/".date("Y").'/');
 		//	yaml_emit_file ("r".date("m").".yml" , $ret);
	
} else {
    exit('Failed to open /home/tom/.local/share/rhythmbox/rhythmdb.xml.');
}



?>
