#!/usr/bin/env php
<?php
if (file_exists('/home/tom/.local/share/rhythmbox/rhythmdb.xml')) {
    $xml = simplexml_load_file('/home/tom/.local/share/rhythmbox/rhythmdb.xml');
 
    foreach ($xml as $value) {
    echo "--------------------\n";
    print_r($value);
    echo "--------------------\n";
    print_r ($value[0])."\n";
    echo "--------------------\n\n";
}
    
} else {
    exit('Failed to open /home/tom/.local/share/rhythmbox/rhythmdb.xml.');
}
?>
