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

		<title>Portal - Novo time</title>

		<link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		<link href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

	</head>
					<div class="container-fluid">
						<div class="d-sm-flex align-items-center justify-content-between mb-4">
							<h1 class="h3 mb-0 text-gray-800">Adicionar time</h1>
							<a href="<?= base_url('usuario/id/'.$userid); ?>" class="btn btn-sm btn-danger shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Voltar</a>
						</div>
						<form method="post" class="form-inline justify-content-md-end" style="margin-bottom:15px" action="<?= base_url('novotime/pesquisar');?>">
							<input type="hidden" name="userid" id="userid" value="<?= $userid ?>">
							<input class="form-control form-control-sm mr-sm-1 col-md-4" type="text" placeholder="Nome do time ou cartoleiro" aria-label="Pesquisar" name="searchlabel" id="searchlabel">
							<button class="btn btn-sm btn-primary shadow-sm" type="submit">Pesquisar</button>
						</form>
						<div class="row">
							<div class="col-xl-12 col-lg-12">
                                <div class="card shadow mb-4">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Times encontrados</h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if ($teams) { ?>
                							<table class="table table-sm table-hover">
                								<thead>
                									<th title="Escudo"></th>
                									<th title="Nome">Nome</th>
                									<th title="Cartoleiro">Cartoleiro</th>
                									<th title="Selecionar">Selecionar</th>
                								</thead>
                								<tbody>
                									<?php foreach ($teams as $team) { ?>
                										<tr>
                											<td><img src="<?php echo $team['url_escudo_svg'] ?>" width="20" alt="..."/></td>
                											<td><?php echo $team['nome'] ?></td>
                											<td><?php echo $team['nome_cartola'] ?></td>
                											<td>
                												<a href="<?= base_url('novotime/escolher/'.$userid."-".$team['time_id']) ?>" title="Selecionar time" onclick="return confirm('Confirma a adição do <?php echo $team['nome'] ?> do cartoleiro <?php echo $team['nome_cartola'] ?> nos seus times?');">
                													<i class="fas fa-fw fa-check"></i>
                												</a>
                											</td>
                										</tr>
                									<?php } ?>
                								</tbody>
                							</table>
                						<?php } else { ?>
                							<h4>Pesquise um time...</h4>
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
