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

		<title>Recibos de transação</title>

		<link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		<link href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

	</head>
					<div class="container-fluid">
						<div class="d-sm-flex align-items-center justify-content-between mb-4">
							<h1 class="h3 mb-0 text-gray-800">Recibos de transação</h1>
						</div>
						<!--
						<form method="post" class="form-inline justify-content-sm-end justify-content-md-end justify-content-lg-end" style="margin-bottom:15px" action="<?= base_url('recibos/pesquisar');?>">
							<input class="form-control form-control-sm mr-sm-1 col-md-4" type="text" placeholder="Pesquisar" aria-label="Pesquisar" name="searchlabel" id="searchlabel">
							<button class="btn btn-sm btn-primary shadow-sm" type="submit">Pesquisar</button>
						</form>
						-->
						<?php if ($alert != null) { ?>
							<div class="alert alert-<?php echo $alert["class"]; ?>"> <?php echo $alert["message"]; ?> </div>
						<?php } ?>
						<div class="row">
						    <div class="col-xl-12 col-lg-12">
    						    <?php if($receipts){ ?>
    						        <div class="card shadow mb-4">
        						        <div class="card-body">
        						            <table class="table table-sm table-hover">
                                				<thead>
                                					<tr>
                                						<th scope="col">ID</th>
                                						<th scope="col"> </th>
                                						<th scope="col">Data</th>
                                						<th scope="col">Usuário</th>
                                						<th scope="col">Valor</th>
                                						<th scope="col">Tipo</th>
                                					</tr>
                                				</thead>
                                				<tbody>
                                					<?php foreach($receipts as $receipt){ ?>
                                						<tr>
                                							<td class="small"><?php echo $receipt->ftr_id ?></td>
                                							<td class="small">
                                							    <?php if($receipt->ftr_type == 1){ ?>
                                								    <i class="fas fa-fw fa-donate" style="color:green" title="Depósito" ></i>
                                							    <?php } ?>
                                							    <?php if($receipt->ftr_type == 2){ ?>
                                								    <i class="fas fa-fw fa-paper-plane" style="color:red" title="Saque" ></i>
                                							    <?php } ?>
                                							    <?php if($receipt->ftr_type == 3){ ?>
                                								    <i class="fas fa-fw fa-pen-nib" style="color:blue" title="Inscrição" ></i>
                                							    <?php } ?>
                                							    <?php if($receipt->ftr_type == 4){ ?>
                                								    <i class="fas fa-fw fa-hand-holding-usd" style="color:orange" title="Premiação" ></i>
                                							    <?php } ?>
                                							</td>
                                							<td class="small"><?php echo date('d/m/y', strtotime($receipt->ftr_date)) ?></td>
                                							<td class="small"><?php echo $receipt->username ?></td>
                                							<td class="small"><?php echo "R$ ".number_format($receipt->ftr_value, 2, ',', '') ?></td>
                                							<td class="small">
                                    							<?php if($receipt->ftr_mode == 0){ ?>
                                								    Transf.
                                							    <?php } ?>
                                							    <?php if($receipt->ftr_mode == 1){ ?>
                                								    Saldo
                                							    <?php } ?>
                            							    </td>
                                							<!--
                                							<td>
                                							    <?php if($user->userstatus == 1){ ?>
                                							        <a href="<?= base_url('usuarios/desativar/'.$user->userid); ?>" title="Desativar">
                                    								    <i class="fas fa-fw fa-power-off" style="color:green" title="Ativo" ></i>
                                    								</a>
                                							    <?php } else { ?>
                                							        <a href="<?= base_url('usuarios/ativar/'.$user->userid); ?>" title="Ativar">
                                    								    <i class="fas fa-fw fa-power-off" style="color:red" title="Inativo" ></i>
                                    								</a>
                                							    <?php } ?>
                                							</td>
                                							<td><?php echo $user->userphone ?></td>
                                							<td>
                                								<a href="<?= base_url('usuario/id/'.$user->userid); ?>" title="Ver detalhes" class="icon-primary">
                                								    <i class="fas fa-fw fa-external-link-alt"></i>
                                								</a>
                                								<a href="<?= base_url('editausuario/id/'.$user->userid); ?>" title="Editar" class="icon-info">
                                								    <i class="fas fa-fw fa-pen"></i>
                                								</a>
                                							</td>
                                							-->
                                						</tr>
                                					<?php } ?>
                                				</tbody>
                                			</table>
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
