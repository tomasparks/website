#!/usr/bin/env php
<?php

$treedb = array ("id"=>"Me","name"=>"Tom Sparks");
$gobaldb = array ("id"=>"Me","name"=>"Tom Sparks");

//print_r($database);

$path = getcwd();

//$notes_path = str_replace("_rake","_notes",$path);

chdir($path);


$filelist = scandir($path);
foreach ($filelist as $file) {
	if ($file === "." or $file === "..") {continue;}
		switch(true) {
			case strstr($file, "log"):
    			echo $file." skipping log file\n";
    			continue 2;
			case strstr($file, "md"):
    			echo $file." skipping md file\n";
    			continue 2;
    		case strstr($file, "temp"):
    			echo $file." skipping md file\n";
    			continue 2;
    					
			case strstr($file, "tv_movies.yml"):
    			echo "found tv_movies.yml :)\n";
    			$arr = tv_movies_levels($treedb,$gobaldb);
				$treedb = $arr['treedb'];
				$gobaldb = $arr['gobaldb'];
    			break;						
					}
	}

// tv_movies -------------------------------------------------------------------------------
function tv_movies_levels($treedb,$gobaldb) {
	$database = yaml_parse_file ( "tv_movies.yml" );

	
	foreach ($database['genre'] as $genre) {
		$tmp_lvl2['url'] = "./".$database['id']."/".$genre['id']."/";
		$tmp_lvl2['name'] = $genre['name'];
		$tmp_lvl2['id'] = $genre['id'];
		foreach ($genre['shows'] as $shows) {
				$tmp_lvl3['url']="./".$database['id']."/".$genre['id']."/".$shows['id'].'.html';
				$tmp_lvl3['name'] = $shows['name'];
				$tmp_lvl3['id'] = $shows['id'];
				$arr[] = $tmp_lvl3;
				}
	
		$tmp_lvl2['level3'] =$arr;
		unset ($arr);
		$tp_lvl1[] =  $tmp_lvl2; 
		}


	$tmp_lvl1 = array ("name"=>$database['name'],"id"=>$database['id'],"url"=>"./".$database['id']."/", "level2" => $tp_lvl1  );
	
	$treedb['level1'][] = $tmp_lvl1;
	$gobaldb['level1'][] = $database;
	
	$ret = ["treedb"=>$treedb,"gobaldb"=>$gobaldb];
	return $ret;
}
// -----------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------
function array2tree($treedb,$gobaldb,$rootpath) {

	chdir($rootpath);
	$frontmatter = array (
		'title'=>'Mindmap',
		'categories'=>'top',
		'parent'=>'null',
		'layout'=>'mindmap_index',
		'pagination'=> array(
							'collection'=>'mindmap',
							'category'=>'top',
							'enabled'=>'true',
							'extension'=>'html',
							'indexpage'=>'index')
						 );
	$contents = "";
	$filename = $rootpath."/index.md";
	$result = makepage($frontmatter,$filename,$contents);
	$treedb['result'] = $result;


	foreach ($treedb['level1'] as $value) {
	echo "level 1 loop\n";//$parent = $pparent;	
		echo yaml_emit($value);
			$frontmatter = array (
		'title'=>$value['name'],
		'permalink'=>$value['url'],
		'categories'=> 'top',
		'parent'=>'top',
		'layout'=>'mindmap_index',
		'pagination'=> array(
							'collection'=>'mindmap',
							'category'=>$value['id'],
							'enabled'=>'true',
							'extension'=>'html',
							'indexpage'=>'index')
						 );
		$filename =$rootpath."/".$value['id'].".md";
		$contents ="";
		$result = makepage($frontmatter,$filename,$contents);
		$pparent = $value['id'];
		foreach ($value['level2'] as $value) {
			$parent = $pparent;
			echo "level 2 loop\n";
			echo yaml_emit($value);
			$frontmatter = array (
		'title'=>$value['name'],
		'permalink'=>$value['url'],
		'categories'=>$parent,
		'parent'=>$parent,
		'layout'=>'mindmap_page',
				'pagination'=> array(
							'collection'=>'mindmap',
							'category'=>$value['id'],
							'enabled'=>'true',
							'extension'=>'html',
							'indexpage'=>'index')
						 );
			$filename =$rootpath."/".$value['id'].".md";
			$contents ="";
			$result = makepage($frontmatter,$filename,$contents);
					$parent = $value['id'];
			foreach ($value['level3'] as $value) {
				echo "level 3 loop\n";
				echo yaml_emit($value);
$frontmatter = array (
		'title'=>$value['name'],
		'permalink'=>$value['url'],
		'categories'=>$parent,
		'parent'=>$parent,
		'layout'=>'mindmap_page');
				$filename =$rootpath."/".$value['id'].".md";
				$contents ="";
				$result = makepage($frontmatter,$filename,$contents);

			}
		}
	}





	return $treedb;
}
// -----------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------
function makepage($frontmatter,$filename,$contents) {
echo "entering makepage(\n";
echo yaml_emit($frontmatter);
echo "filename:".$filename."\n";
echo "contents:".$contents."\n";
echo "\n)...\n";
				$frontmatter = yaml_emit ($frontmatter);
				$frontmatter = str_ireplace("...","---",$frontmatter);
				$mdfile = fopen($filename, "w");
				fwrite($mdfile, $frontmatter);
				fwrite($mdfile, $contents);
				fclose($mdfile);
				echo "leaving makepage()\n";
	return 0;
}
// -----------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------
$path = getcwd();
echo $path."\n";
$arr = tv_movies_levels($treedb,$gobaldb);
$treedb = $arr['treedb'];
$gobaldb = $arr['gobaldb'];

$treedb = array2tree($treedb,$gobaldb,$path);
//print_r($treedb);
//echo yaml_emit($treedb);
//echo yaml_emit($gobaldb);
?>
