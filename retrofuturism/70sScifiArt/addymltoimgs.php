#!/usr/bin/env php
<?php


$filelist = array_diff(scandir("."), array('..', '.'));
print_r($filelist);


$tags = array("inspiration","unsorted","retrofuturism","70sScifiArt");
$arr =array();
$arr['tags'] = $tags;
$arr['year'] =0000;
$arr['arist'] ="unknown";
$arr['country'] ="unknown";
$arr['title'] ="unknown";

	foreach ($filelist as $value) {
	echo $value;
	
	    if (is_dir($value)) {continue;} else {}
	    
	    $filename = pathinfo($value);
	    if ($filename['extension']=="yml")  {continue;} else {}
	    if ($filename['extension']=="php")  {continue;} else {}
	   print_r($filename);
	   
	   yaml_emit_file ($filename['filename'].".yml" , $arr); 
	}


//tags:
//    - inspiration
//   - unsorted
//   - retro
//   - 70sScifiArt
   
?>
