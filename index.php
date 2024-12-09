<?php
if (session_start()) {
	session_destroy();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />
	<link href="css/app.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

	<title>Sistemas Contratos | FGE</title>
</head>

<body>
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="card">
							<div class="card-body">
								<div class="m-sm-4">
									<div class="text-center">
										<h1 class="h2">Sistemas Contratos</h1>
										<img src="./img/icons/fge-icon.png" alt="" class="img-fluid Rounded-Corners" width="200" height="200" />
									</div>
									<form action="./php/iniciar_sesion.php" method="POST">
										<input id="revFolio" name="revFolio" type="text" value="<?php echo isset($_GET['revFolio']) ? $_GET['revFolio'] : '';?>" hidden>
										<div class="mb-3">
											<label class="form-label">Usuario</label>
											<div class="input-group mb-3">
												<span class="input-group-text" id="basic-addon1"><i class="bi bi-person-circle"></i></span>
												<input type="text" class="form-control form-control-lg" id="usuario" name="usuario" placeholder="Ingresa tu nombre de usuario" aria-label="Username" aria-describedby="basic-addon1">
											</div>
										</div>
										<div class="mb-2">
											<label class="form-label">Contraseña</label>
											<div class="input-group mb-3">
												<span class="input-group-text" id="basic-addon2"><i class="bi bi-shield-fill-exclamation"></i></span>
												<input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Ingresa tu contraseña" aria-label="contraseña" aria-describedby="basic-addon2">
											</div>

											<div class="mb-3">
												<label class="form-check">
													<input class="form-check-input" type="checkbox" onclick="verpassword()">Mostrar contraseña</input>

											</div>

											<div class="mb-3">
												<?php
												if (isset($_GET['login']) && isset($_GET['login']) == 'false') {
													echo '<div class="alert alert-danger" role="alert">
													Usuario o Contraseña incorrectos!
													</div>';
												}
												?>
											</div>


											<div class="text-center mt-3">
												<button type="submit" class="btn btn-lg btn-primary">Acceder</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</main>
	<script>
		function verpassword() {
			var tipo = document.getElementById("password");
			if (tipo.type == "password") {
				tipo.type = "text";
			} else {
				tipo.type = "password";
			}
		}
	</script>
	<script src="js/app.js"></script>
	<script src="js/load_captcha.js"></script>
</body>

</html>