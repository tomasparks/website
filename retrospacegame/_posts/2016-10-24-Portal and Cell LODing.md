---
title: Portal and Cell LODing
categories: minecraft
date: 2016-10-24 
status: active
---
while research on Indoor LODing (Level of Detail), Portal and Cell LODing is the best option.

{% reference Luebke1995 --file 3D_graphics %}

My rendering engine [X3Dom](http://www.x3dom.org/) dose not have portal/cell LODing, but it can be add as seen in the articles bellow 

* <http://www.bitmanagement.com/developer/contact/examples/cell_portal/celllportal.html>
* {% reference Mulloni2007 --file 3D_graphics %}
* {% reference Marvie2004 --file 3D_graphics %}

I contact the authors to see if I could have the source code, I got no respose :(

I also contact the X3D communtiy
~~~~~~~
TO: X3D Graphics public mailing list <x3d-public@web3d.org>
Date: 12/10/2016 08:54
Subject: portal and cell graph LODing for X3D

Why has portal and cell graph LODing never become a feature of X3D?

* http://www.bitmanagement.com/developer/contact/examples/cell_portal/celllportal.html
* Interactive Walkthrough of Large 3D Models of Buildings on Mobile Devices
Alessandro Mulloni, Daniele Nadalutti, Luca Chittaro 2005?
* A Vrml97-X3D Extension for Massive Scenery Management in Virtual Worlds
Jean-Eudes Marvie, Kadi Bouatouch 2004
~~~~~~~

## portal/cell generation ##

* {% reference Lefebvre2003 --file 3D_graphics %}

I contact the author, but the reply was disaponiting 

~~~~~~~
Dated: 24/10/16 19:17
thanks, I was hoping not to Reinventing the wheel again :(

On 24/10/16 18:27, Sylvain Lefebvre wrote:
> Dear Tom,
>
> Thanks for your interest in our work. Unfortunately this code source is not easily available (main issue being that I have currently no idea where it is archived). I'll try to have a look, but the chances are slim I'll be able to retrieve something usable.
>
> Best,
> Sylvain
>>
>>     De: "tom sparks" <tom_a_sparks@yahoo.com.au>
>>     À: "Sylvain Lefebvre" <Sylvain.Lefebvre@inria.fr>
>>     Envoyé: Samedi 22 Octobre 2016 10:11:15
>>     Objet: Fwd: Automatic cell-and-portal decomposition source code
>>     -------- Forwarded Message --------
>>     Subject: 	Automatic cell-and-portal decomposition source code
>>     Date: 	Sat, 22 Oct 2016 18:07:52 +1000
>>     From: 	tom sparks <tom_a_sparks@yahoo.com.au>
>>     To: 	Sylvain.Lefebvre@imag.fr, Samuel.Hornus@imag.fr
>>
>>
>>     I am looking for the source code to "Automatic cell-and-portal 
>>     decomposition" 2003 for a project
>>
~~~~~~~


* {% reference Lerner2003 --file 3D_graphics %}


I conatcted the author and I got no respose :(

* so I looked at trying to rewrite the code,
* I need some test data in SVG,
* I found [Jason Sperske](http://jason.sperske.com/) who had converted DOOM's [WADs into SVG](http://jason.sperske.com/wad/)
* the article use a [right-hand wall following rule](https://en.wikipedia.org/wiki/Maze_solving_algorithm#Wall_follower)
* I read the X1, Y1 and X2, Y2 from the first line in the SVG file 
* I was unable to find the connecting line

I may relook at this topic in the future

~~~~~~~
#!/usr/bin/env php
<?php

$xml=simplexml_load_file("./E1M1-outline-path.svg") or die("Error: Cannot create object");
           $writer = new XMLWriter();
$writer->openuri("php://output");
           $writer->startDocument('1.0','UTF-8');   
$writer->startDTD('<!DOCTYPE X3D PUBLIC "ISO//Web3D//DTD X3D 3.3//EN" "http://www.web3d.org/specifications/x3d-3.3.dtd">'); 
$writer->endDTD(); 
           $writer->setIndent(4);   
           $writer->startElement('X3D'); 
           $writer->writeAttribute ('profile', 'Immersive');
           $writer->writeAttribute ('version', '3.3'); 
           $writer->writeAttribute ('xmlns:xsd', 'http://www.w3.org/2001/XMLSchema-instance'); 
           $writer->writeAttribute ('xsd:noNamespaceSchemaLocation', 'http://www.web3d.org/specifications/x3d-3.3.xsd'); 
           $writer->startElement("head");$writer->endElement();
           $writer->startElement("Scene"); 
           $writer->startElement("Transform");
 $writer->writeAttribute ('scale','500 500 500');
    $writer->endElement();
           $writer->startElement("Inline");
 $writer->writeAttribute ('DEF','CoordinateAxes');
 $writer->writeAttribute ('url','./CoordinateAxes.x3d');
    $writer->endElement();
           $writer->startElement("Shape");
           $writer->startElement("Appearance");
           $writer->startElement("Material");
 $writer->writeAttribute ('diffuseColor','0 1 0');
    $writer->endElement();
    $writer->endElement();
           $writer->startElement("Extrusion");
 $writer->startAttribute('crossSection'); 



//$endpos=array('x'=>"1797",'y'=>"1189");
//$startpos=array('x'=>"1861",'y'=>"1189");
//$curpos=array('x'=>$startpos['x'],'y'=>$startpos['y']);

//$skip=array("metadata980","defs4","line6");
//$writer->text($endpos['x']." -".$endpos['y']." ");
//$writer->text($startpos['x']." -".$startpos['y']);
//do {
//$writer->text(" 00*start*do*loop*00");
//		foreach($xml->children() as $lines) {
//			$writer->text(" 00*start*foreach*lines*00");
//
//			foreach($skip as $value) {
//				if ($value ==  $lines['id']) {
//					$writer->text(" 00*skiping*".$lines['id']."*00");
//					continue 2; }
//				}
//			$writer->flush(); 
//			//$writer->text(" 00stats00*curpos[x]=".$curpos['x']."*curpos[y]=".$curpos['y']."*00");
//			//if ( $endpos['x'] == $lines['x2'] && $endpos['y'] == $lines['y2'] ) {  $writer->text(" 00 00"); break; }
//
//			if ( $curpos['x'] == $lines['x1'] && $curpos['y'] == $lines['y1'] ) {
//					$writer->text(" ".$lines['x2']." *-".$lines['y2']."");
//					$curpos['x'] = $lines['x2'];$curpos['y'] = $lines['y2'];
//					array_push($skip,$lines['id']);
//					//$writer->text(" 00stats00*curpos[x]=".$curpos['x']."*curpos[y]=".$curpos['y']."*00");
//					continue;
//				}
//
//
//			if ( $curpos['x'] == $lines['x2'] && $curpos['y'] == $lines['y2'] ) {
//					$writer->text(" ".$lines['x1']." -".$lines['y1']."");
//					$curpos['x'] = $lines['x1'];$curpos['y'] = $lines['y1'];
//					array_push($skip,$lines['id']);
//					//$writer->text(" 00stats00*curpos[x]=".$curpos['x']."*curpos[y]=".$curpos['y']."*00");
//					continue;
//				}
//			$writer->flush(); 
//			$writer->text(" 00*end*foreach*lines*00");
//		}
//$writer->text(" 00*end*do*loop*00");
//	} while   ($endpos['x'] !== $curpos['x'] && $endpos['y'] !== $curpos['y']);
// 
        $writer->endAttribute();
 $writer->writeAttribute ('solid','true');
 $writer->writeAttribute ('spine','0 0 0 0 500 0');
          $writer->endElement();     
           $writer->endElement();   
           $writer->endDocument();   
           $writer->flush(); 
?>
~~~~~~~
