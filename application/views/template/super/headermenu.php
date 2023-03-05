<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
ini_set("display_errors", 0 );
?>
<!DOCTYPE html>
<html lang="pt">

	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">

		<link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		<link href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

	</head>

	<body class="page-top">
		<div id="wrapper">
			<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion toggled" id="accordionSidebar">
				<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url(); ?>">
					<div class="sidebar-brand-icon">
						<i class="fas fa-home"></i>
					</div>
					<div class="sidebar-brand-text mx-3">
						PORTAL
					</div>
				</a>
				<hr class="sidebar-divider my-0">
				<li class="nav-item <?php if($info['pageid'] == 1){echo 'active';} ?>">
					<a class="nav-link" href="<?= base_url('solicitacoes'); ?>">
						<i class="fas fa-fw fa-file-medical"></i>
						<span>Solicitações</span>
					</a>
				</li>
				<li class="nav-item <?php if($info['pageid'] == 2){echo 'active';} ?>">
					<a class="nav-link" href="<?= base_url('rodadas'); ?>">
						<i class="fas fa-fw fa-list-ol"></i>
						<span>Rodadas</span>
					</a>
				</li>
				<li class="nav-item <?php if($info['pageid'] == 3){echo 'active';} ?>">
					<a class="nav-link" href="<?= base_url('usuarios'); ?>">
						<i class="fas fa-fw fa-users"></i>
						<span>Usuários</span>
					</a>
				</li>
				<li class="nav-item <?php if($info['pageid'] == 7){echo 'active';} ?>">
					<a class="nav-link" href="<?= base_url('carteiras'); ?>">
						<i class="fas fa-fw fa-wallet"></i>
						<span>Carteira</span>
					</a>
				</li>
				<li class="nav-item <?php if($info['pageid'] == 4){echo 'active';} ?>">
					<a class="nav-link" href="<?= base_url('times'); ?>">
						<i class="fas fa-fw fa-list"></i>
						<span>Times</span>
					</a>
				</li>
				<li class="nav-item <?php if($info['pageid'] == 5){echo 'active';} ?>">
					<a class="nav-link" href="<?= base_url('metricas'); ?>">
						<i class="fas fa-fw fa-chart-area"></i>
						<span>Métricas</span>
					</a>
				</li>
				<li class="nav-item <?php if($info['pageid'] == 6){echo 'active';} ?>">
					<a class="nav-link" href="<?= base_url('recibos'); ?>">
						<i class="fas fa-fw fa-receipt"></i>
						<span>Transações</span>
					</a>
				</li>
			</ul>
			<div id="content-wrapper" class="d-flex flex-column">
				<div id="content">
					<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
						<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
							<i class="fa fa-bars"></i>
						</button>
						<ul class="navbar-nav ml-auto">
							<li class="nav-item dropdown no-arrow mx-1">
								<a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="fas fa-bell fa-fw"></i>
									<span class="badge badge-danger badge-counter"><?php if($info['countnotify'] > 0){echo $info['countnotify'];}?></span>
								</a>
								<div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
									<h6 class="dropdown-header">
										Notificações
									</h6>
									<?php if($info['notifications']){ ?>
										<?php foreach($info['notifications'] as $notify){ ?>
											<a class="dropdown-item d-flex align-items-center" href="<?= base_url('notificacoes/id/'.$notify->sn_id); ?>">
												<div class="mr-3">
													<div class="icon-circle bg-success">
														<i class="fas fa-check text-white"></i>
													</div>
												</div>
												<div>
													<div class="small text-gray-500">
														<?= date('d/m/Y H:i', strtotime($notify->sn_date)); ?>
													</div>
													<span class="font-weight-bold"><?= $notify->sn_description; ?></span>
												</div>
											</a>
										<?php } ?>
									<?php } else { ?>
										<div class="dropdown-item d-flex align-items-center">
											<span class="font-weight-bold">Você não tem novas notificações!</span>
										</div>
									<?php } ?>
									<a class="dropdown-item text-center small text-gray-500">
									</a>
									<!--
									<a class="dropdown-item text-center small text-gray-500" href="<?= base_url('#'); ?>">
										Ver todas as notificações
									</a>
									-->
								</div>
							</li>
							<!--
							<li class="nav-item no-arrow mx-1">
								<a class="nav-link " title="Carrinho" href="<?= base_url('carrinho'); ?>" id="messagesDropdown">
									<i class="fas fa-shopping-cart fa-fw"></i>
									<span class="badge badge-danger badge-counter"><?php if($info['countcart'] > 0){echo $info['countcart'];}?></span>
								</a>
							</li>
							<li class="nav-item no-arrow mx-1">
								<a class="nav-link " title="Inscrições" href="#" id="messagesDropdown">
									<i class="fas fa-history fa-fw"></i>
								</a>
							</li>
							-->
							<div class="topbar-divider d-none d-sm-block"></div>
							<li class="nav-item dropdown no-arrow">
								<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
									<span class="mr-2 d-none d-lg-inline text-gray-600 small">
										<?= $info['userlogged']['username']; ?>
									</span>
									<img class="img-profile rounded-circle" src="<?= base_url('assets/img/logomini.png'); ?>">
								</a>
								<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
									
									<!--
									<a class="dropdown-item" href="<?= base_url('perfil'); ?>">
										<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
										Perfil
									</a>
    									<a class="dropdown-item" href="<?= base_url('termos'); ?>" target="_blank">
    										<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
    										Termos e condições
    									</a>
    									<div class="dropdown-divider"> </div>
									-->
									<a class="dropdown-item" href="<?= base_url('login/signout'); ?>">
										<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
										Sair
									</a>
								</div>
							</li>
						</ul>
					</nav>

		
</html>
