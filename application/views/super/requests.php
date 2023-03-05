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

		<title>Solicitações</title>

		<link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		<link href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

	</head>
					<div class="container-fluid">
						<div class="d-sm-flex align-items-center justify-content-between mb-4">
							<h1 class="h3 mb-0 text-gray-800">Solicitações</h1>
						</div>
						<?php if ($alert != null) { ?>
							<div class="alert alert-<?php echo $alert["class"]; ?>"> <?php echo $alert["message"]; ?> </div>
						<?php } ?>
						<div class="row">
						    <div class="col-xl-6 col-lg-6">
						        <div class="card shadow mb-2">
						            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Inscrição</h6>
                                    </div>
    						        <div class="card-body">
    						            <div class="row justify-content-center">
                                            <div class="col-xxl-12 col-xl-12">
                                                <?php if($orders){ ?>
                                        			<table class="table table-sm table-hover">
                                        				<thead>
                                        					<tr>
                                        						<th scope="col">ID</th>
                                        						<th scope="col">Usuário</th>
                                        						<th scope="col">Valor</th>
                                        						<th scope="col"></th>
                                        					</tr>
                                        				</thead>
                                        				<tbody>
                                        					<?php foreach($orders as $order){ ?>
                                        						<tr class="<?php if($order->orderstatus == 1){echo "table-primary";} else {echo "table-success";} ?>">
                                        							<th scope="row" class="small"><?php echo $order->orderid ?></th>
                                        							<td class="small"><?php echo $order->username ?></td>
                                        							<td class="small"><?php echo "R$ ".number_format($order->orderprice, 2, ',', '') ?></td>
                                        							<td class="small">
                                        								<a href="<?= base_url('ordeminsc/inscricao/'.$order->orderid); ?>" title="Abrir solicitação">
                                        									<i class="fas fa-fw fa-external-link-alt" style="color:blue" title="Abrir solicitação" ></i>
                                        								</a>
                                        							</td>
                                        						</tr>
                                        					<?php } ?>
                                        				</tbody>
                                        			</table>
                                        	    <?php } else {echo "<h4>Nenhuma nova solicitação.</h4>";} ?>
                                            </div>
                                        </div>
                            		</div>
                                </div>
                            </div>
						    <div class="col-xl-6 col-lg-6">
						        <div class="card shadow mb-2">
						            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Financeira</h6>
                                    </div>
    						        <div class="card-body">
    						            <div class="row justify-content-center">
                                            <div class="col-xxl-12 col-xl-12">
                                                <?php if($financials){ ?>
                                        			<table class="table table-sm table-hover">
                                        				<thead>
                                        					<tr>
                                        						<th scope="col">ID</th>
                                        						<th scope="col">Usuário</th>
                                        						<th scope="col"></th>
                                        						<th scope="col">Valor</th>
                                        						<th scope="col"></th>
                                        					</tr>
                                        				</thead>
                                        				<tbody>
                                        					<?php foreach($financials as $finorder){ ?>
                                        						<tr class="<?php if($finorder->fo_status == 1){echo "table-primary";} else {echo "table-success";} ?>">
                                        							<th scope="row" class="small"><?php echo $finorder->fo_id ?></th>
                                        							<td class="small"><?php echo $finorder->username ?></td>
                                        							<td class="small">
                                        							    <?php if($finorder->fo_type == 1){ ?>
                                        							        <i class="fas fa-fw fa-plus" style="color:green" title="Depósito" ></i>
                                        							    <?php } else { ?>
                                        							        <i class="fas fa-fw fa-minus" style="color:red" title="Saque" ></i>
                                        							    <?php } ?>
                                        							</td>
                                        							<td class="small"><?php echo "R$ ".number_format($finorder->fo_value, 2, ',', '') ?></td>
                                        							<td class="small">
                                        								<a href="<?= base_url('ordemfinanc/id/'.$finorder->fo_id); ?>" title="Abrir solicitação">
                                        									<i class="fas fa-fw fa-external-link-alt" style="color:blue" title="Abrir solicitação" ></i>
                                        								</a>
                                        							</td>
                                        						</tr>
                                        					<?php } ?>
                                        				</tbody>
                                        			</table>
                                        	    <?php } else {echo "<h4>Nenhuma nova solicitação.</h4>";} ?>
                                            </div>
                                        </div>
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