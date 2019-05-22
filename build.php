#!/usr/bin/env php
<?php

$builddefualts = array (
                        //"plugins" => array (""),
                        "srcRoot" => "sources",
                        "themeRoot" => "themes",
                        "pluginsRoot" => "plugins",
                        "destRoot" => "s3",
                        "gitAuthor" => "tomasparks",
                        "includesSrcs" => array ("gobal"),
                        "tmpRoot" => "tmp",
                        "gobal-pre"=> array ("webmentions","twitter2yml"),
                        "gobal-post" => array ("hfeed")
                        );
                        
$BuildConfig = array
                    (
                    "gallery" => array ("name" => "Gallery",
                    "src" => "gallery-src",
                    "dest" => "gallery.tomasparks.name",
                    "gitDest" => "gallery",
                    "plugins" => "",
                    "pre"=> array ("build-gallery"),
                    ),
                    
                    "main" => array ("name" => "main",
                    "src" => "main",
                    "dest" => "tomasparks.name",
                    "gitDest" => "tomasparks.github.io",
                    "theme"=> "Dynix-theme-jekyll",
                    "plugins" => ""),
                    
                    "miniatures" => array ("name" => "miniatures",
                    "src" => "miniatures-src",
                    "dest" => "miniatures.tomasparks.name",
                    "gitDest" => "miniatures",
                    "theme"=> "lab-notebook-jekyll",
                                            "includesSrcs" => array ("gobal","Articles/miniatures"),
                    "plugins" => ""),
                    
                    "notes" => array ("name" => "notes",
                    "src" => "notes-src",
                    "dest" => "notes.tomasparks.name",
                    "theme"=> "pda-theme-jekyll",
                    "plugins" => "",
                    "pre"=> array ("rhythmdb","twitter","notesgen"))
                    );


$who ="main"; 
$building = $BuildConfig[$who];
$building = array_merge($building,$builddefualts);

$root = getcwd();

echo ($building['gitDest']=='tomasparks.github.io').'\n';

if ($building['gitDest']=='tomasparks.github.io') {
echo "true: do master\n";} else {echo "false: do gh-pages\n";}

// Prebuild
echo "prebuilding....\n";
foreach ($building['gobal-pre'] as $pre) {
    echo "Doing ".$pre."...\n";
    switch ($pre) {
            case "webmentions":
                chdir("".$root."/".$building['srcRoot']."/php/");
                passthru("./webmentions.php");
                breaK;
             case "twitter2yml":
                chdir("".$root."/".$building['srcRoot']."/php/");
                passthru("./twitter2yml.php");
                breaK;               
            case "rhythmdb":
                chdir("".$root."/".$building['srcRoot']."/php/");
                passthru("./rhythmdb2notes.php");
                breaK;
                            case "twitter":
                chdir("".$root."/".$building['srcRoot']."/php/");
                passthru("./twitter2yml.php");
                breaK;
             case "notesgen":
                chdir("".$root."/".$building['srcRoot']."/php/");
                #passthru("./notes.php");
                breaK;
            }
}

//passthru("cd ".$root."");
echo "Updating ".$building['name']." sources....\n";
chdir("".$root."/".$building['srcRoot']."/".$building['src']."/");
passthru("git add *");
passthru("git gc --auto --aggressive");
passthru("git commit -a -m \"Update ".$building['name']."\"");
passthru("git push");

if (isset($building['theme'])) {
//passthru("cd ".$root."");
echo "Updating ".$building['theme']." theme....\n";
chdir("".$root."/".$building['themeRoot']."/".$building['theme']."/");
passthru("git add *");
passthru("git gc --auto --aggressive");
passthru("git commit -a -m \"Update ".$building['theme']."\"");
passthru("git push");
}

// Update Plugins
if (is_array ($building['plugins'])) {
foreach ($building['plugins'] as $plugin) {
echo "Updating Plugin: ".$plugin." Sources....\n";
    chdir("".$root."/".$building['pluginsRoot']."/".$plugin."/");
    passthru("git add *");
    passthru("git gc --auto --aggressive");
    passthru("git commit -a -m \"Update ".$plugin."\"");
    passthru("git push");
}
}

echo "Cleaning ".$building['tmpRoot']."....\n";
chdir("".$root."");
passthru("rm -rf \"./".$building['tmpRoot']."/\"");
passthru("mkdir \"./".$building['tmpRoot']."/\"");
chdir("./".$building['tmpRoot']."/");

