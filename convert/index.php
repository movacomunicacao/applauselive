<!doctype html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Batch MOV → MP4 (CSV)</title>
  <style>
    body { font-family: system-ui, sans-serif; padding: 24px; max-width: 900px; margin: 0 auto; }
    input, button { font-size: 16px; }
    .card { padding: 16px; border: 1px solid #ddd; border-radius: 12px; }
  </style>
</head>
<body>
  <h2>Upload CSV with MOV URLs</h2>
  <div class="card">
    <p>CSV format examples:</p>
    <ul>
      <li>One URL per line</li>
      <li>Or a header with a column named <b>url</b> (or <b>video_url</b>)</li>
    </ul>

    <form action="convert_csv.php" method="post" enctype="multipart/form-data">
      <input type="file" name="csv" accept=".csv,text/csv" required>
      <button type="submit">Upload & Convert</button>
    </form>
  </div>
</body>
</html>
