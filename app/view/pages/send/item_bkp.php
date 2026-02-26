<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-lg-8 col-10 py-5">

			<loop>
				<sql>where= id = '<?= $_GET['id']?>' ;limit=1; </sql>

				<div class="row justify-content-center">
					<img src="IMG_DIR<?=$_GET['page']?>/{img}" alt="{title}" class="col-lg-6 col-12">
				</div>

				<div class="row justify-content-center mt-5 py-5">
					<div class="col-12">
						<h1>{title}</h1>
						<p>
							{description}
						</p>
					</div>
				</div>

			</loop>

		</div>
	</div>
</div>
