<?php
// -----------------------------------------------------------------------------------------
function array2tree($treedb,$gobaldb,$rootpath) {
echo "Entering Array2tree().......\n";
//				echo "\ntreedb\n".yaml_emit($treedb)."\n";
//	chdir($rootpath);
	
		if (isset($treedb['level1'])) {
			$breadcrumbs[] = array ('title'=>'website', 'url'=>'/');
			$breadcrumbs[] = array ('title'=>'mindmap','url'=>'/mindmap/');
			$arr = array2tree_lvl1($treedb['level1'],$breadcrumbs);
//			echo "\narr:\n".yaml_emit($arr)."\n";
			$filename ="index.md";
			$frontmatter = array('title'=> $treedb['name'],
								'permalink' => "/mindmap/index.html",
								'layout' => 'mindmap_index',
								'links'=>$arr['links'],
								'breadcrumbs'=>$breadcrumbs,
								'function'=>'array2tree'
								);
																if (isset($value['background'])) {
									if (isset($value['background']['image_url'])) {
												$mediatmp = media($value['background']['image_url'],$value['id'],$value['url'],'background');
												$ret['media'][] = $mediatmp;
												$frontmatter['background']['image_url']=$mediatmp['url'];
												$frontmatter['background']['source_url']=$value['background']['source_url'];
										}
								}	
			$contents ="";
			makepage($frontmatter,$filename,$contents);
		}
		
		echo "leaving Array2tree().......\n";
	return $treedb;
}
// -----------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------
function array2tree_lvl1($treedb,$breadcrumbs) {
echo "Entering array2tree_lvl1().......\n";
								
					
						//$filename =$treedb['id'].".md";
							
				foreach ($treedb as $value) {
				echo "\n-----------------------------------------------------------------------------------------\nlvl1: Name: ".$value['name']."\n-----------------------------------------------------------------------------------------\n";
						
					//echo "".yaml_emit($value)."";
					$bread = $breadcrumbs;
					$bread[] = array ('title'=>$value['name'],'url'=>$value['url']);

					
					if (isset($value['copyright_notices'])) {
						copy_notices($value['copyright_notices'],$value['url'],$value['id']);
					}
					if (isset($value['level2'])) {

								$arr = array2tree_lvl2($value['level2'],$bread);
								//echo "\narr\n".yaml_emit($arr)."\n";
								}			
					$tmp[] = array ('title'=>$value['name'],'id'=>$value['id'], 'url'=>$value['url']);
					//echo "\ntmp\n".yaml_emit($tmp)."\n";
					
								$filename =$value['id'].".md";
			
			$frontmatter = array('title'=> $value['name'],
								'permalink' => $value['url'],
								'layout' => 'mindmap_index','function'=>'array2tree_lvl1',
								'links'=>$arr['links'],
								'breadcrumbs'=>$breadcrumbs
								);
																if (isset($value['background'])) {
									if (isset($value['background']['image_url'])) {
												$mediatmp = media($value['background']['image_url'],$value['id'],$value['url'],'background');
												$frontmatter['background']['image_url']=$mediatmp['url'];
												$frontmatter['background']['source_url']=$value['background']['source_url'];
										}
								}	
			$contents ="";
			makepage($frontmatter,$filename,$contents);
							echo "\n-----------------------------------------------------------------------------------------\nlvl1: End of Name: ".$value['name']."\n-----------------------------------------------------------------------------------------\n";

				}
				
	//			echo "\narr\n".yaml_emit($arr)."\n";
				
			//$filename =$treedb['id'].".md";
			
			//$frontmatter = array('title'=> $treedb['name'],
				//				'permalink' => $treedb['url'],
				//				'layout' => 'mindmap_index',
				//				//'links'=>$arr['links'],
				//				'breadcrumbs'=>$bread
//								);
			//$contents ="";
			//makepage($frontmatter,$filename,$contents);
	
	$ret['links'] = $tmp;
		echo "leaving Array2tree_lvl1().......\n";
	return $ret;
}
// -----------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------
function array2tree_lvl2($treedb,$breadcrumbs) {
echo "Entering array2tree_lvl2().......\n";
				
			
				
				foreach ($treedb as $value) {
				echo "\n-----------------------------------------------------------------------------------------\nlvl2: Name: ".$value['name']."\n-----------------------------------------------------------------------------------------\n";
						
						$bread = $breadcrumbs;
						$bread[] = array ('title'=>$value['name'],'url'=>$value['url']);
					if (isset($value['level3'])) {

								$arr = array2tree_lvl3($value['level3'],$bread);
						//echo "\narr\n".yaml_emit($arr)."\n";
								}		
					$tmp[] = array ('title'=>$value['name'],'id'=>$value['id'], 'url'=>$value['url']);
								//$filename = $treedb['id'].".md";
			
								$filename =$value['id'].".md";
			
			$frontmatter = array('title'=> $value['name'],
								'permalink' => $value['url'],
								'layout' => 'mindmap_index','function'=>'array2tree_lvl2',
								'links'=>$arr['links'],
								'breadcrumbs'=>$breadcrumbs
								);
																if (isset($value['background'])) {
									if (isset($value['background']['image_url'])) {
												$mediatmp = media($value['background']['image_url'],$value['id'],$value['url'],'background');
												$frontmatter['background']['image_url']=$mediatmp['url'];
												$frontmatter['background']['source_url']=$value['background']['source_url'];
										}
								}	
			$contents ="";
			makepage($frontmatter,$filename,$contents);
	
				echo "\n-----------------------------------------------------------------------------------------\nlvl2: End of Name: ".$value['name']."\n-----------------------------------------------------------------------------------------\n";
					
				}
				
				//echo "\ntmp\n".yaml_emit($tmp)."\n";
			//$filename = $treedb['id'].".md";
			
			/*$frontmatter = array('title'=> $treedb['name'],
								'permalink' => $treedb['url'],
								'layout' => 'mindmap_index',
								//'links'=>$arr['links'],
								'breadcrumbs'=>$bread
								);*/
			//$contents ="";
			//makepage($frontmatter,$treedb['id'].".md",$contents);
	
	$ret['links'] = $tmp;
		echo "leaving Array2tree_lvl2().......\n";
	return $ret;
}
// -----------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------
function array2tree_lvl3($treedb,$breadcrumbs) {
echo "Entering array2tree_lvl3().......\n";
				
				foreach ($treedb as $value) {
						echo "\n-----------------------------------------------------------------------------------------\nlvl3: start of Name: ".$value['name']."\n-----------------------------------------------------------------------------------------\n";
						$bread = $breadcrumbs;
						$bread[] = array ('title'=>$value['name'],'url'=>$value['url']);
					/*if (isset($value['level3'])) {

								$arr = array2tree_lvl3($value['level3'],$breadcrumbs);
						//echo "\narr\n".yaml_emit($arr)."\n";
								}
								*/
					//$media[] = $arr['media'];			
								$tmp[] = array ('title'=>$value['name'],'id'=>$value['id'], 'url'=>$value['url']);
								//$filename = $treedb['id'].".md";
			
								$filename =$value['id'].".md";
								$frontmatter = array('title'=> $value['name'],
								'permalink' => $value['url'],
								'layout' => 'mindmap_page_'.$value['type'],'function'=>'array2tree_lvl3',
								'breadcrumbs'=>$breadcrumbs
								);		
								
								if (isset($value['background'])) {
									if (isset($value['background']['image_url'])) {
												$mediatmp = media($value['background']['image_url'],$value['id'],$value['url'],'background');
												$media[] = $mediatmp;
												$frontmatter['background']['image_url']=$mediatmp['url'];
												$frontmatter['background']['source_url']=$value['background']['source_url'];
										}
								}	
											
								if (isset($value['type'])) {
									switch ($value['type']) {
										case "music_artist":
											$frontmatter['type']="Artist";
											$frontmatter['artist']['bio'] = $value['bio'];
											if (isset($value['photo'])) {
												$mediatmp = media($value['photo'],$value['id'],$value['url'],'photo');
												$frontmatter['artist']['photo'] = $mediatmp['url'];
												}
											break;
										case "TV_Series":
											$frontmatter['type']= "TV_Series";
										break;
									}
								}	
			$contents ="";
			makepage($frontmatter,$filename,$contents);

				echo "\n-----------------------------------------------------------------------------------------\nlvl3: End of Name: ".$value['name']."\n-----------------------------------------------------------------------------------------\n";
							
				}
				
	//			echo "\ntmp\n".yaml_emit($tmp)."\n";
			//$filename = $treedb['id'].".md";
			
			/*$frontmatter = array('title'=> $treedb['name'],
								'permalink' => $treedb['url'],
								'layout' => 'mindmap_index',
								//'links'=>$arr['links'],
								'breadcrumbs'=>$bread
								);*/
			//$contents ="";
			//makepage($frontmatter,$treedb['id'].".md",$contents);
	
	$ret['links'] = $tmp;
	//$ret['media'][] = $media;
	//$ret['media'] = $arr['media'];
		echo "leaving Array2tree_lvl3().......\n";
	return $ret;
}
// -----------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------
function media($image,$id,$url,$type) {
	echo "entering media().......\n";
	
	$filename = pathinfo($image);
	$extension= $filename['extension'];
	
	if (null !==(parse_url($image, PHP_URL_SCHEME))) {
		$ret['remote_url'] = $image;
	} else {$ret['basefilename'] = $image; }	
	
	$ret['newfilename'] = $id.'-'.$type.'.'.$extension;
	//$ret['url'] = str_ireplace ( 'index.html' , '' , $url );
	//$ret['url'] = str_ireplace ( ''.$id.'.html' , '' , $ret['url'] );
	//$ret['url'] = $ret['url'].$ret['newfilename'];
	$ret['url'] = $ret['newfilename'];
	
   echo "making dirs\n";
   	
   if (isset($ret['remote_url'])) { 
   		echo "Downloading from ".$ret['remote_url']." to ".$ret['url']."\n";
   		passthru("wget --continue '".$ret['remote_url']."' -O '".$ret['url']."'");
	}
	
	
   	echo "Copying from ".$image." to ".$ret['url']."\n";


   
	echo "leaving media().......\n";
	return $ret;
}
// -----------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------
function copy_notices($notices,$url,$id) {
			$filename = $id."-copy.md";
			
			$frontmatter = array('title'=> "copyright notices",
								'permalink' => str_replace("index","copyright",$url),
								'layout' => 'mindmap_copy'
								);
								
		echo "\nnotices\n".yaml_emit($notices)."\n";
			$contents = "\n## Text ##\n";
			$contents .= "\n## Images ##\n";

			makepage($frontmatter,$filename,$contents);
}
// -----------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------
function makepage($frontmatter,$filename,$contents) {
echo "entering makepage(";
//echo yaml_emit($frontmatter);
//echo "filename:".$filename."\n";
//echo "contents:".$contents."\n";
echo ")...\n";
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

?>
