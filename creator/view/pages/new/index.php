<div class="container padding-top-bottom" align="center">

	<div class="col-lg-8 text-left" align="center">


			<div class="pb-4">
				<h3>1. New</h3>
			</div>


			<form action="model/AppModel.php?page=new" method="post" enctype="multipart/form-data">

					<h1>// DATABASE</h1>

					<div class="form-group col-lg-12">
						<label>Database Name</label>
					    <input type="text" name="db_name" class="form-control" >
					</div>

					<div class="form-group col-lg-12">
					    <label>Database Username</label>
					    <input type="text" name="user" class="form-control" placeholder="The user you already use for your local database. (Mainly 'root')">
					</div>

					<div class="form-group col-lg-12">
					    <label>Database Password</label>
					    <input type="text" name="password" class="form-control" placeholder="The pass you already use for your local database. (Mainly 'root' or nothing)">
					</div>

					<div class="form-group col-lg-12">
							<label>Database Port</label>
							<input type="text" name="port" class="form-control" placeholder="The port you already use for your local database. (Mainly 3306 or 8889)">
					</div>

					<h1>// ADMIN - CREATE USER</h1>

					<div class="form-group col-lg-12">
					    <label>ADMIN E-mail</label>
					    <input type="email" name="emailadmin" class="form-control">
					</div>

					<div class="form-group col-lg-12">
					    <label>ADMIN Password</label>
					    <input type="text" name="passworadmin" class="form-control" placeholder="">
					</div>

					<div class="form-group col-md-12 padding-top-bottom text-right">
						<button type="submit" class="btn btn-primary transition">Create</button>
					</div>

			</form>

					<div class="form-group col-lg-12 text-right">
					    <a href="../creator/index.php" class="btn-back" >
							<i class="fas fa-undo-alt"></i> voltar
						</a>
					</div>

		</div>
</div>
