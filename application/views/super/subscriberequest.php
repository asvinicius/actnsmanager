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

		<title>Solicitação de Inscrição</title>

		<link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		<link href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

	</head>
					<div class="container-fluid">
						<div class="d-sm-flex align-items-center justify-content-between mb-4">
							<h1 class="h3 mb-0 text-gray-800">Solicitação nº: <?= $orderitem['orderid']; ?></h1>
							<a class="d-sm-inline-block btn btn-sm btn-primary shadow-sm" href="<?= 'https://portal.acretinos.com.br/assets/comprovantes/'.$orderitem['orderattachment']; ?>" target="_blank" download>
							    <i class="fas fa-download fa-sm text-white-50"></i> 
							    Baixar anexo
							</a>
						</div>
						<?php if ($alert != null) { ?>
							<div class="alert alert-<?php echo $alert["class"]; ?>"> <?php echo $alert["message"]; ?> </div>
						<?php } ?>
						<div class="row">
						    <div class="col-xl-12 col-lg-12">
    						    <?php if($oc_itens){ ?>
    						        <div class="card shadow mb-4">
        						        <div class="card-body">
        						            <table class="table table-sm table-borderless table-hover">
                                				<thead>
                                					<tr>
                                						<th scope="col">ID</th>
                        								<th scope="col">Time</th>
                        								<th scope="col">Produto</th>
                        								<th scope="col">Preço</th>
                                					</tr>
                                				</thead>
                                    			<tbody>
                        							<?php foreach($oc_itens as $oc_item){ ?>
                        								<tr>
                        									<th scope="row"><?php echo $oc_item->oc_id ?></th>
                        									<td><?php echo $oc_item->teamname ?></td>
                        									<td><?php echo $oc_item->productname ?></td>
                        									<td><?php echo "R$ ".number_format($oc_item->oc_price, 2, ',', '') ?></td>
                        								</tr>
                        							<?php } ?>
                        								<tr class="table-success">
                        									<td>-</td>
                        									<td>-</td>
                        									<td>-</td>
                        									<th scope="row" class="text-success"><?php echo "R$ ".number_format($orderitem['orderprice'], 2, ',', '') ?></th>
                        								</tr>
                    						    </tbody>
                                			</table>
                    						<?php if($orderitem['orderstatus'] == 1){ ?>
                        						<a class="d-sm-inline-block btn btn-sm btn-success shadow-sm" href="<?= base_url('ordeminsc/confirmar/'.$orderitem['orderid']); ?>" onclick="return confirm('Confirma o pagamento?\nAo confirmar um pagamento, esteja certo de que ele tenha de fato ocorrido.');">
                        						    <i class="fas fa-check fa-sm text-white-50"></i> 
                        						    Confirmar
                        						</a>
                        						<a type="button" href="<?= base_url('ordeminsc/recusar/'.$orderitem['orderid']); ?>" class="d-sm-inline-block btn btn-sm btn-danger shadow-sm">
    												Recusar
    											</a>
    											<a class="d-sm-inline-block btn btn-sm btn-primary shadow-sm" href="<?= base_url('ordeminsc/redirecionar/'.$orderitem['orderid']); ?>" >
                        						    <i class="fas fa-share-square fa-sm text-white-50"></i>
                        						</a>
                    						<?php } ?>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <h4>Sem itens encontrados.</h4>
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
