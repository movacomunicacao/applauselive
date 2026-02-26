<?php
declare(strict_types=1);
ini_set('display_errors', '1');
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="author" content="Mova" />
    <meta http-equiv="cache-control" content="Public, max-age=31536000">
    <meta http-equiv="Pragma" content="Public">
    <meta http-equiv="Expires" content="Expires: Sat, 13 May 2020 07:00:00 GMT">
    <meta http-equiv="content-language" content="pt-br" />
    <meta name="description" content="Mova Advertising Portfolio and services." />
    <meta name="DC.description" content="Mova Advertising Portfolio and services." />
    <meta name="keywords" content="mova, propaganda, publicidade, marketing, agencia, toledo, design, sites, comunicação, campanhas     " />
    <meta name="DC.subject" content="mova, propaganda, publicidade, marketing, agencia, toledo, design, sites, comunicação, campanhas     " />
    <meta name="robots" content="all" />
    <meta name="rating" content="general" />
    <meta name="DC.title" content="Mova Propaganda" />
    <meta name="theme-color" content="#000000"/>

    <!-- Jquery and Ajax Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <link rel="canonical" href="https://mova.ppg.br/resources/clientes/elanco/sorteio/sbsa"/>

    <style type="text/css">
      body{
        background-color: #eee;
        font-size: 18px;
      }
      .pergunta{
        color: #777;
        font-size:14px;
      }
      h2{
        font-weight: bold;
      }
    </style>

  </head>

  <body>
    <div class="row justify-content-center">
      <div class="col-6">
        <h1 class="text-center py-5">Upload</h1><br>
        <div class="text-left py-5 px-5">
        <?php

          $file						= $_FILES['file']['name'];
          $datename				= date('Y-m-d-h-m-s');
          $filename				= $datename.'-'.$file;
          $_UP['folder']	= 'files/';

          move_uploaded_file($_FILES['file']['tmp_name'], $_UP['folder'] . $filename);
          $fullpathimg = 	$_UP['folder'].$filename;
          $csv = array();

          if(($handle = fopen("$fullpathimg", "r")) !== FALSE){
            while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
              $csv[] = $data;
            }
          }

          fclose($handle);
          $lenghtarr = count($csv);
          $lenghtcsv = count($csv[0]);

          include '../app/config/database.php';
          include '../app/model/AppModel.php';

          $conn = db();

          $key_sk   = random_bytes(32);
          $key_siv  = random_bytes(32);
          $key_sk   = base64_encode($key_sk);
          $key_siv  = base64_encode($key_siv);
          $key_sk   = hash("sha256", $key_sk);
          $key_siv  = substr(hash("sha256", $key_siv), 0, 16);

          $videofiles = array();
          $value = '';
          //$videopaths = array();  

          $values = "INSERT INTO messages (id_typeform, name, email, password, recipient, como, upload, text_message, response_type, start_date, stage_date, submit_date, network_id, tags, ending) VALUES (";
          for($i = 1; $i < $lenghtarr; $i++){ 

            for($j = 0; $j < $lenghtcsv; $j++){

  
              if($j == 0){
                $id_typeform = $csv[$i][$j];
                $videopath = '../upload/videos/'.$id_typeform;

                //echo $id_typeform.'<br>';
                
                if (is_dir($videopath)) {
                    $files = $_FILES['file']['name'];
                    $videofiles[] =  'http://localhost:8888/applause/upload/videos/'.$id_typeform.'/'.$path_file; 
                } else {
                    //echo "Directory does not exist: " . $videopath . "<br>";
                }     
                
                $value = $id_typeform;

              }

              

              elseif($j == 2){
                $email =  $csv[$i][$j];
                $query	= $conn->prepare("SELECT email FROM users WHERE email= :email");
                $query->bindParam(':email', $email);
                $query->execute();

                if ($query->rowCount() > 0){
                  $keypass = $query->fetchColumn();
                  $value = $csv[$i][$j];
                } else {
                  
                  $title    = $csv[$i][1];
                  $email    = $csv[$i][2];
                  $password = $csv[$i][3];
                  $keypass  =  $csv[$i][3];
                  $created  = date("Y-m-d");
                  $updated  = date("Y-m-d");
                  $active   = '1';
                  $reference = date("Ymdhs").uniqid();

                  $crypted_password = encrypting("encrypt", $password, $key_sk, $key_siv);

                  $query 	= $conn->prepare("INSERT INTO users (title, email, password, keypass, key_iv, key_tag, created, updated, reference, active) VALUES(:title, :email, :password, :keypass, :key_iv, :key_tag, :created, :updated, :reference, :active)");

                  $query->bindParam(':title', $title);
                  $query->bindParam(':email', $email);
                  $query->bindParam(':password', $crypted_password);
                  $query->bindParam(':keypass', $crypted_password);
                  $query->bindParam(':key_iv', $key_sk);
                  $query->bindParam(':key_tag', $key_siv);
                  $query->bindParam(':created', $created);
                  $query->bindParam(':updated', $updated);
                  $query->bindParam(':reference', $reference);
                  $query->bindParam(':active', $active);

                  $query->execute();
                  
                }

              } 

              elseif($j == 3){
                
                $password_raw = $csv[$i][$j];
                $value = encrypting("encrypt", $password_raw, $key_sk, $key_siv);
                
              }

              elseif($j == 6){

                $mov_to_mp4_input = $csv[$i][$j];
                $mov_to_mp4 = substr($mov_to_mp4_input, strrpos($mov_to_mp4_input, '/') + 1);

                if(!empty($mov_to_mp4)){
                  $mov_to_mp4 = substr($mov_to_mp4, 0, -4) . '.mp4';
                } else {
                  $mov_to_mp4 = '';
                }

                $value = $mov_to_mp4;
                
                //echo $mov_to_mp4_input.'<br>' ;
                           
              }

              elseif($j == 10){
                $date = date('Y-m-d h:m:s');
                $value = $date;
              }
              
              else {
                $value = $csv[$i][$j];
              }

              $values .= "'".$value."', ";

            }

            $values = substr($values, 0, -2);
            $values .= "), (";

          }

          $lenghtvideofiles = count($videofiles);

          $values = substr($values, 0, -3);

          //die();     
          //echo $values; die(); 
          
          $sql = $values ;
          $query = $conn->prepare($sql); 
          $query->execute();
          
          



