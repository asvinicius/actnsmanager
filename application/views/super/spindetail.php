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

		<title>Detalhe da rodada</title>

		<link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		<link href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

	</head>
					<div class="container-fluid">
						<div class="d-sm-flex align-items-center justify-content-between mb-4">
							<h1 class="h3 mb-0 text-gray-800">Rodada <?= $spin ?></h1>
							<a href="<?= base_url('rodada/lista/'.$spin); ?>" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm">
							    <i class="fas fa-list fa-sm text-white-50"></i> 
							    Lista
							</a>
						</div>
						<form method="post" class="form-inline justify-content-sm-end justify-content-md-end justify-content-lg-end" style="margin-bottom:15px" action="<?= base_url('rodada/pesquisar');?>">
							<input class="form-control form-control-sm mr-sm-1 col-md-4" type="text" placeholder="Pesquisar" aria-label="Pesquisar" name="searchlabel" id="searchlabel">
							<button class="btn btn-sm btn-primary shadow-sm" type="submit" name="spin" value="<?= $spin ?>">Pesquisar</button>
						</form>
						<?php if ($alert != null) { ?>
							<div class="alert alert-<?php echo $alert["class"]; ?>"> <?php echo $alert["message"]; ?> </div>
						<?php } ?>
						<div class="row">
						    <div class="col-xl-12 col-lg-12">
    						    <?php if($teams){ ?>
    						        <div class="card shadow mb-4">
        						        <div class="card-body">
        						            <table class="table table-sm table-borderless table-hover">
                                				<thead>
                                					<tr>
                                						<th scope="col"> </th>
                                						<th scope="col">Time</th>
                                						<th scope="col">Tipo</th>
                                						<th scope="col">Opc</th>
                                					</tr>
                                				</thead>
                                				<tbody>
                                					<?php foreach($teams as $team){ ?>
                                						<tr>
                                							<td><img src="<?php echo $team->teamshield ?>" width="20" alt="..."/></td>
                                							<td><?php echo $team->teamname ?></td>
                                							<td>
                        										<?php if($team->registrypaid == 1){ ?>
                        											Pago
                        										<?php } else { ?>
                        											Grátis
                        										<?php } ?>
                        									</td>
                        									<td>
                                							    <?php if($spindata['status'] == 1){ ?>
                                							        <a href="<?= base_url('rodada/remover/'.$spin.'-'.$team->teamid); ?>" title="Remover" onclick="return confirm('Tem certeza que deseja fazer isto?.');">
                                    								    <i class="fas fa-fw fa-trash" style="color:red" title="Remover" ></i>
                                    								</a>
                                							    <?php } else { ?>
                                								    <i class="fas fa-fw fa-trash" style="color:silver" title="Remover" ></i>
                                							    <?php } ?>
                                							</td>
                                						</tr>
                                					<?php } ?>
                                				</tbody>
                                			</table>
                                			<hr>
                                            <p>Mostrando <?php echo count($teams); ?> de <?= $spindata['numteams']; ?> times inscritos</p>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <h4>Nenhum time inscrito</h4>
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
