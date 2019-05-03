#!/usr/bin/env php
<?php
   class MyDB extends SQLite3 {
      function __construct() {
         $this->open('/home/tom/.kodi/userdata/Database/MyVideos107.db');
      }
   }
   
   $db = new MyDB();
   if(!$db) {
      echo $db->lastErrorMsg();
   } else {
      echo "Opened database successfully\n";
   }

   $sql =<<<EOF
      SELECT * from tvshow_view;
EOF;


   $ret = $db->query($sql);
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
      print_r($row) . "\n";
   }

   echo "Operation done successfully\n";
   $db->close();
?>
