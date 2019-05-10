#!/usr/bin/env php
<?php
// curl -i -d "source=$your_url&target=$target_url" $targets_webmention_endpoint



for ($i=1 to 90 ) {
}


$xml = new SimpleXMLElement('<!DOCTYPE html><html lang="en"></html>');
$htmlhead = $xml->addChild('head');
$meta = $htmlhead ->addChild('meta');
$meta->addAttribute('charset', 'utf-8');
$htmlbody = $xml->addChild('body');
$article = $htmlbody->addChild('article');

$name = $article->addChild('h1');
    $name->addAttribute('class', 'p-name');
        $url = $name->addChild('a','h-feed');
        $url->addAttribute('class', 'u-uid u-url');
        $url->addAttribute('href', 'https://');
        $author =  $article->addChild('div','author');
                    $author->addAttribute('class', 'p-author');   


$article->addAttribute('class', 'h-feed');



// loop start
foreach ($database as $value) {
$entry = $article->addChild('div');
    $entry->addAttribute('class', 'h-entry');
        $name = $entry->addChild('h1');
            $name->addAttribute('class', 'p-name');
                    $url = $name->addChild('a',$value['published']);
                        $url->addAttribute('class', 'u-uid u-url');
                        $url->addAttribute('href', 'https://');
                        
                        
        $contents =  $entry->addChild('div',$value['content']['text']);
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
        $contents =  $entry->addChild('div',$value['content']['text']);
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
                                              
                   
       $htmlol = $entry->addChild('ol');
            foreach ($value['category'] as $cat ) {
                $cat = $htmlol->addChild('div',$cat);
                $cat->addAttribute('class', 'p-category');
            } 
                    
        $author =  $entry->addChild('div','author');
                    $author->addAttribute('class', 'p-author');                    
         $published =  $entry->addChild('div',$value['published']);
                    $published->addAttribute('class', 'dt-published');    
                    $published->addAttribute('datetime', $value['published']);  
                    $published->addAttribute('title', $value['published']);                                      

}
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

$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($xml->asXML());
print($dom->saveXML());

?>
