<?php
declare(strict_types=1);

ini_set('display_errors', '1');
error_reporting(E_ALL);

$workDir   = __DIR__ . '/work';
$outputDir = __DIR__ . '/output';

ensureDir($workDir);
ensureDir($outputDir);

if (!hasFfmpeg()) {
    http_response_code(500);
    exit("ffmpeg not found in PATH.");
}

if (!isset($_FILES['csv']) || $_FILES['csv']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    exit("CSV upload failed.");
}

$tmpPath = $_FILES['csv']['tmp_name'];
$urls = readUrlsFromCsv($tmpPath);

if (count($urls) === 0) {
    exit("No URLs found in CSV.");
}

$results = [];

foreach ($urls as $url) {
    $row = [
        'url' => $url,
        'status' => 'failed',
        'output_file' => '',
        'message' => '',
    ];

    if (!isHttpUrl($url)) {
        $row['message'] = 'Invalid URL';
        $results[] = $row;
        continue;
    }

    $movName = extractFilename($url, 'mov');
    if (!$movName) {
        $row['message'] = 'URL does not end with .mov (path)';
        $results[] = $row;
        continue;
    }

    $baseName = pathinfo($movName, PATHINFO_FILENAME);

    $movPath = uniquePath($workDir . '/' . $movName);
    $mp4Path = uniquePath($outputDir . '/' . $baseName . '.mp4');

    // Download
    $ok = downloadFile($url, $movPath);
    if (!$ok) {
        @unlink($movPath);
        $row['message'] = 'Download failed';
        $results[] = $row;
        continue;
    }

    // Convert
    [$code, $log] = runCmd(buildFfmpegCmd($movPath, $mp4Path));

    if ($code === 0 && file_exists($mp4Path) && filesize($mp4Path) > 0) {
        $row['status'] = 'ok';
        $row['output_file'] = basename($mp4Path);
        $row['message'] = 'Converted';
    } else {
        @unlink($mp4Path);
        $row['message'] = "FFmpeg failed (exit $code)";
        // Keep log short for display
        $row['ffmpeg_log'] = substr(trim($log), 0, 1200);
    }

    @unlink($movPath); // cleanup temp
    $results[] = $row;
}

renderResults($results, $outputDir);

/* ---------------- helpers ---------------- */

function ensureDir(string $dir): void {
    if (!is_dir($dir)) mkdir($dir, 0775, true);
}

function hasFfmpeg(): bool {
    // Linux/macOS
    @exec('command -v /opt/homebrew/bin/ffmpeg 2>/dev/null', $o, $c);
    if ($c === 0 && !empty($o)) return true;

    // Windows fallback (if needed)
    @exec('where /opt/homebrew/bin/ffmpeg 2>NUL', $o2, $c2);
    return $c2 === 0 && !empty($o2);
}

function readUrlsFromCsv(string $csvPath): array {
    $urls = [];

    $fh = fopen($csvPath, 'r');
    if (!$fh) return [];

    // Read first line to detect header/structure
    $first = fgetcsv($fh);
    if ($first === false) {
        fclose($fh);
        return [];
    }

    // Normalize header candidates
    $lower = array_map(fn($v) => strtolower(trim((string)$v)), $first);
    $urlIndex = array_search('url', $lower, true);
    if ($urlIndex === false) $urlIndex = array_search('video_url', $lower, true);

    if ($urlIndex !== false) {
        // Has header with url column
        while (($row = fgetcsv($fh)) !== false) {
            $u = trim((string)($row[$urlIndex] ?? ''));
            if ($u !== '') $urls[] = $u;
        }
    } else {
        // No header: treat first cell of each row as URL (including first line)
        $u0 = trim((string)($first[0] ?? ''));
        if ($u0 !== '') $urls[] = $u0;

        while (($row = fgetcsv($fh)) !== false) {
            $u = trim((string)($row[0] ?? ''));
            if ($u !== '') $urls[] = $u;
        }
    }

    fclose($fh);

    // de-dupe
    $urls = array_values(array_unique($urls));
    return $urls;
}

