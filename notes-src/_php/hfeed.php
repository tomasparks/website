#!/usr/bin/env php
<?php
// curl -i -d "source=$your_url&target=$target_url" $targets_webmention_endpoint


$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><mydoc></mydoc>');

$xml->addAttribute('version', '1.0');
$xml->addChild('datetime', date('Y-m-d H:i:s'));

$person = $xml->addChild('person');
$person->addChild('firstname', 'Someone');
$person->addChild('secondname', 'Something');
$person->addChild('telephone', '123456789');
$person->addChild('email', 'me@something.com');

$address = $person->addchild('address');
$address->addchild('homeaddress', 'Andersgatan 2, 432 10 Göteborg');
$address->addChild('workaddress', 'Andersgatan 3, 432 10 Göteborg');

echo $xml->asXML();

?>
