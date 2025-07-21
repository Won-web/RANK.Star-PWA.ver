#!/usr/local/php/bin/php
<?
// Add date to file
// $myfile = fopen("newfile.txt", "a");
// $txt = "Cron run at: " . date('Y-m-d H:i:s') . "\n\n";
// echo $txt;
// fwrite($myfile, $txt);
// fclose($myfile);
// -- end --

$cronURL = "http://ranking-star.com/api/sendByCron";
$curlCommand = "curl {$cronURL}";
exec($curlCommand);
?>