/* ---------------------------------------------------------------------------
  CONTEVERT VIDEOS FROM MOV TO MP4 USING FFMPEG
------------------------------------------------------------------------------
*/








$workDir   = __DIR__ . '/work';
$outputDir = __DIR__ . '/output';

ensureDir($workDir);
ensureDir($outputDir);


// Normalize URLs: trim, remove empty, de-dupe
$urls = array_values(array_unique(array_filter(array_map('trim', $videofiles), fn($u) => $u !== '')));

if (!hasFfmpeg()) {
    http_response_code(500);
    exit("ffmpeg not found or not executable.");
}

if (count($urls) === 0) {
    exit("No URLs found in \$videofiles_clean.");
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

    $baseName = substr($baseName, strrpos($baseName, '-') + 1);

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
    // Since you are using a fixed path in buildFfmpegCmd(),
    // check that binary directly:
    $ffmpeg = '/opt/homebrew/bin/ffmpeg';
    return is_file($ffmpeg) && is_executable($ffmpeg);
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
        CURLOPT_USERAGENT => 'mov-to-mp4-array/1.0',
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
    ]);

    $ok = curl_exec($ch);
    curl_close($ch);
    fclose($fp);

    return $ok && file_exists($dest) && filesize($dest) > 0;
}

function buildFfmpegCmd(string $mov, string $mp4): string {
    $ffmpeg = '/opt/homebrew/bin/ffmpeg';

    return sprintf(
        '%s -hide_banner -y -i %s ' .
        '-c:v libx264 -crf 20 -preset medium -pix_fmt yuv420p ' .
        '-vf "scale=trunc(iw/2)*2:trunc(ih/2)*2" ' .
        '-c:a aac -b:a 128k -movflags +faststart %s',
        escapeshellarg($ffmpeg),
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



//-------------------------------------------


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
    </body>
    </html>
    <?php
}
























          echo '<h2>Success!</h2>';

        ?>
        </div>
      </div>
    </div>
  </body>

</html>