function isHttpUrl(string $url): bool {
    $p = parse_url($url);
    return isset($p['scheme'], $p['host']) &&
           in_array(strtolower($p['scheme']), ['http', 'https'], true);
}

function extractFilename(string $url, string $ext): ?string {
    $path = parse_url($url, PHP_URL_PATH);
    if (!$path) return null;

    $name = basename($path);
    if (!str_ends_with(strtolower($name), '.' . strtolower($ext))) return null;

    return sanitizeFilename($name);
}

function sanitizeFilename(string $name): string {
    $name = preg_replace('/[^a-zA-Z0-9._-]/', '_', $name);
    return trim((string)$name, '_');
}

function uniquePath(string $path): string {
    if (!file_exists($path)) return $path;

    $dir  = dirname($path);
    $base = pathinfo($path, PATHINFO_FILENAME);
    $ext  = pathinfo($path, PATHINFO_EXTENSION);

    $i = 1;
    do {
        $new = $dir . '/' . $base . '_' . $i . '.' . $ext;
        $i++;
    } while (file_exists($new));

    return $new;
}

function downloadFile(string $url, string $dest): bool {
    $fp = fopen($dest, 'wb');
    if (!$fp) return false;

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_FILE => $fp,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS => 5,
        CURLOPT_FAILONERROR => true,
        CURLOPT_CONNECTTIMEOUT => 20,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_USERAGENT => 'mov-to-mp4-csv/1.0',
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
    ]);

    $ok = curl_exec($ch);
    curl_close($ch);
    fclose($fp);

    return $ok && file_exists($dest) && filesize($dest) > 0;
}

function buildFfmpegCmd(string $mov, string $mp4): string {
    return sprintf(
        '/opt/homebrew/bin/ffmpeg -hide_banner -y -i %s ' .
        '-c:v libx264 -crf 20 -preset medium -pix_fmt yuv420p ' .
        '-vf "scale=trunc(iw/2)*2:trunc(ih/2)*2" ' .
        '-c:a aac -b:a 128k -movflags +faststart %s',
        escapeshellarg($mov),
        escapeshellarg($mp4)
    );
}

function runCmd(string $cmd): array {
    $out = [];
    $code = 0;
    exec($cmd . ' 2>&1', $out, $code);
    return [$code, implode("\n", $out)];
}

function renderResults(array $results, string $outputDir): void {
    ?>
    <!doctype html>
    <html lang="en">
    <head>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Conversion Results</title>
      <style>
        body { font-family: system-ui, sans-serif; padding: 24px; max-width: 1100px; margin: 0 auto; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 10px; vertical-align: top; }
        th { background: #f6f6f6; text-align: left; }
        .ok { color: #0a7a2f; font-weight: 600; }
        .fail { color: #b00020; font-weight: 600; }
        code { white-space: pre-wrap; }
      </style>
    </head>
    <body>
      <h2>Conversion Results</h2>
      <p>Output folder: <code><?= htmlspecialchars($outputDir) ?></code></p>

      <table>
        <thead>
          <tr>
            <th>Status</th>
            <th>URL</th>
            <th>Output</th>
            <th>Message</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($results as $r): ?>
            <tr>
              <td class="<?= $r['status'] === 'ok' ? 'ok' : 'fail' ?>">
                <?= htmlspecialchars($r['status']) ?>
              </td>
              <td><code><?= htmlspecialchars($r['url']) ?></code></td>
              <td>
                <?php if (!empty($r['output_file'])): ?>
                  <code><?= htmlspecialchars($r['output_file']) ?></code>
                <?php endif; ?>
              </td>
              <td>
                <?= htmlspecialchars($r['message'] ?? '') ?>
                <?php if (!empty($r['ffmpeg_log'])): ?>
                  <details style="margin-top:8px;">
                    <summary>FFmpeg log</summary>
                    <code><?= htmlspecialchars($r['ffmpeg_log']) ?></code>
                  </details>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <p style="margin-top:16px;"><a href="index.php">Convert another CSV</a></p>
    </body>
    </html>
    <?php
}
