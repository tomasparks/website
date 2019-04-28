#!/usr/bin/env php
<?php
require './vendor/autoload.php';

	// Read the input as a string to handle both form-encoded and JSON requests
	$xray = new p3k\XRay();
 
	// Read the input as a string to handle both form-encoded and JSON requests
	$input = file_get_contents("https://granary.io/twitter/%40me/@self/@app/?format=mf2-json&access_token_key=965564724560609280-akzIBxc445Wof45B1JPZ8kjXopGpDWA&access_token_secret=ls65zMjMa49xbGjG15IhaVqLcgAJh5bmixStjq3VtKlJ6");

 
	// Output as an Mf2 array
	//$item = $request->toMf2();
 
	// Turn it into an Mf2 page
	//$mf2 = ['items' => [$item]];
 
	// Process via XRay
	//$parsed = $xray->process(false, $mf2);
	$parsed = $xray->parse('', $input);
	//print_r($parsed);
	
	
	foreach ($parsed['data']['items'] as $value) {
				//$date = new DateTime("@$epoch");
				$date_split = date_parse($value['published']);
				$db[$date_split['year']]
				[str_pad($date_split['month'], 2, '0', STR_PAD_LEFT)]
				[str_pad($date_split['day'], 2, '0', STR_PAD_LEFT)]
				[]=$value;
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
                    mkdir("/home/tom/github/website/sources/notes-src/_data/notes".str_pad($ykey, 2, '0', STR_PAD_LEFT)."/", 0755, true);
            		chdir("/home/tom/github/website/sources/notes-src/_data/notes".str_pad($ykey, 2, '0', STR_PAD_LEFT)."/");
            		
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
	yaml_emit_file ("output.yml" , $db);   
?>
