<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

$ffmpeg = '/usr/bin/ffmpeg'; // CHANGE to the result of: which ffmpeg
$cmd = escapeshellcmd($ffmpeg) . ' -hide_banner -version 2>&1';

exec($cmd, $out, $code);

echo "<pre>";
echo "Command: $cmd\n\n";
echo implode("\n", $out);
echo "\n\nExit code: $code\n";
