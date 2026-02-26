<?php
exec('which /opt/homebrew/bin/ffmpeg 2>&1', $out, $code);
echo "<pre>";
echo implode("\n", $out);
echo "\nExit code: $code";
