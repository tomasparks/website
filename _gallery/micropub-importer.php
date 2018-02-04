#!/usr/bin/env php
<?php

date_default_timezone_set('Australia/Brisbane');
global  $persondbfile;
$persondbfile ="../_data/personDB.yml";
$galleryfolder = "/home/tom/github/blog/website/_gallery/";
chdir($galleryfolder);
/*
//Very simple recoursive solution
$array = array(
    array(
        array('hey.com'),
        array('you.com')
    ),
    array(
        array('this.com'),
        array('rocks.com'),
        array(
            array('its.com'),
            array(
                array('soo.com'),
                array('deep.com')
            )
        )
    )
);
*/

// https://stackoverflow.com/questions/13920659/php-remove-parent-level-array-from-set-of-arrays-and-merge-nodes
function deepValues(array $array) {
    $values = array();
    foreach($array as $level) {
    			//$json = json_encode($level);
				//$level = json_decode($json,TRUE);
        if (is_array($level)) {
        print_r($level);
        	foreach($level as $key=>$val) { 
   				if (is_array($level[$key])) { $level[$key] = $level[$key][0];} 
}
$values =  deepValues($level);
            //$values = array_merge($values,deepValues($level));
        } else {
            $values[] = $level;
        }
    }
    return $values;
}


//function array_reduce(){
//}


//  https://stackoverflow.com/questions/173400/how-to-check-if-php-array-is-associative-or-sequential?rq=1	
function isIndexed($someArray) { $keys=array_keys($someArray); return array_keys($keys)===array_values($keys); }

// =============================================================================================================
function hcard($data) 
{
	echo "entering hcard(\n".yaml_emit($data)."\n)\n";
	$persondbfile ="../_data/personDB.yml";
	$indb = false;

	$out_array['type'] = $data['type'][0];
	#$out_array['properties']['name'] = $data['properties']['name'][0];
	#$out_array['properties']['url'] =$data['properties']['url'][0];

	$out_array['properties']['name'] = str_ireplace(" ",".",ucwords($data['properties']['name']));

	if (file_exists($persondbfile)) {
		$persondb = yaml_parse_file($persondbfile); 
	}
	foreach($persondb as $chcard) {
		echo "\n".yaml_emit($chcard)."\n";

		if ($chcard['id'] == $out_array['properties']['name']) {
			echo $chcard['id']." == ".$out_array['properties']['name']."\n";
			echo "found match :)\n";
			$hcard = $chcard;
			$indb = true;
		}
	}

	if (!isset($hcard)) {
		$hcard['id'] = str_ireplace(" ",".",ucwords($data['properties']['name']));
		$hcard['name'] = $data['properties']['name'];
		$hcard['facebook_id'] ="";
		$hcard['twitter_id'] ="";
		$hcard['url']="";

	}

	$urlhost = strtolower(parse_url($data['properties']['url'],PHP_URL_HOST));

	if (!$urlhost == "facebook.com") {
		//echo $urlhost." NOT = facebook.com\n";
		$hcard['url'] = $data['properties']['url'];
	}

	if (is_array($persondb)) {
		if ($indb) 
			{array_merge($persondb,$hcard);}
		else
			{array_push($persondb,$hcard);}
		}
	else
	 {$persondb[] = $hcard; }
	//$persondb[]=$hcard;

	yaml_emit_file($persondbfile,$persondb);

	if ($indb) {
		$out_array['properties'] = $hcard;

	}

	echo "exiting hcard(\n".yaml_emit($out_array)."\n)\n";
	return $out_array;
}
// =============================================================================================================


// =============================================================================================================
function category($data)
{
	echo "entering category(\n".yaml_emit($data)."\n)\n";

	$out_array['type'] = $data['type'][0];

	if ($data['type'][0] == "h-card") {
		$out_array = hcard($data);
	}

	echo "exiting category(\n".yaml_emit($out_array)."\n)\n";
	return $out_array;
}
// =============================================================================================================


