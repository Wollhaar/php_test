<?php

function hash_str($str, $boo = false): string
{
    $hash = sha1($str, $boo);

    if ([conditions on hash]) hash_str($hash);
    return $hash;
}
$test = 'Sommer_2021';

$hash = hash_str($test);
$path = '[path]/test_pass/';
$filename = 'hashhash.txt';


file_put_contents($path . $filename, $test . ' => ' . $hash);
