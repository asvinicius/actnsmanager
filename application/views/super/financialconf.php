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

		<title>Solicitação financeira</title>

		<link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		<link href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

	</head>
					<div class="container-fluid">
						<div class="d-sm-flex align-items-center justify-content-between mb-4">
							<h1 class="h3 mb-0 text-gray-800">Solicitação de saque nº: <?= $foitem['fo_id']; ?></h1>
							<!--
							<a class="d-sm-inline-block btn btn-sm btn-primary shadow-sm" href="<?= 'https://portal.acretinos.com.br/assets/comprovantes/'.$foitem['fo_attach']; ?>" target="_blank" download>
							    <i class="fas fa-download fa-sm text-white-50"></i> 
							    Baixar anexo
							</a>
							-->
						</div>
						<?php if ($alert != null) { ?>
							<div class="alert alert-<?php echo $alert["class"]; ?>"> <?php echo $alert["message"]; ?> </div>
						<?php } ?>
						<div class="row">
						    <div class="col-xl-12 col-lg-12">
    						    <?php if($foitem){ ?>
    						        <div class="card shadow mb-4">
        						        <div class="card-body">
        						            <table class="table table-sm table-borderless table-hover">
                                				<thead>
                                					<tr>
                        								<th scope="col"><small>Usuário</small></small></th>
                        								<th scope="col"><small>PIX</small></th>
                        								<th scope="col"><small>Valor</small></th>
                                					</tr>
                                				</thead>
                                    			<tbody>
                    								<tr>
                    									<td><small><?php echo $foitem['username'] ?></small></td>
                    									<td><small><?php echo $foitem['userkey'] ?></small></td>
                    									<td><small><?php echo "R$ ".number_format($foitem['fo_value'], 2, ',', '') ?></small></td>
                    								</tr>
                    						    </tbody>
                                			</table>
                    						<?php if($foitem['fo_status'] == 1){ ?>
                        						<form action="<?= base_url('ordemfinanc/confsaque'); ?>" method="post" enctype="multipart/form-data">
                    						        <input type="hidden" id="fo_id" name="fo_id" value="<?= $foitem['fo_id'] ?>" />
                    						        <div class="form-group">
                                                        <label class="small mb-1" for="fo_attach">Anexe o comprovante</label>
                                                        <input type="file" class="form-control-file form-control-user" id="fo_attach" name="fo_attach" required>
                                                    </div>
        											<button type="submit" class="d-sm-inline-block btn btn-sm btn-success shadow-sm">
        												Confirmar
        											</button>
        											<a type="button" href="<?= base_url('ordemfinanc/id/'.$foitem['fo_id']); ?>" class="d-sm-inline-block btn btn-sm btn-danger shadow-sm">
        												Cancelar
        											</a>
        										</form>
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
