#!/usr/bin/php
<?php
if($argc>1) {
	$requestString = 'GET https://api.agify.io/?name=' . $argv[1];
}
else {
	$requestString = 'GET https://api.agify.io/?name=bella';
}
print $requestString;
print "\n\n";
print $argv[1];
$results = shell_exec($requestString);
$arrayCode = json_decode($results);
var_dump($arrayCode);
?>
