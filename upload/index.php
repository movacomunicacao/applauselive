
<!DOCTYPE html>
<html lang="pt" dir="ltr">
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
        background-color:#eee;
      }

      textarea{
        appearance: none !important;
        -webkit-appearance: none !important;
        width: 100% !important;
        display: inline-block !important;
        background-color: #fff;
        resize: none;
        outline: none;
        border-radius: 8px;
        min-height: 300px;
        padding: 15px;
      }

      .titulo{
        width: 300px !important;
        min-height: 60px;
        padding: 15px;
      }

      label{
        font-weight: 700;
      }

      input[type=text]{
        padding: 10px 20px;
        border-radius: 8px;
      }

      .boxtest{
        background-color:#c0c;
        padding:120px 50px;
        display: inline-flex;
        border-radius: 12px;
        color:#fff;
      }

    </style>

    <title>Update</title>

</head>

<body>

  <div class="container-fluid">
    <div class="row justify-content-center mt-5 text-left">
      <form class="col-6" action="result.php" method="post" enctype="multipart/form-data">
        <h3>Upload da lista:</h3>
        <small>*<strong>IMPORTANTE:</strong> Formato da lista em <strong>CSV</strong></small><br>
        <input type="file" name="file" id="file" class="mb-4 mt-1"><br>
        <!--
        <label for="qtd">Quantidade de sorteios:</label><br>
        <input type="number" name="qtd" value="" class="mb-4"><br>
        -->
        <input type="submit" name="submit" value="Atualizar" class="btn btn-primary">
      </form>
    </div>

</body>

</html>
