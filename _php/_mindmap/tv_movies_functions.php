#!/usr/bin/env php
<?php

use Moinax\TvDb\Http\Cache\FilesystemCache;
use Moinax\TvDb\Http\CacheClient;
use Moinax\TvDb\Client;

// tv_movies -------------------------------------------------------------------------------
function tv_movies_levels($treedb,$gobaldb) {
	$database = yaml_parse_file ( "tv_movies.yml" );

	
	foreach ($database['genre'] as $genre) {
		$tmp_lvl2['url'] = "/mindmap/".$database['id']."/".$genre['id']."/index.html";
		$tmp_lvl2['name'] = $genre['name'];
		$tmp_lvl2['id'] = $genre['id'];
		foreach ($genre['shows'] as $shows) {
				$tmp_lvl3['url']="/mindmap/".$database['id']."/".$genre['id']."/".$shows['id'].'.html';
				$tmp_lvl3['name'] = $shows['name'];
				$tmp_lvl3['id'] = $shows['id'];
				$tmp_lvl3['background']['image_url'] = $shows['fanart'];
				$tmp_lvl3['logo'] = $shows['logo'];
				unset($data);
				if (isset($shows['tvdb'])) {
							$tmp_lvl3['type'] = 'TV_Series';
							$data = gettvdbdata($shows['tvdb']);
							$tmp_lvl3['name'] = $data['name'];
							$tmp_lvl3['overview'] = $data['overview'];
							}
				$arr[] = $tmp_lvl3;
				}
	
		$tmp_lvl2['level3'] =$arr;
		unset ($arr);
		$tp_lvl1[] =  $tmp_lvl2; 
		}


	$tmp_lvl1 = array (
		"name"=>$database['name'],
		"id"=>$database['id'],
		"url"=>"/mindmap/".$database['id']."/index.html",
		'background' =>array (	'image_url'=>$database['background']['image_url'],
								'source_url'=>$database['background']['source_url'] ),
		'copyright_notices'=>$database['copyright_notices'],
		"level2" => $tp_lvl1  );
	$treedb['level1'][] = $tmp_lvl1;
	$gobaldb['level1'][] = $database;
	$ret = ["treedb"=>$treedb,"gobaldb"=>$gobaldb];
	return $ret;
}
// -----------------------------------------------------------------------------------------

// -----------------------------------------------------------------------------------------
function gettvdbdata($id) {

sleep(5);

$ttl = 600; # how long things should get cached, in seconds.
$apiKey = '05AEE48189998BF6';

$cache = new FilesystemCache('./cache');
$httpClient = new CacheClient($cache, $ttl);

$tvdb = new Client("http://thetvdb.com", $apiKey);
$tvdb->setHttpClient($httpClient);

$serverTime = $tvdb->getServerTime();
$data = $tvdb->getSerie($id); //This request will fetch the resource online.

		$ret['overview'] = $data->overview;
		$ret['name'] = $data->name;
		//	echo "\n";
	//var_dump($ret);
	//echo "\n";
	
	return $ret;
}
// -----------------------------------------------------------------------------------------
?>
