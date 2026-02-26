<div class="menu-mobile-button"><i class="fas fa-bars"></i></div>

<div class="menu-mobile">
  <div class="menu-mobile-button-remove"><i class="fas fa-times"></i></div>
  <?php include 'menu.php'; ?>
</div>

<script>
$( ".menu-mobile-button" ).click(function() {
	$(".menu-mobile-button-remove").css("display", "block");
  $(".menu-mobile-button").css("display", "none");
	$(".menu-mobile").toggleClass("menu-mobile menu-mobile-active");
});
$( ".menu-mobile-button-remove" ).click(function() {
	$(".menu-mobile-button-remove").css("display", "none");
	$(".menu-mobile-active").toggleClass("menu-mobile-active menu-mobile");
  $(".menu-mobile-button").css("display", "block");
});
</script>

<style type="text/css">

.menu-mobile-button, .menu-mobile-button-remove{
	display: none;
	z-index: 300;
}

.menu-mobile{
	display: none;
}

@media only screen and (min-device-width: 10px) and (max-device-width: 575px) {

  .menu-mobile-button{
  	position:absolute;
  	top:2px;
    left:20px;
  	display: block;
  	color: #333;
  	float:left;
  	font-size: 2.3em;
  	z-index: 300;
  }

  .menu-mobile-button-remove{
  	position:absolute;
  	display: none;
  	color: #000;
  	top:10px;
  	left:20px;
  	margin-top:10px;
  	font-size: 1.3em;
  }

  .menu-mobile{
  	display: none;
  }

  .menu-mobile-active{
  	width: 100%;
      position: absolute;
      top: 0;
      background-color: #ddd;
      color: #000;
      padding: 50px 0 50px 10px;
      font-size: 1.3em;
      z-index: 100;
      text-align: center;

  		animation: menu_slide_in 0.5s 1;
  		-webkit-animation: menu_slide_in 0.5s 1;
  		-moz-animation: menu_slide_in 0.5s 1;
  }

  @keyframes menu_slide_in {
  	0%{opacity:0; margin-top:-800px;}
  	100%{opacity:1;margin-top:0;}
  }

  @keyframes menu_circle_in {
  	0%{clip-path: circle(0.0% at 50% 40%);-webkit-clip-path: circle(0.0% at 50% 40%);-moz-clip-path: circle(0.0% at 50% 40%);}
  	100%{clip-path: circle(50% at 50% 40%);-webkit-clip-path: circle(50% at 50% 40%);-moz-clip-path: circle(50% at 50% 40%);}
  }

  .menu-mobile-active a{
  	display: block;
  	margin: 40px 0;
  	color: #000;
  }

  #top nav{
    display: none;
  }

}
</style>
