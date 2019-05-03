#!/usr/bin/env php
<?php

	$json = file_get_contents("https://granary.io/twitter/%40me/@self/@app/?format=mf2-json&access_token_key=965564724560609280-akzIBxc445Wof45B1JPZ8kjXopGpDWA&access_token_secret=ls65zMjMa49xbGjG15IhaVqLcgAJh5bmixStjq3VtKlJ6");
$json_array = json_decode($json,TRUE);



yaml_emit_file ("h-cards.yml" , $json_array); 
//print_r($json_array);
foreach ($json_array['items'] as $value) {		    		
	    print_r($value['properties']['category']);
	    
	}
?>
