<?php 

require_once('../conexao.php');
require_once('verificar-permissao.php');

$hoje = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$dataInicioMes = $ano_atual."-".$mes_atual."-01";

$entradasF = 0;
$saidasF = 0;
$saldoF = 0;
$valorMov = 0;
$descricaoMov = '';
$saldoMesF = 0;
$pagarMesF = 0;
$receberMesF = 0;
$totalVendasMF = 0;

$entradas = 0;
$saidas = 0;
$saldo = 0;
$query = $pdo->query("SELECT * from movimentacoes where data = curDate() order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){ 

	for($i=0; $i < $total_reg; $i++){
		foreach ($res[$i] as $key => $value){	}


			if($res[$i]['tipo'] == 'Entrada'){
				
				$entradas += $res[$i]['valor'];
			}else{
				
				$saidas += $res[$i]['valor'];
			}

			$saldo = $entradas - $saidas;

			$entradasF = number_format($entradas, 2, ',', '.');
			$saidasF = number_format($saidas, 2, ',', '.');
			$saldoF = number_format($saldo, 2, ',', '.');

			if($saldo < 0){
				$classeSaldo = 'text-danger';
			}else{
				$classeSaldo = 'text-success';
			}

			if($saldo < 0){
				$classeSaldo2 = 'danger';
			}else{
				$classeSaldo2 = 'success';
			}

		}

	}



	$query = $pdo->query("SELECT * from movimentacoes order by id desc limit 1");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$valorMov = $res[0]['valor'];
	$descricaoMov = $res[0]['descricao'];
	$tipoMov = $res[0]['tipo'];
	$valorMov = number_format($valorMov, 2, ',', '.');
	if($tipoMov == 'Entrada'){	
		$classeMov = 'text-success';
	}else{
		$classeMov = 'text-danger';
	}

	if($tipoMov == 'Entrada'){	
		$classeMov2 = 'success';
	}else{
		$classeMov2 = 'danger';
	}


	$query = $pdo->query("SELECT * from contas_receber where vencimento < curDate() and pago != 'Sim'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$contas_receber_vencidas = @count($res);

	$query = $pdo->query("SELECT * from produtos");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$totalProdutos = @count($res);

	$query = $pdo->query("SELECT * from produtos where estoque < estoque_min");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$totalEstoqueBaixo = @count($res);

	//produtos vencendo
	$query = $pdo->query("SELECT * from alerta_vencimentos where data_alerta <= curDate() ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$alerta_produtos = @count($res);

	$query = $pdo->query("SELECT * from fornecedores");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$totalFornecedores = @count($res);

	$contas_receber_vencidas_rs = 0;
	$query = $pdo->query("SELECT * from contas_receber where vencimento < curDate() and pago != 'Sim'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$contas_receber_vencidas = @count($res);
	if($contas_receber_vencidas > 0){ 
		for($i=0; $i < $contas_receber_vencidas; $i++){
			$contas_receber_vencidas_rs += $res[$i]['valor'];
		}
		$contas_receber_vencidas_rs = number_format($contas_receber_vencidas_rs, 2, ',', '.');
	}

	
	$query = $pdo->query("SELECT * from contas_receber where vencimento = curDate() and pago != 'Sim'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$contas_receber_hoje = @count($res);

	$contas_pagar_vencidas_rs = 0;
	$query = $pdo->query("SELECT * from contas_pagar where vencimento < curDate() and pago != 'Sim'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$contas_pagar_vencidas = @count($res);
	if($contas_pagar_vencidas > 0){ 
		for($i=0; $i < $contas_pagar_vencidas; $i++){
			$contas_pagar_vencidas_rs += $res[$i]['valor'];
		}
		$contas_pagar_vencidas_rs = number_format($contas_pagar_vencidas_rs, 2, ',', '.');
	}
	

	$query = $pdo->query("SELECT * from contas_receber where vencimento = curDate() and pago != 'Sim'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$contas_receber_hoje = @count($res);


	$query = $pdo->query("SELECT * from contas_pagar where vencimento < curDate() and pago != 'Sim'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$contas_pagar_vencidas = @count($res);


	$query = $pdo->query("SELECT * from contas_pagar where vencimento = curDate() and pago != 'Sim'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$contas_pagar_hoje = @count($res);





	$entradasM = 0;
	$saidasM = 0;
	$saldoM = 0;
	$query = $pdo->query("SELECT * from movimentacoes where data >= '$dataInicioMes' and data <= curDate() ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){ 

		for($i=0; $i < $total_reg; $i++){
			foreach ($res[$i] as $key => $value){	}


				if($res[$i]['tipo'] == 'Entrada'){

					$entradasM += $res[$i]['valor'];
				}else{

					$saidasM += $res[$i]['valor'];
				}

				$saldoMes = $entradasM - $saidasM;

				$entradasMF = number_format($entradasM, 2, ',', '.');
				$saidasMF = number_format($saidasM, 2, ',', '.');
				$saldoMesF = number_format($saldoMes, 2, ',', '.');

				if($saldoMesF < 0){
					$classeSaldoM = 'text-danger';
				}else{
					$classeSaldoM = 'text-success';
				}

			}

		}

		$vendas_rs = 0;
		$query = $pdo->query("SELECT * from vendas where data = curDate()");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$totalVendasDia = @count($res);
		if($totalVendasDia > 0){ 
			for($i=0; $i < $totalVendasDia; $i++){
				$vendas_rs += $res[$i]['valor'];
			}
			$vendas_rs = number_format($vendas_rs, 2, ',', '.');
		}



		$totalPagarM = 0;
		$query = $pdo->query("SELECT * from contas_pagar where data >= '$dataInicioMes' and data <= curDate() and pago != 'Sim'");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$pagarMes = @count($res);
		$total_reg = @count($res);
		if($total_reg > 0){ 

			for($i=0; $i < $total_reg; $i++){
				foreach ($res[$i] as $key => $value){	}

					$totalPagarM += $res[$i]['valor'];
				$pagarMesF = number_format($totalPagarM, 2, ',', '.');

			}
		}


		$totalReceberM = 0;
		$query = $pdo->query("SELECT * from contas_receber where data >= '$dataInicioMes' and data <= curDate() and pago != 'Sim'");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$receberMes = @count($res);
		$total_reg = @count($res);
		if($total_reg > 0){ 

			for($i=0; $i < $total_reg; $i++){
				foreach ($res[$i] as $key => $value){	}

					$totalReceberM += $res[$i]['valor'];
				$receberMesF = number_format($totalReceberM, 2, ',', '.');

			}
		}





		$totalVendasM = 0;
		$query = $pdo->query("SELECT * from vendas where data >= '$dataInicioMes' and data <= curDate() and status = 'Concluída'");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$total_reg = @count($res);
		if($total_reg > 0){ 

			for($i=0; $i < $total_reg; $i++){
				foreach ($res[$i] as $key => $value){	}

					$totalVendasM += $res[$i]['valor'];
				$totalVendasMF = number_format($totalVendasM, 2, ',', '.');

			}
		}

		?>





<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">


    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">


    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">


    <div class="container-fluid">
        <section id="minimal-statistics">
            <div class="row mb-2">
                <div class="col-12 mt-4 mb-1">
                    <h4 class="text-uppercase text-center font-weight-bold">Estatísticas do Sistema</h4>
                    <div class="mt-3"></div>

                </div>
            </div>

            <!-- Begin Page Content -->
            <div class="container-fluid">



                <!-- Content Row -->
                <div class="row">

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="font-weight-bold text-primary text-uppercase h7">
                                            Total de Produtos</div>
                                        <div class="h5 mb-0 font-weight-bold text-primary"><?php echo @$totalProdutos?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-archive-fill text-primary h1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="font-weight-bold text-warning text-uppercase h7">
                                            Estoque Baixo</div>
                                        <div class="h5 mb-0 font-weight-bold text-warning">
                                            <?php echo @$totalEstoqueBaixo?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-exclamation-octagon-fill text-warning h1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="font-weight-bold text-danger text-uppercase h7">
                                            Produtos Vencendo </div>
                                        <div class="h5 mb-0 font-weight-bold text-danger"><?php echo @$alerta_produtos?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-exclamation-triangle-fill text-danger h1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="font-weight-bold text-info text-uppercase h7">
                                            Total Fornecedores</div>
                                        <div class="h5 mb-0 font-weight-bold text-info"><?php echo @$totalFornecedores?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-person-check-fill text-info h1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="font-weight-bold text-warning text-uppercase h7">
                                            Contas à Pagar (Hoje)</div>
                                        <div class="h5 mb-0 font-weight-bold text-warning">
                                            <?php echo @$contas_pagar_hoje?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-calendar-minus text-warning h1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="font-weight-bold text-danger text-uppercase h7">
                                            Contas à Pagar Vencidas</div>
                                        <div class="h5 mb-0 font-weight-bold text-danger">
                                            <?php echo @$contas_pagar_vencidas?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-calendar-x-fill text-danger h1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="font-weight-bold text-warning text-uppercase h7">
                                            Contas Receber (Hoje)</div>
                                        <div class="h5 mb-0 font-weight-bold text-warning">
                                            <?php echo @$contas_receber_hoje?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-calendar-check-fill text-warning h1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="font-weight-bold text-danger text-uppercase h7">
                                            Contas à Receber Vencidas</div>
                                        <div class="h5 mb-0 font-weight-bold text-danger">
                                            <?php echo @$contas_receber_vencidas?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-calendar-x-fill text-danger h1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="font-weight-bold text-danger text-uppercase h7">
                                            Receber Vencidas</div>
                                        <div class="h5 mb-0 font-weight-bold text-danger">R$
                                            <?php echo @$contas_receber_vencidas_rs?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-cash-stack text-danger h1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="font-weight-bold text-danger text-uppercase h7">
                                            Pagar Vencidas</div>
                                        <div class="h5 mb-0 font-weight-bold text-danger">R$
                                            <?php echo @$contas_pagar_vencidas_rs?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-exclamation-triangle-fill text-danger h1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="font-weight-bold text-success text-uppercase h7">
                                            Total Vendas Dia</div>
                                        <div class="h5 mb-0 font-weight-bold text-success"><?php echo @$totalVendasDia?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-basket2-fill text-success h1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="font-weight-bold text-success text-uppercase h7">
                                            Vendas Hoje</div>
                                        <div class="h5 mb-0 font-weight-bold text-success">R$ <?php echo @$vendas_rs?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-archive-fill text-success h1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="font-weight-bold text-success text-uppercase h7">
                                            Entradas do Dia</div>
                                        <div class="h5 mb-0 font-weight-bold text-success">R$ <?php echo @$entradasF?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-archive-fill text-success h1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="font-weight-bold text-success text-uppercase h7">
                                            Saídas do Dia</div>
                                        <div class="h5 mb-0 font-weight-bold text-success"><?php echo @$saidasF?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-archive-fill text-success h1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-<?php echo $classeSaldo2 ?> shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="font-weight-bold  <?php echo $classeSaldo ?> text-uppercase h7">
                                            Saldo do dia</div>
                                        <div><span class=" font-weight-bold  <?php echo $classeSaldo ?>">R$
                                                <?php echo @$saldoF ?></span></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-cash <?php echo $classeSaldo ?> fs-1 float-start"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-<?php echo $classeMov2 ?> shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="font-weight-bold <?php echo $classeMov ?> text-uppercase h7">
                                            Movimentações</div>
                                        <div><span class="  font-weight-bold <?php echo $classeMov ?>">R$
                                                <?php echo @$valorMov ?></span></div>
                                        <div><span class="font-weight-bold <?php echo $classeMov ?>">
                                                OBS:<?php echo @$descricaoMov ?></span></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-cash <?php echo $classeMov ?> fs-1 float-start"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>












        </section>


        <section id="stats-subtitle">
            <div class="row mb-2">
                <div class="col-12 mt-3 mb-1">
                    <h4 class="text-uppercase">Estatísticas Mensais</h4>

                </div>
            </div>

            <div class="row mb-4">

            
				<div class="col-xl-6 col-md-12">
                    <div class="card overflow-hidden">
                        <div class="card-content">
                            <div class="card-body cleartfix ">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="font-weight-bold <?php echo $classeSaldoM ?> text-uppercase h7">
                                            Saldo Total</div>
                                        <div class="h5 mb-0 font-weight-bold <?php echo $classeSaldoM ?>">R$ <?php echo @$saldoMesF?></div>
                                    </div>
                                    <div class="col-auto">
                                    <span  class="font-weight-bold text-uppercase <?php echo $classeSaldoM ?> ">Total Arrecado este Mês</span>
                                        <i class="bi bi-archive-fill <?php echo $classeSaldoM ?> h1"></i>
                                        

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                


				
                <div class="col-xl-6 col-md-12">
                    <div class="card overflow-hidden">
                        <div class="card-content">
                            <div class="card-body cleartfix ">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="font-weight-bold text-warning text-uppercase h7">
                                            Contas à Pagar</div>
                                            
                                        <div class="h5 mb-0 font-weight-bold text-warning">R$ <?php echo @$pagarMesF?></div>
                                    </div>
                                    <div class="col-auto">
                                    <span class="text-warning font-weight-bold text-uppercase">Total de <?php echo $pagarMes ?> Contas no Mês</span>
                                        <i class="bi bi-calendar2-check text-warning h1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                </div>

                
                
            </div>

            

            <div class="row mb-4">

            <div class="col-xl-6 col-md-12">
                    <div class="card overflow-hidden">
                        <div class="card-content">
                            <div class="card-body cleartfix ">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="font-weight-bold text-warning text-uppercase h7">
                                            Contas à Pagar</div>
                                            
                                        <div class="h5 mb-0 font-weight-bold text-warning">R$ <?php echo @$pagarMesF?></div>
                                    </div>
                                    <div class="col-auto">
                                    <span class="text-warning font-weight-bold text-uppercase">Total de <?php echo $pagarMes ?> Contas no Mês</span>
                                        <i class="bi bi-calendar2-check text-warning h1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                </div>
            
<div class="col-xl-6 col-md-12">
    <div class="card overflow-hidden">
        <div class="card-content">
            <div class="card-body cleartfix ">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="font-weight-bold text-info text-uppercase h7">
                        Contas à Receber</div>
                        <div class="h5 mb-0 font-weight-bold text-info">R$ <?php echo @$totalVendasMF?></div>
                    </div>
                    <div class="col-auto">
                    <span  class="font-weight-bold text-uppercase text-info ">Total de vendas  no Mês</span>

                        <i class="bi bi-archive-fill text-info h1"></i>
                        

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





</div>



        </section>

        <section id="stats-subtitle">
            <div class="row mb-2">
                <div class="col-12 mt-3 mb-1">
                    <h4 class="text-uppercase">Modelo de Gráficos</h4>

                </div>
            </div>



            <style type="text/css">
            #principal {
                width: 100%;
                height: 100%;
                margin-left: 10px;
                font-family: Verdana, Helvetica, sans-serif;
                font-size: 14px;

            }

            #barra {
                margin: 0 2px;
                vertical-align: bottom;
                display: inline-block;
                padding: 5px;
                text-align: center;

            }

            .cor1,
            .cor2,
            .cor3,
            .cor4,
            .cor5,
            .cor6,
            .cor7,
            .cor8,
            .cor9,
            .cor10,
            .cor11,
            .cor12 {
                color: #FFF;
                padding: 5px;
            }

            .cor1 {
                background-color: #FF0000;
            }

            .cor2 {
                background-color: #0000FF;
            }

            .cor3 {
                background-color: #FF6600;
            }

            .cor4 {
                background-color: #009933;
            }

            .cor5 {
                background-color: #FF0000;
            }

            .cor6 {
                background-color: #0000FF;
            }

            .cor7 {
                background-color: #FF6600;
            }

            .cor8 {
                background-color: #009933;
            }

            .cor9 {
                background-color: #FF0000;
            }

            .cor10 {
                background-color: #0000FF;
            }

            .cor11 {
                background-color: #FF6600;
            }

            .cor12 {
                background-color: #009933;
            }
            </style>

            <div id="principal">
                <p>Vendas no Ano de <?php echo $ano_atual ?></p>
                <?php
// definindo porcentagem
//BUSCAR O TOTAL DE VENDAS POR MES NO ANO
$total  = 12; // total de barras
for($i=1; $i<13; $i++){
	

$dataMesInicio = $ano_atual."-".$i."-01";
$dataMesFinal = $ano_atual."-".$i."-31";
$totalVenM = 0;

		$query = $pdo->query("SELECT * from vendas where data >= '$dataMesInicio' and data <= '$dataMesFinal' and status = 'Concluída'");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$total_vendas_mes = @count($res);
		$totalValor = 0;
		$totalValorF = number_format($totalValor, 2, ',', '.');
		for($i2=0; $i2 < $total_vendas_mes; $i2++){
						foreach ($res[$i2] as $key => $value){	}

		
			$totalValor += $res[$i2]['valor'];
			$totalValorF = number_format($totalValor, 2, ',', '.');
			$altura_barra = $totalValor / 100;

		}


		if($i < 10){
			$texto = '0'.$i .'/'.$ano_atual;
		}else{
			$texto = $i .'/'.$ano_atual;
		}
		
			
		?>


                <div id="barra">
                    <div class="cor<?php echo $i ?>" style="height:<?php echo $altura_barra + 25 ?>px">
                        <?php echo $totalValorF ?> </div>
                    <div><?php echo $texto ?></div>
                </div>

                <?php }?>

            </div>



        </section>

        <!DOCTYPE html>
<html>

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.2/Chart.min.js"></script>
</head>

<body>
    <div class="container">
        <h2>Vendas por Mês do ano de <?php echo $ano_atual ?></h2>

        <div>
            <canvas id="valorChart"></canvas>
        </div>

        <div>
            <canvas id="quantidadeChart"></canvas>
        </div>

        <?php
        // Ano atual (substitua pelo ano desejado)
        $ano_atual = date("Y");

        // Inicialize variáveis
        $total_vendas = 0;
        $total_valor_arrecadado = 0;
        ?>

        <script>
            var ctxValor = document.getElementById("valorChart").getContext("2d");
            var ctxQuantidade = document.getElementById("quantidadeChart").getContext("2d");

            var valorChart = new Chart(ctxValor, {
    type: "bar", // Gráfico de barras
    data: {
        labels: [
            "Janeiro",
            "Fevereiro",
            "Março",
            "Abril",
            "Maio",
            "Junho",
            "Julho",
            "Agosto",
            "Setembro",
            "Outubro",
            "Novembro",
            "Dezembro"
        ],
        datasets: [{
            label: "Vendas em Reais",
            data: [
                <?php
                for ($i = 1; $i <= 12; $i++) {
                    $dataMesInicio = $ano_atual . "-" . $i . "-01";
                    $dataMesFinal = $ano_atual . "-" . $i . "-31";

                    $query = $pdo->query("SELECT * from vendas where data >= '$dataMesInicio' and data <= '$dataMesFinal' and status = 'Concluída'");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    $total_vendas_mes = @count($res);

                    $totalValor = 0;

                    for ($i2 = 0; $i2 < $total_vendas_mes; $i2++) {
                        $totalValor += $res[$i2]['valor'];
                    }

                    echo $totalValor;

                    if ($i != 12) {
                        echo ",";
                    }

                    // Atualize o total de vendas e o valor arrecadado
                    $total_vendas += $total_vendas_mes;
                    $totalValorF = number_format($totalValor, 2, ',', '.');
                }
                ?>
            ],
            backgroundColor: [
                "rgba(0, 255, 0, 0.6)",
                "rgba(0, 255, 0, 0.6)",
                "rgba(0, 255, 0, 0.6)",
                "rgba(0, 255, 0, 0.6)",
                "rgba(0, 255, 0, 0.6)",
                "rgba(0, 255, 0, 0.6)",
                "rgba(0, 255, 0, 0.6)",
                "rgba(0, 255, 0, 0.6)",
                "rgba(0, 255, 0, 0.6)",
                "rgba(0, 255, 0, 0.6)",
                "rgba(0, 255, 0, 0.6)",

            ]
        }]
    },
    options: {
        scales: {
            x: {
                min: 0, // Defina o valor mínimo do eixo x
                max: 11, // Defina o valor máximo do eixo x (0 a 11 representa os meses de janeiro a dezembro)
            },
            y: {
                beginAtZero: true
            }
        }
    }
    
});


</script>

<p class="rodape"><span class="info">Total de Vendas do ano de <?php echo $ano_atual ?></span>: <span class="dinheiro">R$ <?php echo $total_vendas ?></span></p>
        <style>
            .rodape {
                margin-left: 48px;
                font-family: 'Courier New', Courier, monospace;
                font-size: 18px;
                position: absolute;
                margin-bottom: 20px;
            }

            .info {
                font-weight: bold;
                text-transform: uppercase;
            }

            .dinheiro {
                font-weight: bold;
                color: #0000FF;
            }
        </style>
        

</body>

</html>

