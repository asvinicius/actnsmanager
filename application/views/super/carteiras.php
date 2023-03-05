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

		<title>Usuários</title>

		<link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		<link href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

	</head>
					<div class="container-fluid">
						<div class="d-sm-flex align-items-center justify-content-between mb-4">
							<h1 class="h3 mb-0 text-gray-800">Carteiras</h1>
						</div>
						<?php if ($alert != null) { ?>
							<div class="alert alert-<?php echo $alert["class"]; ?>"> <?php echo $alert["message"]; ?> </div>
						<?php } ?>
						<div class="row">
						    <div class="col-xl-12 col-lg-12">
    						    <?php if($wallets){ ?>
    						        <div class="card shadow mb-4">
        						        <div class="card-body">
        						            <?php $itens = 0; ?>
        						            <table class="table table-sm table-borderless table-hover">
                                				<thead>
                                					<tr>
                                						<th scope="col">Nome</th>
                                						<th scope="col">Saldo</th>
                                						<th scope="col"></th>
                                					</tr>
                                				</thead>
                                				<tbody>
                                					<?php foreach($wallets as $walletinfo){ ?>
                                						<tr>
                                							<td><?php echo $walletinfo->username ?></td>
                                							<td>R$ <?php echo number_format($walletinfo->wallet_free, 2, ',', '.'); ?></td>
                                							<td>
                                								<a href="<?= base_url('usuario/id/'.$walletinfo->wallet_user); ?>" title="Ver detalhes" class="icon-primary">
                                								    <i class="fas fa-fw fa-external-link-alt"></i>
                                								</a>
                                							</td>
                                						</tr>
                                						<?php $itens += $walletinfo->wallet_free; ?>
                                					<?php } ?>
                                				</tbody>
                                			</table>
                                			<hr>
                                            <p>R$ <?php echo number_format($itens, 2, ',', '.'); ?> total</p>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <h4>Nenhum usuário registrado.</h4>
                                <?php } ?>
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
		<script src="<?= base_url('assets/vendor/chart.js/Chart.min.js'); ?>"></script>
	</body>
</html>
