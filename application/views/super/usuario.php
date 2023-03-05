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

		<title>Usuário</title>

		<link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		<link href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

	</head>
					<div class="container-fluid">
						<div class="d-sm-flex align-items-center justify-content-between mb-4">
							<h1 class="h3 mb-0 text-gray-800">Informações do usuário</h1>
						</div>
						<?php if ($alert != null) { ?>
							<div class="alert alert-<?php echo $alert["class"]; ?>"> <?php echo $alert["message"]; ?> </div>
						<?php } ?>
						<div class="row">
						    <div class="col-xl-4 col-lg-4">
						        <div class="card shadow mb-2">
						            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Dados do usuário</h6>
                                    </div>
    						        <div class="card-body">
    						            <div class="row justify-content-center">
                                            <div class="col-xxl-12 col-xl-12">
                                                <div class="row text-muted">
                                                    <div class="col-sm-3 text-truncate"><em>Nome:</em></div>
                                                    <div class="col"><strong><?= $userdata['username']; ?></strong></div>
                                                </div>
                                                <div class="row text-muted">
                                                    <div class="col-sm-3 text-truncate"><em>Telefone:</em></div>
                                                    <div class="col"><strong><?= $userdata['userphone']; ?></strong></div>
                                                </div>
                                                <div class="row text-muted">
                                                    <div class="col-sm-3 text-truncate"><em>E-mail:</em></div>
                                                    <div class="col"><strong><?= $userdata['useremail']; ?></strong></div>
                                                </div>
                                                <div class="row text-muted">
                                                    <div class="col-sm-3 text-truncate"><em>Chave PIX:</em></div>
                                                    <div class="col"><strong><?= $userdata['userkey']; ?></strong></div>
                                                </div>
                                                <hr class="my-4" />
                                                <div class="d-flex justify-content-between">
                                                    <a class="btn btn-sm btn-primary" type="button" href="<?= base_url('editausuario/id/'.$userdata['userid']); ?>">Editar</a>
                                                </div>
                                            </div>
                                        </div>
                            		</div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4">
						        <div class="card shadow mb-2">
						            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Carteira</h6>
                                    </div>
    						        <div class="card-body">
    						            <div class="row justify-content-center">
                                            <div class="col-xxl-12 col-xl-12">
                                                <div class="row text-muted">
                                                    <div class="col-sm-3 text-truncate"><em>Saldo total:</em></div>
                                                    <div class="col text-success"><strong>R$ <?php echo number_format($walletinfo['wallet_balance'], 2, ',', '.'); ?></strong></div>
                                                </div>
                                                <div class="row small text-muted">
                                                    <div class="col-sm-3 text-truncate"><em>Disponível para saque:</em></div>
                                                    <div class="col text-primary"><strong>R$ <?php echo number_format($walletinfo['wallet_free'], 2, ',', '.'); ?></strong></div>
                                                </div>
                                                <div class="row small text-muted">
                                                    <div class="col-sm-3 text-truncate"><em>Bônus:</em></div>
                                                    <div class="col text-info"><strong>R$ <?php echo number_format($walletinfo['wallet_gift'], 2, ',', '.'); ?></strong></div>
                                                </div>
                                                <hr class="my-4" />
                                                <div class="d-flex justify-content-between">
                                                    <a class="btn btn-sm btn-primary" type="button" href="<?= base_url('carteira/id/'.$userdata['userid']); ?>">Gerenciar</a>
                                                </div>
                                            </div>
                                        </div>
                            		</div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4">
						        <div class="card shadow mb-2">
						            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Times</h6>
                                    </div>
    						        <div class="card-body">
    						            <div class="row justify-content-center">
                                            <div class="col-xxl-12 col-xl-12">
                                                <?php if($teams){ ?>
                                                    <?php $cc = count($teams); ?>
                                                    <?php foreach($teams as $team){ ?>
                    									<li class="d-flex justify-content-between">
                    										<div>
                    											<h6 class="my-0"><?php echo $team->teamname ?></h6>
                    											<small class="text-muted"><?php echo $team->teamcoach ?></small>
                    											<br/>
											                    <a href="<?= base_url('usuario/atualizartime/'.$team->teamid); ?>">Atualizar</a>
                    										</div>
                    										<img src="<?php echo $team->teamshield ?>" width="40" alt="..."/>
                    									</li>
                    									<?php $cc --; ?>
                    									<?php if($cc != 0){ ?>
                    									    <hr />
                    									<?php } ?>
                    								<?php } ?>
                                                <?php } else { ?>
                                                    <h6>Nenhum time cadastrado.</h6>
                                                <?php } ?>
                                                <hr />
                                                <div class="justify-content-between">
                                                    <a class="btn btn-sm btn-success" type="button" href="<?= base_url('inscrever/usuario/'.$userdata['userid']); ?>">Inscrever</a>
                                                    <a class="btn btn-sm btn-primary" type="button" href="<?= base_url('novotime/usuario/'.$userdata['userid']); ?>">Novo time</a>
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
		</div>	
	
		<script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
		<script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
		<script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
		<script src="<?= base_url('assets/js/sb-admin-2.min.js'); ?>"></script>
		<script src="<?= base_url('assets/js/lr-maskvalid.js'); ?>" type="text/javascript"></script>
		<script src="<?= base_url('assets/js/lr-passconfirm.min.js'); ?>" type="text/javascript"></script>
	</body>
</html>