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

		<title>Rodadas</title>

		<link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		<link href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

	</head>
					<div class="container-fluid">
						<div class="d-sm-flex align-items-center justify-content-between mb-4">
							<h1 class="h3 mb-0 text-gray-800">Rodadas</h1>
						</div>
						<?php if ($alert != null) { ?>
							<div class="alert alert-<?php echo $alert["class"]; ?>"> <?php echo $alert["message"]; ?> </div>
						<?php } ?>
						<div class="row">
						    <div class="col-xl-12 col-lg-12">
    						    <?php if($rodadas){ ?>
    						        <div class="card shadow mb-4">
        						        <div class="card-body">
        						            <table class="table table-sm table-hover">
                                				<thead>
                                					<tr>
                                						<th scope="col"> </th>
                                						<th scope="col"> Rodada </th>
                                						<th scope="col"> Inscritos </th>
                                						<th scope="col"> Pagos </th>
                                						<th scope="col"> </th>
                                					</tr>
                                				</thead>
                                				<tbody>
                                					<?php foreach($rodadas as $spin){ ?>
                                						<tr>
                                						    <td title="<?php if($spin->status == 1){echo "Rodada aberta";}else{if($spin->status == 2){echo "Rodada em andamento";}else{echo "Rodada finalizada";}} ?>">
                                        						<?php if($spin->status == 1){ ?>
                                        						    <i class="fas fa-fw fa-lock-open" style="color:green" title="Rodada aberta" ></i>
                                								<?php } else { ?>
                                									<?php if($spin->status == 2){ ?>
                                        						        <i class="fas fa-fw fa-lock" style="color:orange" title="Rodada em andamento" ></i>
                                									<?php } else { ?>
                                        						        <i class="fas fa-fw fa-lock" style="color:red" title="Rodada finalizada" ></i>
                                									<?php } ?>
                                								<?php } ?>
                                							</td>
                                							<th scope="row"><?php echo $spin->spinid ?></th>
                                							<td><?php echo $spin->numteams ?></td>
                                							<td><?php echo $spin->paidteams ?></td>
                                							<td>
                                								<a href="<?= base_url('rodada/id/'.$spin->spinid); ?>" title="Ver detalhes" class="icon-primary">
                                								    <i class="fas fa-fw fa-external-link-alt"></i>
                                								</a>
                                							</td>
                                						</tr>
                                					<?php } ?>
                                				</tbody>
                                			</table>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <h4>Nenhuma rodada a ser exibida.</h4>
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
