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

		<title>Gerenciar - Carteira</title>

		<link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		<link href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

	</head>
					<div class="container-fluid">
						<div class="d-sm-flex align-items-center justify-content-between mb-4">
							<h1 class="h3 mb-0 text-gray-800">Carteira de <?= $walletinfo['username'] ?></h1>
						</div>
						<div class="row">
							<div class="col-xl-12 col-lg-12">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Retirar fundos</h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if ($alert != null) { ?>
											<div class="alert alert-<?php echo $alert["class"]; ?>"> <?php echo $alert["message"]; ?> </div>
										<?php } ?>
                                        <form action="<?= base_url('sacar/finalizar'); ?>" method="post" enctype="multipart/form-data">
                                            <input type="hidden" id="fo_user" name="fo_user" value="<?= $walletinfo['userid'] ?>" />
                                            <div class="form-group">
                                                <label class="small mb-1" for="fo_value">Insira o valor a ser sacado</label>
                                                <input class="form-control" id="fo_value" name="fo_value" type="text" placeholder="Insira o valor a ser sacado" onkeyup="MoneyMask(this);" onkeypress="integerMask();" maxlength="7" required/>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="fo_attach">Anexe o comprovante</label>
                                                <input type="file" class="form-control-file form-control-user" id="fo_attach" name="fo_attach" required>
                                            </div>
                                            <hr class="my-4" />
                                            <button type="submit" class="btn btn-primary btn-user">
												Confirmar
											</button>
											<a type="button" href="<?= base_url('carteira/id/'.$walletinfo['userid']); ?>" class="btn btn-danger btn-user">
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
		<script src="<?= base_url('assets/js/lr-maskvalid.js'); ?>" type="text/javascript"></script>
		<script src="<?= base_url('assets/js/sb-admin-2.min.js'); ?>"></script>
	</body>
</html>
