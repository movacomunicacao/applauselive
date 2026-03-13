
<!DOCTYPE html>
<html lang="pt-br">
<head>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
  
<meta charset="UTF-8">
<title>Cadastro realizado</title>

<style>

body{
    font-family: "Titillium Web", sans-serif;
    margin:0;
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background-color: #efefef;
}

.card{
    background:white;
    padding:60px 80px;
    border-radius:14px;
    /*box-shadow:0 20px 50px rgba(0,0,0,0.08);*/
    text-align:center;
    animation:fadeIn .6s ease;
}

h1{
    font-size:55px;
    margin-top:30px;
    margin-bottom:15px;
    color:#1f2937;
}

p{
    color:#6b7280;
    font-size:40px;
}

/* BIGGER CHECK ICON */

.checkmark{
  width:120px;
  height:120px;
  border-radius:50%;
  display:block;
  stroke-width:4;
  stroke:#ffffff;
  stroke-miterlimit:10;
  margin:auto;
  box-shadow:inset 0 0 0 #22c55e;
  animation:fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
}

.checkmark__circle{
  stroke-dasharray:166;
  stroke-dashoffset:166;
  stroke-width:4;
  stroke:#22c55e;
  fill:none;
  animation:stroke .6s cubic-bezier(.65,0,.45,1) forwards;
}

.checkmark__check{
  transform-origin:50% 50%;
  stroke-dasharray:48;
  stroke-dashoffset:48;
  stroke:#ffffff;
  animation:stroke .3s cubic-bezier(.65,0,.45,1) .8s forwards;
}

/* SPINNER */

.spinner{
    width:60px;
    height:60px;
    border:4px solid #e5e7eb;
    border-top:4px solid #111;
    border-radius:50%;
    margin:40px auto 0;
    animation:spin 1s linear infinite;
}

/* ANIMATIONS */

@keyframes stroke{
  100%{stroke-dashoffset:0;}
}

@keyframes scale{
  0%,100%{transform:none;}
  50%{transform:scale3d(1.15,1.15,1);}
}

@keyframes fill{
  100%{box-shadow:inset 0 0 0 70px #111;}
}

@keyframes spin{
  0%{transform:rotate(0deg);}
  100%{transform:rotate(360deg);}
}

@keyframes fadeIn{
  from{opacity:0; transform:translateY(10px);}
  to{opacity:1; transform:translateY(0);}
}

</style>

</head>

<body>

<div class="card">

<svg class="checkmark" viewBox="0 0 52 52">
  <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
  <path class="checkmark__check" fill="none" d="M14 27l7 7 16-16"/>
</svg>

<h1>Cadastro feito<br>com sucesso!</h1>
<p>Você está sendo redirecionado<br>para a tela de login.</p>

<div class="spinner"></div>

</div>

<script>
setTimeout(function(){
    window.location.href = "'.ROOT.'";
},6000);
</script>

</body>
</html>