#!/usr/bin/env php
<?php
// curl -i -d "source=$your_url&target=$target_url" $targets_webmention_endpoint


function content($value) {
//------------------------------------

if (isset($value['content'])) {
    //echo "found contents\n";
    if (is_array($value['content'])) {
        //echo "contents is an array \n";
        if (isset($value['content']['text']))
            {//echo "found contents.text\n";
            $contents =$value['content']['text'];}
            else {$contents =  $value['content']['value'];}   
        } else {$contents =  $value['content'];}
}
//----------------------------------------------------------
elseif (isset($value['summary'])) {
    //echo "found summary\n";
    if (is_array($value['summary'])) {
        //echo "summary is an array \n";
        if (isset($value['summary']['text']))
            {//echo "found summary.text\n";
            $contents =$value['summary']['text'];}
            else {$contents =  $value['summary']['value'];}   
        } else {$contents =  $value['summary'];}
}
//----------------------------------------       
else  {$contents =  $value['value'];}
return $contents;
}

$jf2File = array ("main",
"miniatures",
"gallery",
"notes");

$database = array ();

foreach ($jf2File as $value) {
chdir("/home/tom/github/website/sources/gobal/_data/feeds/");
if (file_exists("/home/tom/github/website/sources/gobal/_data/feeds/".$value.".jf2")) {
$json =file_get_contents("/home/tom/github/website/sources/gobal/_data/feeds/".$value.".jf2");
//print_r ($json);
$newdata = json_decode($json, true);

//echo is_array($newdata);
////echo is_array($newdata[0]);


//print_r($newdata['children']);
$database = array_merge($database,$newdata['children']);
$database = array_unique(array_merge($database,$newdata['children']), SORT_REGULAR);
}}


usort($database, function ($item1, $item2) {return $item2['published'] <=> $item1['published'];});

//print_r ($database);
$xml = new SimpleXMLElement('<!DOCTYPE html><html lang="en"></html>');
$htmlhead = $xml->addChild('head');
$meta = $htmlhead ->addChild('meta');
$meta->addAttribute('charset', 'utf-8');
$webmention= $htmlhead->addChild('link');
$webmention->addAttribute('rel', 'webmention');
$webmention->addAttribute('href', 'https://webmention.io/tomasparks.name/webmention');
$pingback= $htmlhead->addChild('link');
$pingback->addAttribute('rel', 'pingback');
$pingback->addAttribute('href', 'https://webmention.io/tomasparks.name/xmlrpc');



$htmlbody = $xml->addChild('body');
$article = $htmlbody->addChild('article');

$name = $article->addChild('h1');
    $name->addAttribute('class', 'p-name');
        $url = $name->addChild('a','h-feed');
        $url->addAttribute('class', 'u-uid u-url');
        $url->addAttribute('href', 'https://tomaparks.name/gobal-fee.html');
        $author =  $article->addChild('div','Tom sparks');
                    $author->addAttribute('class', 'p-author');   


$article->addAttribute('class', 'h-feed');



