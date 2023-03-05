<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
ini_set("display_errors", 0 );
?>
<!DOCTYPE html>
<html lang="pt">

	<head>

		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>Novo usuário</title>

		<link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		<link href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

	</head>
					<div class="container-fluid">
						<div class="d-sm-flex align-items-center justify-content-between mb-4">
							<h1 class="h3 mb-0 text-gray-800">Novo usuário</h1>
						</div>
						<?php if ($alert != null) { ?>
							<div class="alert alert-<?php echo $alert["class"]; ?>"> <?php echo $alert["message"]; ?> </div>
						<?php } ?>
						<div class="row">
						    <div class="col-xl-12 col-lg-12">
						        <div class="card shadow mb-4">
						            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Dados do usuário</h6>
                                    </div>
    						        <div class="card-body">
    						            <form action="<?= base_url('novousuario/salvar'); ?>" method="post">
											<div class="form-group row">
												<div class="col-sm-6 mb-3 mb-sm-0">
													<input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Nome" onkeypress="charMask();" minlength="7" required>
												</div>
												<div class="col-sm-6">
													<input type="text" class="form-control form-control-user" id="userphone" name="userphone" placeholder="Telefone" onkeyup="PhoneMask(this);" onkeypress="integerMask();" minlength="14" maxlength="15" required>
												</div>
											</div>
											<div class="form-group">
												<input type="email" class="form-control form-control-user" id="useremail" name="useremail" placeholder="E-mail" minlength="7" required>
											</div>
											<div class="form-group">
												<input type="text" class="form-control form-control-user" id="userkey" name="userkey" placeholder="Chave PIX">
											</div>
											<button type="submit" href="login.html" class="btn btn-primary btn-user">
												Cadastrar
											</button>
											<a type="button" href="<?= base_url('usuarios'); ?>" class="btn btn-danger btn-user">
												Cancelar
											</a>
										</form>
                            		</div>
                                </div>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>	
	
		<script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
		<script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
		<script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
		<script src="<?= base_url('assets/js/sb-admin-2.min.js'); ?>"></script>
		<script src="<?= base_url('assets/js/lr-maskvalid.js'); ?>" type="text/javascript"></script>
		<script src="<?= base_url('assets/js/lr-passconfirm.min.js'); ?>" type="text/javascript"></script>
	</body>
</html>