// =============================================================================================================
function post_defualt($data)
{
	echo "entering post_defualt(\n".yaml_emit($data)."\n)\n";
	$out_array['type'] = $data['type'][0];
	#$properties_array['name'] = $data['properties']['name'][0];
	if (is_array($data['properties']['content']))
		{$properties_array['content'] = $data['properties']['content'][0];}
		else
		{$properties_array['content'] = $data['properties']['content'];}
	$properties_array['syndication'] = $data['properties']['syndication'];
	$properties_array['published'] = $data['properties']['published'];
	#$properties_array['photo'] = 

	if (file_exists($data['properties']['photo'][0])) {
		$photo_hash = sha1_file($data['properties']['photo'][0]);
		$properties_array['photo_hash'] = $photo_hash;
		$filetemp = new SplFileInfo($data['properties']['photo'][0]);
		$properties_array['photo'] = "./".$photo_hash.".".$filetemp->getExtension();
		rename($data['properties']['photo'][0], $properties_array['photo']);
	}

	$out_array['properties'] = $properties_array;
	if (isset($data['properties']['category'])) {
		foreach($data['properties']['category'] as $cat) {
			$category[] = category($cat);
		}
		$out_array['properties']['category']  = $category;
	}

	$md_array['layout'] = "photo";
	$md_array['date'] = $properties_array['published'];
	$md_array['syndication'] = $properties_array['syndication'];
	$md_array['photo'] = $properties_array['photo'];
	
	foreach($out_array['properties']['category'] as $cat) {
				if ($cat['type'] == "h-card") {
					$md_array['ptag'][]  = $cat['properties'];
				}
			}
			

	$frontmatter = yaml_emit ($md_array);
	$frontmatter = str_ireplace("...","---",$frontmatter);

	$mdfile = fopen($photo_hash.".md", "w");
	fwrite($mdfile, $frontmatter);
	if (array_key_exists("content",$properties_array)) {
		fwrite($mdfile, $properties_array['content']."\n");
	}
	fclose($mdfile);
				
	echo "exiting post_defualt(\n".yaml_emit($out_array)."\n)\n";
	return $out_array;
}
// =============================================================================================================

// =============================================================================================================
$file = "./multi-photo.json";
$json = file_get_contents($file); 
#print_r($json);
$json_array = json_decode($json,true);
print_r($json_array);
			//$json = json_encode($json_array);
			//$json_array = json_decode($json,TRUE);
//print_r($json_array);
//$values = deepValues($json_array);

$data=$json_array;

//echo yaml_emit($data)."\n";

$out_array['type'] = $data['type'][0];
#$properties_array['name'] = $data['properties']['name'][0];
$properties_array['content'] = $data['properties']['content'];
$properties_array['syndication'] = $data['properties']['syndication'];
$properties_array['published'] = $data['properties']['published'];
$out_array['properties'] = $properties_array;

#$children = $data['properties']['children'];
if (isset($data['properties']['children'])) {
	foreach($data['properties']['children'] as $child) {
		$children[] = post_defualt($child);
	}
//$children_array
$out_array['properties']['children']  = $children;
}
	$date_split = date_parse($properties_array['published']);

	$md_array['layout'] = "photo-album";
	$md_array['date'] = $properties_array['published'];
	$md_array['syndication'] = $properties_array['syndication'];
	
	if (isset($out_array['properties']['children'])) {
			//echo yaml_emit($out_array['properties']['children'])."\n";
		foreach($out_array['properties']['children'] as $child) {
		echo "child loop\n";
			echo yaml_emit($child)."\n";
			$ptag_array="";
			$photo_array['filename'] = $child['properties']['photo'];
			$photo_array['content'] = $child['properties']['content'];
			$photo_array['link'] = $child['properties']['photo_hash'].".html";
			
			foreach($child['properties']['category'] as $cat) {
					echo "cat loop\n";
			echo yaml_emit($cat)."\n";
				if ($cat['type'] == "h-card") {
					$ptag_array[]  = $cat['properties'];
				}
				echo "cat loop\n";
		}
	//$children_array
	$photo_array['ptag'] = $ptag_array;
	$md_array['photos'][]  = $photo_array;
	}
					echo "child loop\n";
	}
	#$md_array['photo'] = $properties_array['photo'];

	$frontmatter = yaml_emit ($md_array);
	$frontmatter = str_ireplace("...","---",$frontmatter);
	$mdfile = fopen("album-".$date_split['year']."-".$date_split['month']."-".$date_split['day'].".md", "w");
	fwrite($mdfile, $frontmatter);
	if (array_key_exists("content",$properties_array)) {
		fwrite($mdfile, $properties_array['content']."\n");
	}
	fclose($mdfile);

echo "completed with:\n";
echo yaml_emit($out_array)."\n";
echo "Ended\n"			
			
?>