// loop start
foreach ($database as $value) {
//print_r($value);
if (isset($value['published'])) {


$entry = $article->addChild('div');
    $entry->addAttribute('class', 'h-entry');
        $name = $entry->addChild('h1');
        if (isset($value['name'])) {
            $name->addAttribute('class', 'p-name');
                    $url = $name->addChild('a',$value['name']);
                        $url->addAttribute('class', 'u-uid u-url');
                        $url->addAttribute('href', $value['url']);
} else {$txt = content($value);$url = $name->addChild('a',$txt);
                        $url->addAttribute('class', 'u-uid u-url');
                        $url->addAttribute('href', $value['url']);}

                    $txt = content($value);
                    $contents = $entry->addChild('div',$txt);                           
                    $contents->addAttribute('class', 'e-content');

if (isset($value['listen-of'])) {
                            $listen =   $contents->addChild('div');   
                            $listen->addAttribute('class', 'listen-of');
                            
                            $cite = $listen->addChild('cite');                                            
                            $cite->addAttribute('class', 'h-cite'); 
                            $url = $cite->addChild('a',
                            $value['listen-of']['h-cite']['name'].' by '.$value['listen-of']['h-cite']['author'].''
                            );
                            $url->addAttribute('class', 'u-url');
                            $url->addAttribute('href', $value['listen-of']['h-cite']['url']);
                           $citecontents = $cite->addChild('div',$value['listen-of']['h-cite']['content']);
                           $citecontents->addAttribute('class', 'e-content');
                           $audio = $cite->addChild('audio');
                                                      $audio->addAttribute('class', 'u-audio');
                                                      $audio->addAttribute('controls', 'controls');
                                                      $audio->addAttribute('preload',"metadata");
                           foreach ($value['listen-of']['h-cite']['audio'] as $src ) {
                           $source = $audio->addChild('source');
                           $source->addAttribute('src', $src);
                             
                             }
                             }

                    
                    // bridgy silo link
                    if (isset($value['content']['bridgy-twitter-content'])){
                    $contents = $entry->addChild('div','(🤖) '.$value['content']['bridgy-twitter-content'].' (🤖)');}
                    else {$txt = content($value);$contents = $entry->addChild('div','(🤖) '.$txt.' (🤖)');}
                                       
                   
                    $contents->addAttribute('class', 'p-bridgy-twitter-content');
                    $contents->addAttribute('style', 'display: none;');
                    if (isset($value['listen-of'])) { 
                            $cite = $contents->addChild('cite');                                            
                            $cite->addAttribute('class', 'h-cite'); 
                            
                            $url = $cite->addChild('a',$value['listen-of']['h-cite']['name'].' by '.$value['listen-of']['h-cite']['author'].'');
                            $url->addAttribute('class', 'u-url');
                            $url->addAttribute('href', $value['listen-of']['h-cite']['url']);
                            
                           $citecontents = $cite->addChild('div',$value['listen-of']['h-cite']['content']);
                           $citecontents->addAttribute('class', 'e-content');
                           }
                           
       $htmlul = $entry->addChild('ul');                                              
         if (isset($value['category'])) {         
            foreach ($value['category'] as $cat ) {
                if (!is_array($cat)) {
                $cat = $htmlcatul->addChild('li',$cat);
                $cat->addAttribute('class', 'p-category');
                }
            }}
            
            if (isset($value['tags'])) {
            foreach ($value['tags'] as $tag ) {
                if (!is_array($tag)) {
                $tag = $htmlul->addChild('li',$tag);
                $tag->addAttribute('class', 'p-category');
                }
            }}  
           
           if (isset($value['syndication'])) {
            foreach ($value['syndication'] as $synd ) {
                if (!is_array($synd)) {
                $syn = $htmlul->addChild('li',$synd);
                $syn->addAttribute('class', 'u-syndication');
                }
            }}           
             
                    
        $author =  $entry->addChild('div','Tom sparks');
                    $author->addAttribute('class', 'p-author');                    
         $published =  $entry->addChild('div',$value['published']);
                    $published->addAttribute('class', 'dt-published');    
                    $published->addAttribute('datetime', $value['published']);  
                    $published->addAttribute('title', $value['published']);                                   

}}

// loop end

$url = $article->addChild('a');
$url->addAttribute('style', 'display: none;');
$url->addAttribute('href', 'https://brid.gy/publish/twitter');
$url = $article->addChild('a');
$url->addAttribute('style', 'display: none;');
$url->addAttribute('href', 'https://brid.gy/publish/flickr');
$url = $article->addChild('a');
$url->addAttribute('style', 'display: none;');
$url->addAttribute('href', 'https://brid.gy/publish/github');






chdir("/home/tom/github/website/s3/tomasparks.name/");
	                        $json_data = json_encode($database,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                            file_put_contents("/home/tom/github/website/s3/tomasparks.name/gobal-feed.jf2", $json_data);
$xml->asXML("gobal-feed.html");
$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($xml->asXML());
////print($dom->saveXML());
?>
