<div class="row justify-content-center">
	<div class="col-12 text-center px-0">
		<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
		  <div class="carousel-inner">
				<loop>
				  <sql>table=banners;limit=1;</sql>
					<div class="carousel-item active">
			      <img src="<?=IMG_DIR?>banners/{img}" class="d-block w-100" alt="{title}">
			    </div>
				</loop>
		  </div>
		</div>
	</div>
</div>
