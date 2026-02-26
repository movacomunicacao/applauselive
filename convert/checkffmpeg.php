<?php
exec('ffmpeg -version 2>&1', $out, $code);
echo "<pre>";
echo implode("\n", $out);
echo "\nExit code: $code";
