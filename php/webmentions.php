#!/usr/bin/env php
<?php

$oldinput = file_get_contents("https://webmention.io/api/mentions.jf2?domain=tomasparks.github.io&token=SoUv2HnRggu8iJQ-PY9B7A&&per-page=1000000000");
$newinput = file_get_contents("https://webmention.io/api/mentions.jf2?domain=tomasparks.name&token=f5RLUDZ0NmWQAGd8vEwC8g&per-page=1000000000");
#$input = ltrim($input,"f(");
#$input = rtrim($input,")");

//print_r(json_decode($input, true));

$oldjson =json_decode($oldinput, true);
$newjson =json_decode($newinput, true);
$json = array_merge($oldjson['children'],$newjson['children']);
$json  = array_unique(array_merge($oldjson['children'],$newjson['children']), SORT_REGULAR);
//$json = $oldjson;


//print_r($json);

//print_r ($json['children'][0]);


	foreach ($json as $value) {
	            //print_r ($value);
				//$date = new DateTime("@$epoch");
				$date_split = date_parse($value['wm-received']);
				
				$target_path = parse_url($value['wm-target'], PHP_URL_PATH);
				//echo "".$target_path."\n";
				$target_path_arr = array_filter(explode("/", $target_path));
foreach ($target_path_arr as $path) {
if (strlen($path)>=1) {break;}
}

switch ($path) {
case "archive":
    $path = "main";
    break;
}
				
				
				        $db[$path][]=$value;
				
				
				// h-card section
				$hcard[$value['author']['name']] = array ( "name" => $value['author']['name'],"photo" => $value['author']['photo']  );
				
				switch ($value['author']['url']) {
				    case "facebook.com":
				    break;
                    }
	}
	
	
	  yaml_emit_file( "/home/tom/github/website/sources/gobal/_data/cache/nickname.yml", $hcard);
	  //yaml_emit_file( "/home/tom/github/website/sources/gobal/_data/webmention/output.yml", $db);
	  foreach ($db as $path => $value) {
	  echo "path: ".$path."\n";
	    	if(is_array($value))	{
	                        if (file_exists("/home/tom/github/website/sources/gobal/_data/webmention/".$path.".json"))  {
	                      
	                            $file = file_get_contents("/home/tom/github/website/sources/gobal/_data/webmention/".$path.".json");
	                            $tmp_db = json_decode($file, true);                   
	                   //  print_r($tmp_db);
	                  //  $tmp_db = yaml_parse_file("/home/tom/github/website/sources/gobal/_data/webmention/".$path.".yml");
            			//$newdb = array_merge($value,$tmp_db);
            			$newdb = array_unique(array_merge($value,$tmp_db), SORT_REGULAR);
            			}
	                     //   yaml_emit_file( "/home/tom/github/website/sources/gobal/_data/webmention/".$path.".yml", $value);
	                        $json_data = json_encode($newdb,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

                            file_put_contents("/home/tom/github/website/sources/gobal/_data/webmention/".$path.".json", $json_data);
	                     
	  }
	}  
	
//print_r ($db);
//print_r ($db);
?>
