#!/usr/bin/env php
<?php

	$input = file_get_contents("https://webmention.io/api/mentions.jf2?domain=tomasparks.github.io&token=SoUv2HnRggu8iJQ-PY9B7A&&per-page=1000000000");

#$input = ltrim($input,"f(");
#$input = rtrim($input,")");

//print_r(json_decode($input, true));

$json =json_decode($input, true);
//print_r ($json['children'][0]);


	foreach ($json['children'] as $value) {
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
				
				
				switch ($value['wm-property']) {
				    case "in-reply-to":
				        $db[$path]['replied'][]=$value;
				    break;
				    case "like-of":
				    	$db[$path]['liked'][]=$value;
				    break;
				    case "mention-of":
				    	  $db[$path]['mentioned'][]=$value;
				    break;
				    case "repost-of":
				    	  $db[$path]['repost'][]=$value;
				    break;
				    case "bookmark-of":
				    	  $db[$path]['bookmarked'][]=$value;
				    break;
				    case "rsvp":
				    	  $db[$path]['rsvped'][]=$value;
				    break;
				    }
				
				
				// h-card section
				$hcard[$value['author']['name']] = array ( "name" => $value['author']['name'],"photo" => $value['author']['photo']  );
				
				switch ($value['author']['url']) {
				    case "facebook.com":
				    break;
                    }
	}
	
	
	  yaml_emit_file( "/home/tom/github/website/sources/gobal/_data/cache/nickname.yml", $hcard);
	  yaml_emit_file( "/home/tom/github/website/sources/gobal/_data/webmention/output.yml", $db);
	  foreach ($db as $path => $value) {
	  echo "path: ".$path."\n";
	    	if(is_array($value))	{
	                      mkdir("/home/tom/github/website/sources/gobal/_data/webmention/".$path."/");
	                      chdir("/home/tom/github/website/sources/gobal/_data/webmention/".$path."/");
	                      foreach ($value as $type => $arr ) {
	                      
	                    //$tmp_db = yaml_parse_file("/home/tom/github/website/sources/gobal/_data/webmention/".$path."/".$type.".yml");
            			//$arr = array_merge($arr,$tmp_db);
            			//$arr = array_unique(array_merge($arr,$tmp_db), SORT_REGULAR);
	                        //yaml_emit_file( "/home/tom/github/website/sources/gobal/_data/webmention/".$path."/".$type.".yml", $arr);
	                        $json_data = json_encode($arr,JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
                            file_put_contents("/home/tom/github/website/sources/gobal/_data/webmention/".$path."/".$type.".json", $json_data);
	                      }
	  }
	}  
//print_r ($db);
//print_r ($db);
?>
