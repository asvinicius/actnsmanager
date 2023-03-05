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
							<a href="<?= base_url('usuario/id/'.$walletinfo['userid']); ?>" class="btn btn-sm btn-danger shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Voltar</a>
						</div>
						<div class="row">
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"> Saldo total </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"> R$ <?php echo number_format($walletinfo['wallet_balance'], 2, ',', '.'); ?> </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1"> Disponível para saque </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"> R$ <?php echo number_format($walletinfo['wallet_free'], 2, ',', '.'); ?> </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-unlock fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1"> Bonus </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"> R$ <?php echo number_format($walletinfo['wallet_gift'], 2, ',', '.'); ?> </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-tag fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-5">
								<div class="card shadow mb-4">
									<div class="card-body">
									    <a href="<?= base_url('depositar/id/'.$walletinfo['userid']); ?>" class="btn btn-sm btn-success btn-block shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Adicionar</a>
									    <a href="<?= base_url('sacar/id/'.$walletinfo['userid']); ?>" class="btn btn-sm btn-primary btn-block shadow-sm"><i class="fas fa-university fa-sm text-white-50"></i> Retirar</a>
									</div>
								</div>
							</div>
							
							<div class="col-xl-12 col-lg-12">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Histórico</h6>
                                        <div class="dropdown no-arrow">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="#">Ver tudo</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-sm table-hover">
                                            <?php if($orderinfo){ ?>
                								<thead>
                									<th title="ID da transação">ID</th>
                									<th title="Tipo">Tipo</th>
                									<th title="Data">Data</th>
                									<th title="Valor">Valor</th>
                									<th title="Status">Status</th>
                								</thead>
                								<tbody>
                								    <?php foreach ($orderinfo as $fo_item) { ?>
                    								    <tr>
                                                            <td>#<?php echo $fo_item->fo_id; ?></td>
                                                            <td>
                                                                <?php if($fo_item->fo_type == 1){ ?>
                                                                    Depósito
                                                                <?php } else { ?>
                                                                    Saque
                                                                <?php } ?>
                                                            </td>
                                                            <td><?php echo date('d/m/y', strtotime($fo_item->fo_date)) ?></td>
                                                            <td><?php echo "R$ ".number_format($fo_item->fo_value, 2, ',', '') ?></td>
                                                            <td>
                                                                <?php if($fo_item->fo_status == 1){ ?>
                                                                    <span class="badge badge-light"> Pendente </span>
                                                                <?php } else { ?>
                                                                    <?php if($fo_item->fo_status == 0){ ?>
                                                                        <span class="badge badge-success"> Concluído </span>
                                                                    <?php } else { ?>
                                                                        <span class="badge badge-danger"> Rejeitado </span>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                								</tbody>
                						    <?php } else { ?>
                						        <h4>Nenhuma movimentação financeira encontrada.</h4>
                						    <?php } ?>
							            </table>
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
	</body>
</html>
