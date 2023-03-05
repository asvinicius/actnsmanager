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

		<title>Lista da rodada</title>

		<link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		<link href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

	</head>
					<div class="container-fluid">
						<div class="d-sm-flex align-items-center justify-content-between mb-4">
							<h1 class="h3 mb-0 text-gray-800">Rodada <?= $spin ?></h1>
							<a href="<?= base_url('rodada/id/'.$spin); ?>" class="d-sm-inline-block btn btn-sm btn-danger shadow-sm">
							    <i class="fas fa-arrow-left fa-sm text-white-50"></i> 
							    Voltar
							</a>
						</div>
						<div class="row">
						    <div class="col-xl-12 col-lg-12">
    						    <?php if($regdata){ ?>
                					*R$ 10,00 - CADA TIME* <br /> <br />
                                    
                                    *INSCRIÇÕES CONFIRMADAS PARA A <?= $spin ?>ª RODADA DO BOLÃO ACRETINOS 2021* <br /> <br />
                                    
                                    <?php $aux = 0; ?>
                                    <?php foreach ($regdata as $simple) { ?>
                                        <?php $aux++; ?>
                                        <?php echo $aux." - ".$simple->teamcoach." - OK"; ?>
                                        <br />
                                    <?php }  ?>
                                    <br />
                                    *AS INSCRIÇÕES ENCERRAM EM <?= $day."/".$month."/".$status['fechamento']['ano']." ÀS ".$hour."h".$minute." (Brasília)." ?>*
                                    
                				<?php } else {echo "<h4>Nenhum time inscrito.</h4>";} ?>
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
