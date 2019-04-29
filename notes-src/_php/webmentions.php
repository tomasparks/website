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
				$db[$value['wm-property']]
				[]=$value;
				
				
				// h-card section
				$hcard[$value['author']['name']] = array ( "name" => $value['author']['name'],"photo" => $value['author']['photo']  );
				
				switch ($value['author']['url']) {
				    case "facebook.com":
				    break;
                    }
	}
//print_r ($db);
print_r ($hcard);
?>
