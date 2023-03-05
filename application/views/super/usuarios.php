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

		<title>Usuários</title>

		<link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		<link href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

	</head>
					<div class="container-fluid">
						<div class="d-sm-flex align-items-center justify-content-between mb-4">
							<h1 class="h3 mb-0 text-gray-800">Usuários</h1>
							<a href="<?= base_url('novousuario'); ?>" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm">
							    <i class="fas fa-plus fa-sm text-white-50"></i> 
							    Novo usuário
							</a>
						</div>
						<form method="post" class="form-inline justify-content-sm-end justify-content-md-end justify-content-lg-end" style="margin-bottom:15px" action="<?= base_url('usuarios/pesquisar');?>">
							<input class="form-control form-control-sm mr-sm-1 col-md-4" type="text" placeholder="Pesquisar" aria-label="Pesquisar" name="searchlabel" id="searchlabel">
							<button class="btn btn-sm btn-primary shadow-sm" type="submit">Pesquisar</button>
						</form>
						<?php if ($alert != null) { ?>
							<div class="alert alert-<?php echo $alert["class"]; ?>"> <?php echo $alert["message"]; ?> </div>
						<?php } ?>
						<div class="row">
						    <div class="col-xl-12 col-lg-12">
    						    <?php if($users){ ?>
    						        <div class="card shadow mb-4">
        						        <div class="card-body">
        						            <table class="table table-hover table-responsive-sm">
                                				<tbody>
                                					<?php foreach($users as $user){ ?>
                                						<tr>
                                							<td>
                                							    <?php if($user->userstatus == 1){ ?>
                                							        <a href="<?= base_url('usuarios/desativar/'.$user->userid); ?>" title="Desativar">
                                    								    <i class="fas fa-fw fa-power-off" style="color:green" title="Ativo" ></i>
                                    								</a>
                                							    <?php } else { ?>
                                							        <a href="<?= base_url('usuarios/ativar/'.$user->userid); ?>" title="Ativar">
                                    								    <i class="fas fa-fw fa-power-off" style="color:red" title="Inativo" ></i>
                                    								</a>
                                							    <?php } ?>
                                							</td>
                                							<td>
                                							    <dd><?php echo $user->username ?></dd>
                                							    <dd><small><?php echo $user->userphone ?></small></dd>
                                							</td>
                                							<td>
                                								<a href="<?= base_url('usuario/id/'.$user->userid); ?>" title="Ver detalhes" class="icon-primary">
                                								    <i class="fas fa-fw fa-external-link-alt"></i>
                                								</a>
                                								<a href="<?= base_url('editausuario/id/'.$user->userid); ?>" title="Editar" class="icon-info">
                                								    <i class="fas fa-fw fa-pen"></i>
                                								</a>
                                								
                                							</td>
                                						</tr>
                                					<?php } ?>
                                				</tbody>
                                			</table>
                                			<hr>
                                            <p>Mostrando <?php echo count($users); ?> de <?= $itens; ?> usuários cadastrados</p>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <h4>Nenhum usuário registrado.</h4>
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
