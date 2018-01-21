#!/usr/bin/env php
<?php

date_default_timezone_set('Australia/Brisbane');

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

// ================================
$file = "./collection.json";
$json = file_get_contents($file); 
$json_array = json_decode($json,true);
print_r($json_array);
			//$json = json_encode($json_array);
			//$json_array = json_decode($json,TRUE);
//print_r($json_array);
//$values = deepValues($json_array);

$data=$json_array['items'];
$data = $data[0];

//echo yaml_emit($data)."\n";

$out_array['type'] = $data['type'][0];
$properties_array['name'] = $data['properties']['name'][0];
$properties_array['content'] = $data['properties']['content'][0];
$out_array['properties'] = $properties_array;
$children = $data['children'];
//$children_array
$out_array['children']  = $children;

echo yaml_emit($out_array)."\n";
			
			
?>
