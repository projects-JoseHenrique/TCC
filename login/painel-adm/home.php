<?php 

require_once('../conexao.php');
require_once('verificar-permissao.php');

$saldoMesF = 0;
$totalVendasMF = 0;
$receberMesF = 0;
$pagarMesF = 0;

$hoje = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$dataInicioMes = $ano_atual."-".$mes_atual."-01";

	$query = $pdo->query("SELECT * from produtos");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$totalProdutos = @count($res);

	$query = $pdo->query("SELECT * from fornecedores");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$totalFornecedores = @count($res);

	$query = $pdo->query("SELECT * from produtos where estoque < estoque_min");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$totalEstoqueBaixo = @count($res);

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


	$query = $pdo->query("SELECT * from contas_pagar where vencimento = curDate() and pago != 'Sim'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$contas_pagar_hoje = @count($res);


	//produtos vencendo
	$query = $pdo->query("SELECT * from alerta_vencimentos where data_alerta <= curDate() ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$alerta_produtos = @count($res);


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



		$totalPagarM = 0;
		$query = $pdo->query("SELECT * from contas_pagar where data_pgto >= '$dataInicioMes' and data_pgto <= curDate() and pago = 'Sim'");
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
		$query = $pdo->query("SELECT * from contas_receber where data_pgto >= '$dataInicioMes' and data_pgto <= curDate() and pago = 'Sim'");
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
                                        <div class="h5 mb-0 font-weight-bold text-primary" ><?php echo @$totalProdutos?></div>
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
                                        <div class="h5 mb-0 font-weight-bold text-warning" ><?php echo @$totalEstoqueBaixo?></div>
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
                                        <div class="h5 mb-0 font-weight-bold text-danger" ><?php echo @$alerta_produtos?></div>
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
                                        <div class="h5 mb-0 font-weight-bold text-info" ><?php echo @$totalFornecedores?></div>
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
                                        <div class="h5 mb-0 font-weight-bold text-warning" ><?php echo @$contas_pagar_hoje?></div>
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
                                        <div class="h5 mb-0 font-weight-bold text-danger" ><?php echo @$contas_pagar_vencidas?></div>
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
                                        <div class="h5 mb-0 font-weight-bold text-warning" ><?php echo @$contas_receber_hoje?></div>
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
                                        <div class="h5 mb-0 font-weight-bold text-danger" ><?php echo @$contas_receber_vencidas?></div>
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
										R$ Receber Vencidas</div>
                                        <div class="h5 mb-0 font-weight-bold text-danger" ><?php echo @$contas_receber_vencidas_rs?></div>
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
										R$ Pagar Vencidas</div>
                                        <div class="h5 mb-0 font-weight-bold text-danger" ><?php echo @$contas_pagar_vencidas_rs?></div>
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
                                        <div class="h5 mb-0 font-weight-bold text-success" ><?php echo @$totalVendasDia?></div>
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
										R$ Vendas Hoje</div>
                                        <div class="h5 mb-0 font-weight-bold text-success" ><?php echo @$vendas_rs?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-archive-fill text-success h1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>	

                   
