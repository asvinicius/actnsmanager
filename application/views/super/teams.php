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

		<title>Portal - Times</title>

		<link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		<link href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

	</head>
					<div class="container-fluid">
						<div class="d-sm-flex align-items-center justify-content-between mb-4">
							<h1 class="h3 mb-0 text-gray-800">Times</h1>
							<!--
							<a href="<?= base_url('novotime/usuario/'.$user['userid']); ?>" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Novo time</a>
							-->
						</div>
						<form method="post" class="form-inline justify-content-sm-end justify-content-md-end justify-content-lg-end" style="margin-bottom:15px" action="<?= base_url('times/pesquisar');?>">
							<input class="form-control form-control-sm mr-sm-1 col-md-4" type="text" placeholder="Pesquisar" aria-label="Pesquisar" name="searchlabel" id="searchlabel">
							<button class="btn btn-sm btn-primary shadow-sm" type="submit">Pesquisar</button>
						</form>
						<?php if ($alert != null) { ?>
							<div class="alert alert-<?php echo $alert["class"]; ?>"> <?php echo $alert["message"]; ?> </div>
						<?php } ?>
						<div class="row">
							<div class="col-xl-12 col-lg-12">
                                <div class="card shadow mb-4">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Lista de times</h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if ($teams) { ?>
                							<table class="table table-sm table-hover">
                								<tbody>
                									<?php foreach ($teams as $team) { ?>
                										<tr>
                											<td><img src="<?php echo $team->teamshield ?>" width="20" alt="..."/></td>
                											<td>
                											    <dd><?php echo $team->teamname ?></dd>
                											    <dd><small><?php echo $team->teamcoach ?></small></dd>
                											</td>
                											<td>
                												<a href="<?= base_url('usuario/id/'.$team->teamuser); ?>" title="Ir para usuário" class="icon-success">
                													<i class="fas fa-fw fa-share-square"></i>
                												</a>
                												<a href="<?= base_url('times/atualizar/'.$team->teamid); ?>" title="Atualizar" class="icon-success">
                													<i class="fas fa-fw fa-redo"></i>
                												</a>
                												<a href="<?= base_url('times/remover/'.$team->teamid); ?>" title="Remover" class="icon-danger" onclick="return confirm('Tem certeza que deseja fazer isso?');">
                													<i class="fas fa-fw fa-trash"></i>
                												</a>
                											</td>
                										</tr>
                									<?php } ?>
                								</tbody>
                							</table>
                						<?php } else { ?>
                							<h4>Nenhum time registrado</h4>
                						<?php } ?>
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
