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

		<title>Métricas</title>

		<link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		<link href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

	</head>
					<div class="container-fluid">
						<div class="d-sm-flex align-items-center justify-content-between mb-4">
							<h1 class="h3 mb-0 text-gray-800">Métricas</h1>
							<!--
							<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
							    <i class="fas fa-download fa-sm text-white-50"></i> 
							    Generate Report
							</a>
							-->
						</div>
						<!--
						<div class="row">
                            <div class="col-xl-6 col-md-6 mb-4">
                                
                                <div class="card border-left-<?php if($json['status_mercado'] == 1){echo "success";}else{if($json['status_mercado'] == 2){echo "danger";}else{echo "warning";}} ?> shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-<?php if($json['status_mercado'] == 1){echo "success";}else{if($json['status_mercado'] == 2){echo "danger";}else{echo "warning";}} ?> text-uppercase mb-1">
                                                    <?php if($json['status_mercado'] == 1){ ?>
                                                        Mercado aberto
                                                    <?php } else { ?>
                                                        <?php if($json['status_mercado'] == 2){ ?>
                                                            Mercado fechado
                                                        <?php } else { ?>
                                                            Em manutenção
                                                        <?php } ?>
                                                    <?php } ?>
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    Rodada <?php echo $json['rodada_atual'] ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<div class="col-xl-6 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"> Solicitações </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?php if($numreq > 0){ ?>
                                                        <?php if($numreq == 1){ ?>
                                                            <?php echo $numreq; ?> nova
                                                        <?php } else { ?>
                                                            <?php echo $numreq; ?> novas
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        Nenhuma nova
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-file-medical fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
						-->
						<div class="row">
						    <div class="col-xl-12 col-lg-12">
    						    <?php if($contmetrics){ ?>
            						<div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">Bolão Acretinos</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-area">
                                                <canvas id="myAreaChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
						        <?php } ?>
    						    <?php if($balanceitem){ ?>
    						        <div class="card shadow mb-4">
        						        <div class="card-body">
        						            <table class="table table-sm table-hover">
                                				<thead>
                                					<tr>
                                						<th scope="col"><small><strong>ADM</strong></small></th>
                        								<th scope="col"><small><strong>Pend.</strong></small></th>
                        								<th scope="col"><small><strong>Conf.</strong></small></th>
                        								<th scope="col"><small><strong>Total</strong></small></th>
                                					</tr>
                                				</thead>
                                    			<tbody>
                                    			    <?php foreach($balanceitem as $bal){ ?>
                        								<tr>
                        									<td><small><?php echo $bal->supername ?></small></td>
                        									<td><small><?php echo "R$ ".number_format($bal->balancepend, 2, ',', '') ?></small></td>
                        									<td><small><?php echo "R$ ".number_format($bal->balanceconf, 2, ',', '') ?></small></td>
                        									<th scope="row"><small><strong><?php echo "R$ ".number_format($bal->balancetotal, 2, ',', '') ?></strong></small></th>
                        								</tr>
                                    			    <?php } ?>
                    						    </tbody>
                                			</table>
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
		<!-- <script src="<?= base_url('assets/js/demo/chart-area-demo.js'); ?>"></script> -->
		<script>
		    // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#858796';
            
            function number_format(number, decimals, dec_point, thousands_sep) {
              // *     example: number_format(1234.56, 2, ',', ' ');
              // *     return: '1 234,56'
              number = (number + '').replace(',', '').replace(' ', '');
              var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                  var k = Math.pow(10, prec);
                  return '' + Math.round(n * k) / k;
                };
              // Fix for IE parseFloat(0.55).toFixed(0) = 0;
              s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
              if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
              }
              if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
              }
              return s.join(dec);
            }
            
            // Area Chart Example
            var ctx = document.getElementById("myAreaChart");
            var myLineChart = new Chart(ctx, {
              type: 'line',
              data: {
                labels: [
                    <?php $compcount = count($contmetrics); ?>
                    <?php foreach($contmetrics as $comp){ ?>
                        <?php if($compcount > 1){ ?>
                            "<?= $comp->cm_spin ?>",
                        <?php } else { ?>
                            "<?= $comp->cm_spin ?>"
                        <?php } ?>
                        <?php $compcount--; ?>
                    <?php } ?>
                ],
                datasets: [{
                  label: "2020",
                  lineTension: 0,
                  backgroundColor: "rgba(230, 230, 230, 0.05)",
                  borderColor: "rgba(153, 0, 0, 0.5)",
                  pointRadius: 3,
                  pointBackgroundColor: "rgba(153, 0, 0, 0.5)",
                  pointBorderColor: "rgba(153, 0, 0, 0.5)",
                  pointHoverRadius: 3,
                  pointHoverBackgroundColor: "rgba(153, 0, 0, 0.5)",
                  pointHoverBorderColor: "rgba(153, 0, 0, 0.5)",
                  pointHitRadius: 10,
                  pointBorderWidth: 2,
                  data: [
                    <?php $compcount = count($contmetrics); ?>
                    <?php foreach($contmetrics as $comp){ ?>
                        <?php if($compcount > 1){ ?>
                            "<?= $comp->cm_teams ?>",
                        <?php } else { ?>
                            "<?= $comp->cm_teams ?>"
                        <?php } ?>
                        <?php $compcount--; ?>
                    <?php } ?>
                  ],
                },
                {
                  label: "2021",
                  lineTension: 0,
                  backgroundColor: "rgba(255, 242, 230 ,0.7)",
                  borderColor: "rgba(255, 229, 204, 0.7)",
                  pointRadius: 3,
                  pointBackgroundColor: "rgba(255, 176, 102, 1)",
                  pointBorderColor: "rgba(255, 176, 102, 1)",
                  pointHoverRadius: 3,
                  pointHoverBackgroundColor: "rgba(230, 111, 0, 1)",
                  pointHoverBorderColor: "rgba(230, 111, 0, 1)",
                  pointHitRadius: 10,
                  pointBorderWidth: 2,
                  data: [
                    <?php $compcount = count($contmetrics21); ?>
                    <?php foreach($contmetrics21 as $comp){ ?>
                        <?php if($compcount > 1){ ?>
                            "<?= $comp->cm_teams ?>",
                        <?php } else { ?>
                            "<?= $comp->cm_teams ?>"
                        <?php } ?>
                        <?php $compcount--; ?>
                    <?php } ?>
                  ],
                },
                {
                  label: "2022",
                  lineTension: 0,
                  backgroundColor: "rgba(204, 204, 255 ,0.7)",
                  borderColor: "rgba(51, 119, 255, 0.5)",
                  pointRadius: 3,
                  pointBackgroundColor: "rgba(51, 119, 255, 1)",
                  pointBorderColor: "rgba(51, 119, 255, 1)",
                  pointHoverRadius: 3,
                  pointHoverBackgroundColor: "rgba(0, 51, 153, 1)",
                  pointHoverBorderColor: "rgba(0, 51, 153, 1)",
                  pointHitRadius: 10,
                  pointBorderWidth: 2,
                  data: [
                    <?php $compcount = count($completed); ?>
                    <?php foreach($completed as $comp){ ?>
                        <?php if($compcount > 1){ ?>
                            "<?= $comp->numteams ?>",
                        <?php } else { ?>
                            "<?= $comp->numteams ?>"
                        <?php } ?>
                        <?php $compcount--; ?>
                    <?php } ?>
                  ],
                }],
              },
              options: {
                maintainAspectRatio: false,
                layout: {
                  padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                  }
                },
                scales: {
                  xAxes: [{
                    time: {
                      unit: 'date'
                    },
                    gridLines: {
                      display: false,
                      drawBorder: false
                    },
                    ticks: {
                      maxTicksLimit: 7
                    }
                  }],
                  yAxes: [{
                    ticks: {
                      maxTicksLimit: 5,
                      padding: 10,
                      // Include a dollar sign in the ticks
                      callback: function(value, index, values) {
                        return number_format(value);
                      }
                    },
                    gridLines: {
                      color: "rgb(234, 236, 244)",
                      zeroLineColor: "rgb(234, 236, 244)",
                      drawBorder: false,
                      borderDash: [2],
                      zeroLineBorderDash: [2]
                    }
                  }],
                },
                legend: {
                  display: false
                },
                tooltips: {
                  backgroundColor: "rgb(255,255,255)",
                  bodyFontColor: "#858796",
                  titleMarginBottom: 10,
                  titleFontColor: '#6e707e',
                  titleFontSize: 14,
                  borderColor: '#dddfeb',
                  borderWidth: 1,
                  xPadding: 15,
                  yPadding: 15,
                  displayColors: false,
                  intersect: false,
                  mode: 'index',
                  caretPadding: 10,
                  callbacks: {
                    label: function(tooltipItem, chart) {
                      var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                      return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
                    }
                  }
                }
              }
            });

		</script>
	</body>
</html>
