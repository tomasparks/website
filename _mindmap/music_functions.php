#!/usr/bin/env php
<?php

// MusicBrainz
use Guzzle\Http\Client;
use MusicBrainz\HttpAdapters\GuzzleHttpAdapter;
use MusicBrainz\MusicBrainz;

require './vendor/autoload.php';




// music -------------------------------------------------------------------------------
function music_levels($treedb,$gobaldb) {
	$database = yaml_parse_file ( "music.yml" );

	
	foreach ($database['genre'] as $genre) { // start of level 2
		$tmp_lvl2 =array (
			'url' => "/mindmap/".$database['id']."/".$genre['id']."/index.html",
			'name' => $genre['name'],
			'id' => $genre['id'],
			'type'=>'music_genre'
			);
			if (isset($database['background'])) {$tmp_lvl2['background']=array ( 
										'image_url'=>$genre['background']['image_url'],
										'source_url'=>$genre['background']['source_url'] );}
		//echo "blvl2: genre\n".yaml_emit($tmp_lvl2)."\n";
		
		foreach ($genre['artists'] as $artists) { // start of level 3
		//echo yaml_emit($artists);
				$tmp_lvl3 = array (
								'url'=>"/mindmap/".$database['id']."/".$genre['id']."/".$artists['id'].".html",
								'name' => $artists['name'],
								'id' => $artists['id'],
								'type'=>'music_artist'
								);
								if (isset($artists['musicbrainz'])) {
									unset ($artist_musicbrainz_data);
									$artist_musicbrainz_data = getMusicBrainzData("artist",$artists['musicbrainz']);
									if (isset($artist_musicbrainz_data)) {$tmp_lvl3['bio'] = $artist_musicbrainz_data;}
								}
								
								if (isset($artists['photo'])) {$tmp_lvl3['photo']=$artists['photo'];}
								if (isset($artists['background'])) {$tmp_lvl3['background'] =array ( 
										'image_url'=>$artists['background']['image_url'],
										'source_url'=>$artists['background']['source_url'] );}
								//'background'=> array ( 
								//		'image_url'=>"/mindmap/".$database['id']."/".$genre['id']."/".$artists['background']['image_url'],
								//		'source_url'=>$artists['background']['source_url'] );
										
				//$lvl3[] = $tmp_lvl3;
				if (isset($artists['albums'])) {
					foreach ($artists['albums'] as $albums) {
						$tmp_lvl4 = array (
									'url'=>"/mindmap/".$database['id']."/".$genre['id']."/".$artists['id']."/".$albums['id'].".html",
									'name' => $albums['name'],
									'id' => $albums['id'],
									'type'=>'music_albums',
									'musicbrainz'=>$albums['musicbrainz'],
										);
									if (isset($albums['musicbrainz'])) {
										$tmp_lvl4['coverart'] = getCoverArt($albums['musicbrainz']);
										//$tmp_lvl4['coverart'] = "http://www.coverartarchive.org/release/".$albums['musicbrainz']."/front";
										unset ($artist_musicbrainz_data);
										$albums_musicbrainz_data = getMusicBrainzData("albums",$albums['musicbrainz']);
										if (isset($albums_musicbrainz_data)) {$tmp_lvl4['level5'] = $albums_musicbrainz_data;}
										
									}
					$lvl4[] = $tmp_lvl4;
					//	echo "level4: albums: lvl4:\n".yaml_emit($lvl4)."\n";
					//	echo "level4: albums\n tmp_lvl4:".yaml_emit($tmp_lvl4)."\n";
				}
			}
			if (isset($artists['songs'])) {
				foreach ($artists['songs'] as $songs) {
					$tmp_lvl4 = array (
									'name' => $songs['name'],'type'=>'music_songs',
									'id' => $songs['id']
								);
								if (isset($songs['musicbrainz'])) {$tmp_lvl4['musicbrainz'] = $songs['musicbrainz'];}
								if (isset($songs['coverart'])) {$tmp_lvl4['coverart'] = $songs['coverart'];}
				$lvl4[] = $tmp_lvl4;
					//	echo "level4: albums: lvl4:\n".yaml_emit($lvl4)."\n";
					//	echo "level4: albums\n tmp_lvl4:".yaml_emit($tmp_lvl4)."\n";
			}
		}			
			$tmp_lvl3['level4'] =$lvl4;
			unset ($lvl4);
			$lvl3[] = $tmp_lvl3;
			//echo "blevel3: artists: lvl3:\n".yaml_emit($lvl3)."\n";
			//echo "blevel3: artists\n tmp_lvl3:".yaml_emit($tmp_lvl3)."\n";
		} // end of level 3
		
		$tmp_lvl2['level3'] =$lvl3;
		unset ($lvl3);
		$tp_lvl1[] =  $tmp_lvl2;
		//echo "blevel2: genre: tmp_lvl2:\n".yaml_emit($tmp_lvl2)."\n";
		//echo "blevel2: genre\n tp_lvl1:".yaml_emit($tp_lvl1)."\n";
		} // end of level 2


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
function getCoverArt($id) {
	sleep(5);
	$client = new GuzzleHttp\Client();
	try {
    		$res = $client->request('GET', 'http://www.coverartarchive.org/release/'.$id, [
 				'headers' => [
        		'User-Agent' => 'jekyll-mindmap/0.0 tomasparks.ts@gmail.com'
    				]
				]);	
	$statuscode = $res->getStatusCode();
	switch ($statuscode) {
	case '200':
		$tmp['status'] = 'sucessfull';
		// "200"
		echo $res->getHeader('content-type');
		// 'application/json; charset=utf8'
		echo $res->getBody();
	break;
	case '400':
		$tmp['status'] = $id.' cannot be parsed as a valid UUID.';
	break;
	case  '404':
		$tmp['status'] = '404 Not found';
	break;
	case  '405':
		$tmp['status'] = 'request method is not one of GET or HEAD.';
	break;
	case  '406':
		$tmp['status'] = 'the server is unable to generate a response suitable to the Accept header.';
	break;
	case  '503':
		$tmp['status'] = 'the user has exceeded their rate limit';
	break;
	}
		} catch (Exception $e) {
    		$tmp['status'] = $e->getMessage();
    	}
	
	//echo "\n".yaml_emit($tmp)."\n";
	if (!isset($tmp)) {	echo "\n".yaml_emit($tmp)."\n";$tmp['status']='failed';	echo "\n".yaml_emit($tmp)."\n";}
	return $tmp;
}
// -----------------------------------------------------------------------------------------

// -----------------------------------------------------------------------------------------
function getMusicBrainzData($type,$id) {
	sleep(5);
	// Create new MusicBrainz object
	$brainz = new MusicBrainz(new GuzzleHttpAdapter(new Client()));
	$brainz->setUserAgent('jekyll-mindmap', '0.0', 'tomasparks.ts@gmail.com');
	
	switch ($type) {
	case 'artist':
		$includes = array();
		try {
    			$data = $brainz->lookup('artist', $id, $includes);
    			$tmp = array ('gender' => $data['gender'],
    								 'type' => $data['type'],
    								 'country' => $data['country'],
    								 'life-span' => $data['life-span']
    								 );
		} catch (Exception $e) {
    		print $e->getMessage();
    	}
    	break;
    	case 'albums':
    			$includes = array('discids','labels','recordings');
			try {
    			$data = $brainz->lookup('release', $id, $includes);
			} catch (Exception $e) {
    			print $e->getMessage();
    	}
		foreach ($data['media'][0]['tracks'] as $tracks) {
			$arr['number'] = $tracks['number'];
			$arr['title'] = $tracks['title'];
			if (isset($tracks['recording']['length'])) {
			$arr['length'] = gmdate("H:i:s", $tracks['recording']['length']);
			} else {
			$arr['length'] = gmdate("H:i:s", $tracks['length']);
			}
    	//$tmp['level5'] = $data['media'][0]['tracks'];
    	$tmp[] =$arr; 
    	}
    	break;
	}
	//echo "\n".yaml_emit($tmp)."\n";
return $tmp;
}
// -----------------------------------------------------------------------------------------

?>
