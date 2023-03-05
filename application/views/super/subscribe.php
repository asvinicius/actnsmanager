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

		<title>Inscrever</title>

		<link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		<link href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

	</head>
					<div class="container-fluid">
						<div class="d-sm-flex align-items-center justify-content-between mb-4">
							<h1 class="h3 mb-0 text-gray-800">Inscrever</h1>
							<a href="<?= base_url('usuario/id/'.$userid); ?>" class="btn btn-sm btn-danger shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Voltar</a>
						</div>
						<!--
						<form method="post" class="form-inline justify-content-md-end" style="margin-bottom:15px" action="<?= base_url('novotime/pesquisar');?>">
							<input type="hidden" name="userid" id="userid" value="<?= $userid ?>">
							<input class="form-control form-control-sm mr-sm-1 col-md-4" type="text" placeholder="Nome do time ou cartoleiro" aria-label="Pesquisar" name="searchlabel" id="searchlabel">
							<button class="btn btn-sm btn-primary shadow-sm" type="submit">Pesquisar</button>
						</form>
						-->
						<div class="row">
							<div class="col-xl-12 col-lg-12">
                                <div class="card shadow">
                                    <div class="card-header border-bottom">
                                        <div class="nav nav-pills nav-justified flex-column flex-xl-row nav-wizard" id="cardTab" role="tablist">
                                            <a class="nav-item nav-link <?php if($phase == 0){echo "active";}else{echo "disabled";} ?>" id="wizard1-tab" data-toggle="tab" role="tab" aria-controls="wizard1" aria-selected="true">
                                                <div class="wizard-step-text">
                                                    <div class="wizard-step-text-details">Seleção de times</div>
                                                </div>
                                            </a>
                                            <a class="nav-item nav-link <?php if($phase == 1){echo "active";}else{echo "disabled";} ?>" id="wizard2-tab" data-toggle="tab" role="tab" aria-controls="wizard2" aria-selected="true">
                                                <div class="wizard-step-text">
                                                    <div class="wizard-step-text-details">Seleção de rodadas</div>
                                                </div>
                                            </a>
                                            <a class="nav-item nav-link <?php if($phase == 2){echo "active";}else{echo "disabled";} ?>" id="wizard3-tab" data-toggle="tab" role="tab" aria-controls="wizard3" aria-selected="true">
                                                <div class="wizard-step-text">
                                                    <div class="wizard-step-text-details">Tipo de inscrição</div>
                                                </div>
                                            </a>
                                            <a class="nav-item nav-link <?php if($phase == 3){echo "active";}else{echo "disabled";} ?>" id="wizard4-tab" data-toggle="tab" role="tab" aria-controls="wizard4" aria-selected="true">
                                                <div class="wizard-step-text">
                                                    <div class="wizard-step-text-details">Fonte de pagamento</div>
                                                </div>
                                            </a>
                                            <a class="nav-item nav-link <?php if($phase == 4){echo "active";}else{echo "disabled";} ?>" id="wizard5-tab" data-toggle="tab" role="tab" aria-controls="wizard5" aria-selected="true">
                                                <div class="wizard-step-text">
                                                    <div class="wizard-step-text-details">Comprovante</div>
                                                </div>
                                            </a>
                                            <a class="nav-item nav-link <?php if($phase == 5){echo "active";}else{echo "disabled";} ?>" id="wizard6-tab" data-toggle="tab" role="tab" aria-controls="wizard6" aria-selected="true">
                                                <div class="wizard-step-text">
                                                    <div class="wizard-step-text-details">Sucesso</div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content" id="cardTabContent">
                                            <?php if ($alert != null) { ?>
    											<div class="alert alert-<?php echo $alert["class"]; ?>"> <?php echo $alert["message"]; ?> </div>
    										<?php } ?>
                                            <div class="tab-pane py-5 py-xl-10 fade <?php if($phase == 0){echo "show active";} ?>" id="wizard1" role="tabpanel" aria-labelledby="wizard1-tab">
                                                <div class="row justify-content-center">
                                                    <div class="col-xxl-6 col-xl-8">
                                                        <h3 class="text-primary">Passo 1</h3>
                                                        <h5 class="card-title">Seleção de times</h5>
										                <form action="<?= base_url('inscrever/rodadas'); ?>" method="post">
                                                            <div class="form-group">
                                                                <input type="hidden" id="userid" name="userid" value="<?= $userid; ?>">
                												<?php if($teams) { ?>
                													<?php foreach($teams as $team) { ?>
                														<div class="custom-control custom-checkbox">
                														    <input type="checkbox" class="custom-control-input" value="<?= $team->teamid; ?>" id="<?= $team->teamslug; ?>" name="teamcheck[]">
                															<label class="custom-control-label" for="<?= $team->teamslug; ?>"><?= $team->teamname; ?></label>
                														</div>
                													<?php } ?>
                												<?php } else { ?>
                													<div class="col-md-12 text-muted"><h6>Este usuário não possui times cadastrados!</h6></div>
                												<?php } ?>
                                                            </div>
                                                            <hr class="my-4" />
										    	            <a type="button" href="<?= base_url('usuario/id/'.$userid); ?>" class="btn btn-sm btn-danger shadow-sm"> Cancelar </a>
                                                            <button type="submit" class="btn btn-sm btn-primary shadow-sm"> Seguir </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane py-5 py-xl-10 fade <?php if($phase == 1){echo "show active";} ?>" id="wizard2" role="tabpanel" aria-labelledby="wizard2-tab">
                                                <div class="row justify-content-center">
                                                    <div class="col-xxl-6 col-xl-8">
                                                        <h3 class="text-primary">Passo 2</h3>
                                                        <h5 class="card-title">Seleção de rodadas</h5>
                                                        <form action="<?= base_url('inscrever/tipo'); ?>" method="post">
                                                            <div class="form-group">
                                                                <input type="hidden" id="userid" name="userid" value="<?= $userid; ?>">
                                                                <?php foreach($teamcheck as $teamitem) { ?>
                                                                    <input type="hidden" id="<?= $teamitem; ?>" name="teamcheck[]" value="<?= $teamitem; ?>">
                                                                <?php } ?>
                												<?php if($spins) { ?>
                												    <?php if($status['status_mercado'] == 1){ ?>
                    												    <div class="custom-control custom-checkbox custom-checkbox-inline">
                														    <input type="checkbox" class="custom-control-input" id="checkall" name="checkall">
                															<label class="custom-control-label" for="checkall"> Todas </label>
                														</div>
                													<?php } ?>
                													<?php foreach($spins as $spin) { ?>
                														<div class="custom-control custom-checkbox custom-checkbox-inline">
                														    <input type="checkbox" class="custom-control-input" value="<?= $spin->spinid; ?>" id="<?= $spin->spinid; ?>" name="spincheck[]"
                														        <?php if($spin->spinid == $status['rodada_atual']){ ?>
                    														        <?php if($status['status_mercado'] != 1){ ?>
                    														            disabled
                    														        <?php } ?>
                														        <?php } ?>
                														    >
                															<label class="custom-control-label" for="<?= $spin->spinid; ?>"><?= $spin->spinid; ?></label>
                														</div>
                													<?php } ?>
                												<?php } else { ?>
                													<div class="col-md-12 text-muted"><h6>Não existem mais rodadas disponíveis</h6></div>
                												<?php } ?>
                                                            </div>
                                                            <hr class="my-4" />
										    	            <a type="button" href="<?= base_url('usuario/id/'.$userid); ?>" class="btn btn-sm btn-danger shadow-sm"> Cancelar </a>
                                                            <button type="submit" class="btn btn-sm btn-primary shadow-sm"> Seguir </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane py-5 py-xl-10 fade <?php if($phase == 2){echo "show active";} ?>" id="wizard3" role="tabpanel" aria-labelledby="wizard3-tab">
                                                <div class="row justify-content-center">
                                                    <div class="col-xxl-6 col-xl-8">
                                                        <h3 class="text-primary">Passo 3</h3>
                                                        <h5 class="card-title">Tipo de inscrição</h5>
                                                        <form action="<?= base_url('inscrever/fonte'); ?>" method="post">
                                                            <div class="form-group">
                                                                <input type="hidden" id="userid" name="userid" value="<?= $userid; ?>">
                                                                <?php foreach($teamcheck as $teamitem) { ?>
                                                                    <input type="hidden" id="<?= $teamitem; ?>" name="teamcheck[]" value="<?= $teamitem; ?>">
                                                                <?php } ?>
                                                                <?php foreach($spincheck as $spinitem) { ?>
                                                                    <input type="hidden" id="<?= $spinitem; ?>" name="spincheck[]" value="<?= $spinitem; ?>">
                                                                <?php } ?>
            												    <div class="custom-control custom-radio custom-radio-inline">
                                    								<input id="paid" name="paidtype" type="radio" class="custom-control-input" value="2">
                                    								<label class="custom-control-label" for="paid">Pago</label>
                                    							</div>
                                    							<div class="custom-control custom-radio custom-radio-inline">
                                    								<input id="free" name="paidtype" type="radio" class="custom-control-input" value="1">
                                    								<label class="custom-control-label" for="free">Grátis</label>
                                    							</div>
                                                            </div>
                                                            <hr class="my-4" />
										    	            <a type="button" href="<?= base_url('usuario/id/'.$userid); ?>" class="btn btn-sm btn-danger shadow-sm"> Cancelar </a>
                                                            <button type="submit" class="btn btn-sm btn-primary shadow-sm"> Seguir </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane py-5 py-xl-10 fade <?php if($phase == 3){echo "show active";} ?>" id="wizard4" role="tabpanel" aria-labelledby="wizard4-tab">
                                                <div class="row justify-content-center">
                                                    <div class="col-xxl-6 col-xl-8">
                                                        <h3 class="text-primary">Passo 4</h3>
                                                        <h5 class="card-title">Fonte de pagamento</h5>
                                                        <form action="<?= base_url('inscrever/comprovante'); ?>" method="post">
                                                            <div class="form-group">
                                                                <input type="hidden" id="userid" name="userid" value="<?= $userid; ?>">
                                                                <input type="hidden" id="paidtype" name="paidtype" value="<?= $paidtype; ?>">
                                                                <?php foreach($teamcheck as $teamitem) { ?>
                                                                    <input type="hidden" id="<?= $teamitem; ?>" name="teamcheck[]" value="<?= $teamitem; ?>">
                                                                <?php } ?>
                                                                <?php foreach($spincheck as $spinitem) { ?>
                                                                    <input type="hidden" id="<?= $spinitem; ?>" name="spincheck[]" value="<?= $spinitem; ?>">
                                                                <?php } ?>
                                                                <div class="row small text-muted">
                                                                    <div class="col-sm-3 text-truncate"><em>Total da inscrição:</em></div>
                                                                    <div class="col"><strong>R$ <?php echo number_format($total, 2, ',', ''); ?></strong></div>
                                                                </div>
                                                                <div class="row small text-muted">
                                                                    <div class="col-sm-3 text-truncate"><em>Saldo disponível:</em></div>
                                                                    <div class="col"><strong>R$ <?php echo number_format($walletinfo['wallet_balance'], 2, ',', ''); ?></strong></div>
                                                                </div>
            												    <div class="custom-control custom-radio custom-radio-inline">
                                    								<input id="transfer" name="paidfont" type="radio" class="custom-control-input" value="2">
                                    								<label class="custom-control-label" for="transfer">Transferência</label>
                                    							</div>
                                    							<div class="custom-control custom-radio custom-radio-inline">
                                    								<input id="saldo" name="paidfont" type="radio" class="custom-control-input" value="1">
                                    								<label class="custom-control-label" for="saldo">Pagar com saldo</label>
                                    							</div>
                                                            </div>
                                                            <hr class="my-4" />
										    	            <a type="button" href="<?= base_url('usuario/id/'.$userid); ?>" class="btn btn-sm btn-danger shadow-sm"> Cancelar </a>
                                                            <button type="submit" class="btn btn-sm btn-primary shadow-sm"> Seguir </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane py-5 py-xl-10 fade <?php if($phase == 4){echo "show active";} ?>" id="wizard5" role="tabpanel" aria-labelledby="wizard5-tab">
                                                <div class="row justify-content-center">
                                                    <div class="col-xxl-6 col-xl-8">
                                                        <h3 class="text-primary">Passo 5</h3>
                                                        <h5 class="card-title">Anexar comprovante</h5>
                                                        <form action="<?= base_url('inscrever/finalizar'); ?>" method="post" enctype="multipart/form-data">
                                                            <div class="form-group">
                                                                <input type="hidden" id="userid" name="userid" value="<?= $userid; ?>">
                                                                <input type="hidden" id="paidtype" name="paidtype" value="<?= $paidtype; ?>">
                                                                <?php foreach($teamcheck as $teamitem) { ?>
                                                                    <input type="hidden" id="<?= $teamitem; ?>" name="teamcheck[]" value="<?= $teamitem; ?>">
                                                                <?php } ?>
                                                                <?php foreach($spincheck as $spinitem) { ?>
                                                                    <input type="hidden" id="<?= $spinitem; ?>" name="spincheck[]" value="<?= $spinitem; ?>">
                                                                <?php } ?>
                                                                <label class="small mb-1" for="attachment">Comprovante</label>
                                                                <input type="file" class="form-control-file form-control-user" id="attachment" name="attachment" required>
                                                            </div>
                                                            <hr class="my-4" />
										    	            <a type="button" href="<?= base_url('usuario/id/'.$userid); ?>" class="btn btn-sm btn-danger shadow-sm"> Cancelar </a>
                                                            <button type="submit" class="btn btn-sm btn-primary shadow-sm"> Seguir </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane py-5 py-xl-10 fade <?php if($phase == 5){echo "show active";} ?>" id="wizard5" role="tabpanel" aria-labelledby="wizard5-tab">
                                                <div class="row justify-content-center">
                                                    <div class="col-xxl-6 col-xl-8">
                                                        <h3 class="text-primary">Sucesso!</h3>
                                                        <h5 class="card-title">Inscrição realizada com sucesso</h5>
                                                        
                                                        <hr class="my-4" />
                                                        <div class="d-flex justify-content-between">
                                                            <a class="btn btn-primary btn-block" href="<?= base_url('rodadas'); ?>">Seguir</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div
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
		<script>
        $("#checkall").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
	</body>
</html>
