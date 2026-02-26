	<div class="container-fluid pt-5 pt-lg-0">
        <div class="row justify-content-center mb-5 pt-lg-5">
            <div class="col-lg-6 col-10 text-center">
                <form action="<?=ROOT?>upload/result.php" method="post" enctype="multipart/form-data">
                    <div class="form-group text-start">
                        <input type="text" name="name" class="form-control mt-0 form-control-lg search" value="" placeholder="Nome">
						<input type="file" id="myfile" name="myfile"><br><br>
                    </div>
                    <div class="text-center mt-3">
                        <input type="submit" class="btn btn-home" value="Enviar">
                    </div>
                </form>
            </div>
        </div>
    </div>

