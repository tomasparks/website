#!/usr/bin/env php
<?php
if (file_exists('/home/tom/.local/share/rhythmbox/rhythmdb.xml')) {
		$xml = simplexml_load_file('/home/tom/.local/share/rhythmbox/rhythmdb.xml');
		//$json = json_encode($xml);
		//$data = json_decode($json,TRUE);
		$path = getcwd();

		$notes_path = str_replace("_rake","_notes",$path);
		chdir($notes_path);


	foreach ($xml as $value){
		echo "-----\n";
		$json = json_encode($value);
		$data = json_decode($json,TRUE);
		//print_r($data);
		//echo "\n---\n".json_encode($data)."\n----\n";

		$att = $data['@attributes'];
	
	
		if ($att['type']== "song") {
			if ($data['play-count'] >= "1") {
		
				$tags['title'] = $data['title'];
				$tags['artist'] = $data['artist'];
				$tags['album'] = $data['album'];
				$tags['play-count'] = $data['play-count'];
				$epoch = $data['last-played'];
				$date = new DateTime("@$epoch");
				$res['date'] = $date->format('Y-m-d H:i:s'); 
				$date_split = date_parse($date->format('Y-m-d H:i:s'));
				$res['type'] = "scrobble";
				$res['tags'] = http_build_query($tags);
				$db[$date_split['year']][$date_split['month']][]=$res;
				//$ret[] =$res;
				unset($res);		
			}
			echo "--\n";
		}
	
	
		if ($att['type']== "podcast-post") {
			if ($data['play-count'] >= "1") {
		
				$tags['title'] = $data['title'];
				$tags['artist'] = $data['artist'];
				$tags['album'] = $data['album'];
				$tags['play-count'] = $data['play-count'];
				$epoch = $data['last-played'];
				$date = new DateTime("@$epoch");
				$res['date'] = $date->format('Y-m-d H:i:s'); 
				$date_split = date_parse($date->format('Y-m-d H:i:s'));
		
				$res['type'] = "scrobble";
				$res['tags'] = http_build_query($tags);
		
				$db[$date_split['year']][$date_split['month']][]=$res;
				//$ret[] =$res;
				unset($res);		
			}
			echo "--\n";
		}


	}	

	//print_r($db);
	foreach ($db as $ykey => $year){
    	if(is_array($year))	{
    		echo "year == is_array true\n";
    		print_r($ykey);
    		echo "\n";
  			foreach ( $year as $mkey => $month)	{
           		 if(is_array($month)){
                	echo "month == is_array true\n";
    		print_r($month);
    		echo "\n";
                    echo yaml_emit($month)."\n";
                  		mkdir($notes_path."/local/".$ykey."/", 0755, true);
                  		chdir($notes_path."/local/".$ykey."/");
                  		yaml_emit_file ("r".$mkey.".yml" , $month);   
            }
           
       }
}
}
 		// echo yaml_emit($ret)."\n";
 	//	print_r (scandir($notes_path));
 		//mkdir($notes_path."/local/".date("Y")."/", 0755, true);
 		

	
  			//chdir($notes_path."/local/".date("Y").'/');
 		//	yaml_emit_file ("r".date("m").".yml" , $ret);
	
} else {
    exit('Failed to open /home/tom/.local/share/rhythmbox/rhythmdb.xml.');
}



?>