if (isset($building['theme'])) {
echo "Copying Website thene....\n";
$src ="".$root."/".$building['themeRoot']."/".$building['theme']."/";
$dest ="".$root."/".$building['tmpRoot']."/ ";
passthru("rsync --times  -r  --times --exclude \".git/\" ".$src." ".$dest."");
}

echo "Copying Website source....\n";
$src ="".$root."/".$building['srcRoot']."/".$building['src']."/";
$dest ="".$root."/".$building['tmpRoot']."/ ";
passthru("rsync --times  -r  --times --exclude \".git/\" ".$src." ".$dest."");

echo "Copying extra sources....\n";
foreach ($building['includesSrcs'] as $source) {
echo "Copying ".$source."...\n";
    passthru("rsync --times   -r  --times --exclude \".git/\"  ".$root."/".$building['srcRoot']."/".$source."/    ".$dest."");
}
if (is_array ($building['plugins'])) {
echo "Copying plugins....\n";
foreach ($building['plugins'] as $plugin) {
echo "Copying ".$plugin."...\n";
    passthru("mkdir -p ./_plugins/".$plugin."/");
    passthru("rsync --times   -r --exclude \".git/\" ".$root."/".$building['pluginsRoot']."/".$plugin."/ ".$root."/".$building['tmpRoot']."/_plugins/".$plugin."/");
}
}

// Prebuild
if (isset($building['pre'])) {
echo "prebuilding....\n";
foreach ($building['pre'] as $pre) {
    echo "Doing ".$pre."...\n";
    passthru("./_php/".$pre.".php");
}
}
echo "Building website.....\n";
passthru("ionice bundle update");

if (isset($building['theme'])) {
passthru("ionice bundle exec jekyll build  -V --config _gobal.yml,_theme.yml,_config.yml --verbose --trace --profile");
} else {
passthru("ionice bundle exec jekyll build  -V --config _gobal.yml,_config.yml --verbose --trace --profile");
}


#passthru("rsync --times  -r --times --remove-source-files --include=\"_data**\" --include=\"_gobal.yml\" --include=\"Gemfile\" --exclude=\"*\" --exclude=\"*/\" . ".$root."/".$building['srcRoot']."/gobal/");


#passthru("rsync --times   -r --times --remove-source-files --exclude \"_site/\" --exclude \"_plugins/\" . ".$root."/".$building['srcRoot']."/".$building['src']."/");




passthru("rsync --times   -r  --delete-after  _site/ ".$root."/".$building['destRoot']."/".$building['dest']."/");
chdir("".$root."/".$building['destRoot']."/".$building['dest']."/");

echo "copying jF2 file to gobal data\n";
passthru("cp feed.jf2 ".$root."/".$building['srcRoot']."/gobal/_data/feeds/".$building['name'].".jf2");

//rsync --times   -r --exclude ".git/" . /opt/lampp/htdocs/gallery/

If (isset($building['gitDest'])) {
passthru("git init");
passthru("git remote add origin git@github.com:".$building['gitAuthor']."/".$building['gitDest'].".git");
//echo $building['gitDest'].'=='.(!$building['gitDest']).'\n';
if ($building['gitDest'] == "tomasparks.github.io") {echo "upload to master\n";passthru("git symbolic-ref HEAD refs/heads/master");} else {echo "upload to gh-pages\n";passthru("git symbolic-ref HEAD refs/heads/gh-pages");}

passthru("rm .git/index");
passthru("git add *");
passthru("git gc --auto --aggressive");
passthru("git commit -a -m \"Update ".$building['name']." section\"");

passthru("git gc --auto --aggressive");

if ($building['gitDest'] =="tomasparks.github.io") {passthru("while ! git push -v --progress --force -u origin master; do sleep 10; done");} else {passthru("while ! git push -v --progress --force -u origin gh-pages; do sleep 10; done");}
}
//rm -rf ".git"

chdir("".$root."/".$building['srcRoot']."/");

passthru("git add *");
passthru("git gc --auto --aggressive");
passthru("git commit -a -m \"update website sources\"");
passthru("git push");

// postbuild
echo "postbuilding....\n";
foreach ($building['gobal-post'] as $post) {
    echo "Doing ".$post."...\n";
    switch ($post) {
            case "hfeed":
                chdir("".$root."/".$building['srcRoot']."/php/");
                passthru("./hfeed.php");
chdir("".$root."/".$building['destRoot']."/tomasparks.name/");

passthru("git add *");
passthru("git gc --auto --aggressive");
passthru("git commit -a -m \"update gobal-feeds\"");
passthru("git push");
                
                breaK;
            }
}

//zip jekyll-build-cast.zip --latest-time --test --move *.cast */
?>
