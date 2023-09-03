<?php 
include('../conexao.php');

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_hoje = utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today')));

$id = $_GET['id'];

//BUSCAR AS INFORMAÇÕES DO PEDIDO
$res = $pdo->query("SELECT * from vendas where id = '$id' ");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$hora = $dados[0]['hora'];
$total_venda = $dados[0]['valor'];
$valor_recebido = $dados[0]['valor_recebido'];
$tipo_pgto = $dados[0]['forma_pgto'];
$status = $dados[0]['status'];
$troco = $dados[0]['troco'];
$data = $dados[0]['data'];
$desconto = $dados[0]['desconto'];
$operador = $dados[0]['operador'];
$cliente = $dados[0]['cliente'];

$nome_cliente = 'Não Informado';
$cpf_cliente = '';

$res = $pdo->query("SELECT * from clientes where id = '$cliente' ");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
if(@count($dados) > 0){
	$nome_cliente = $dados[0]['nome'];
	$cpf_cliente = $dados[0]['cpf'];
}



$data2 = implode('/', array_reverse(explode('-', $data)));

$res = $pdo->query("SELECT * from forma_pgtos where codigo = '$tipo_pgto' ");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$nome_pgto = $dados[0]['nome'];

$res = $pdo->query("SELECT * from usuarios where id = '$operador' ");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$nome_operador = $dados[0]['nome'];

?>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<?php if(@$_GET['imp'] != 'Não'){ ?>
<script type="text/javascript">
$(document).ready(function() {
    window.print();
    window.close();
});
</script>
<?php } ?>

<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

<style type="text/css">
* {
    margin: 0px;

    /*Espaçamento da margem da esquerda e da Direita*/
    padding: 0px;
    background-color: #ffffff;


}

.text {
    &-center {
        text-align: center;
    }
}

.printer-ticket {
    display: table !important;
    width: 100%;

    /*largura do Campos que vai os textos*/
    max-width: 400px;
    font-weight: light;
    line-height: 1.3em;

    /*Espaçamento da margem da esquerda e da Direita*/
    padding: 0px;
    font-family: TimesNewRoman, Geneva, sans-serif;

    /*tamanho da Fonte do Texto*/
    font-size: <?php echo $fonte_comprovante ?>px;



}

.th {
    font-weight: inherit;
    /*Espaçamento entre as uma linha para outra*/
    padding: 5px;
    text-align: center;
    /*largura dos tracinhos entre as linhas*/
    border-bottom: 1px dashed #000000;
}

.qtdun {
    position: absolute;
    left: 1px;
    margin-top: -16px;
}

.qtd {
    position: absolute;
    left: 12px;

}

.parentese {
    position: absolute;
    left: 23px;

}

.codigo {
    position: absolute;
    left: 50px;

}

.cod {
    position: absolute;
    left: 50px;
    margin-top: -22px;

}


.produto {
    position: absolute;
    left: 145px;
    margin-top: -29px;

}

.valorqtd {
	position: absolute;
    left: 350px;
    margin-top: -36px;

}

.valorun { 
    position: absolute;
    left: 280px;
    margin-top: -56px;
}

.x {
    position: absolute;
    left: 337px;
    margin-top: -47px;

}


.espaco2 {
    position: absolute;
    left: 140px;
}

.espaco3 {
    position: absolute;
    left: 270px;
}

.espaco4 {
    position: absolute;
    left: 340px;
}

.espaco5 {
    position: absolute;
	margin-top: 20px;
    left: -7px;
}

.th2 {
    font-weight: inherit;
    /*Espaçamento entre as uma linha para outra*/
    padding: 5px;
    text-align: center;
    /*largura dos tracinhos entre as linhas*/
}

.th3 {
    font-weight: inherit;
    /*Espaçamento entre as uma linha para outra*/
    padding: 5px;
    text-align: center;
    /*largura dos tracinhos entre as linhas*/
	border-bottom: 1px dashed #000000;
}
.info {
    font-weight: inherit;
    /*Espaçamento entre as uma linha para outra*/
    padding: 5px;
    /*largura dos tracinhos entre as linhas*/
    border-bottom: 1px dashed #000000;
}

.meu-espacamento {
    margin-top: -38px;
}
.meu-espacamento2 {
    margin-top: -10px;
}


.info2 {
    font-weight: inherit;
    /*Espaçamento entre as uma linha para outra*/
    padding: 5px;

}

.info3 {
    font-weight: inherit;
    /*Espaçamento entre as uma linha para outra*/
    padding: 5px;

}

.info4 {
    font-weight: inherit;
    /*Espaçamento entre as uma linha para outra*/
    padding: 5px;

}

.info5 {
    font-weight: inherit;
    /*Espaçamento entre as uma linha para outra*/
    padding: 5px;

}

.itens {
    font-weight: inherit;
    /*Espaçamento entre as uma linha para outra*/
    padding: 5px;

}


.valores {
    font-weight: inherit;
    /*Espaçamento entre as uma linha para outra*/
    padding: 2px 5px;

}


.cor {
    color: #000000;
}


.title {
    font-size: 12px;
    text-transform: uppercase;
    font-weight: bold;
}

/*margem Superior entre as Linhas*/
.margem-superior {
    padding-top: 5px;
}
</style>



<div class="printer-ticket">
    <div class="th title"><?php echo $nome_sistema ?></div>

    <div class="th">
        <?php echo $endereco_sistema ?> <br />
        <small><b>Contato:</b> <?php echo $telefone_sistema ?>
            <?php if($cnpj_sistema != ""){echo ' / <b>CNPJ </b>'. @$cnpj_sistema; } ?>
        </small>
    </div>



    <div class="th"><b>Cliente</b> <?php echo $nome_cliente ?> <?php if($cpf_cliente != ""){ ?><b>CPF:</b>
        <?php echo $cpf_cliente ?> <?php } ?>
        <br>
        </b> <b>Data:</b> <?php echo $data2 ?> <b>Hora:</b> <?php echo $hora ?>
    </div>

    <div class="th title">Comprovante de Venda</div>

    <div class="th2"><b>CUMPOM NÃO FISCAL</b></div>
    <div class="mt-3"></div>

    <div class="info">
        <b class="qtdun">| QTD |</b>
    </div>

    <div class="info1">
        <b class="cod">| COD |</b>
    </div>

    <div class="info2">
        <b class="produto">| PRODUTO |</b>
    </div>

    <div class="info3">
        <b class="valorqtd">| VL QTD |</b>
    </div>

    <div class="info4">
        <b class="x"> x </b>
    </div>

    <div class="info5">
        <b class="valorun">| VL UN |</b>
    </div>

    <div class="meu-espacamento"></div>

    <?php 
	$res = $pdo->query("SELECT * from itens_venda where venda = '$id' order by id asc");
		$dados = $res->fetchAll(PDO::FETCH_ASSOC);
		$linhas = count($dados);

		$sub_tot;
		for ($i=0; $i < count($dados); $i++) { 
			foreach ($dados[$i] as $key => $value) {
			}

			$id_produto = $dados[$i]['produto']; 
			$quantidade = $dados[$i]['quantidade'];
			$id_item= $dados[$i]['id'];
			$valor = $dados[$i]['valor_unitario'];

			$valorqtd = $quantidade * $valor;

			$res_p = $pdo->query("SELECT * from produtos where id = '$id_produto' ");
			$dados_p = $res_p->fetchAll(PDO::FETCH_ASSOC);
			$nome_produto = $dados_p[0]['nome'];  
			$codigo_produto = $dados_p[0]['codigo']; 
			$descricao = $dados_p[0]['descricao'];
			//$valor = $dados_p[0]['valor_venda'];
			
	

			?>

    <div class="row itens meu-espacamento2">
        <div align="left" class="col-9"> <b>(</b><span class="qtd"><?php echo $quantidade ?></span><span
                class="codigo"><?php echo $codigo_produto ?></span><span class="espaco"><b
                    class="parentese">)</b></span> <span class="espaco2"><?php echo $nome_produto ?></span>

        </div>

        <div class="espaco3">
            R$ <?php

				
			@$valor;
			@$sub_tot = @$sub_tot + @$valorqtd;
			$sub_total = $sub_tot;
				


			$sub_total = number_format( $sub_total , 2, ',', '.');
			$valor = number_format( $valor , 2, ',', '.');
			$total = number_format( $total_venda , 2, ',', '.');


			echo $valor;
		?>
        </div>

        <div class="espaco4">
            R$ <?php


				$valorqtd = number_format( $valorqtd , 2, ',', '.');
				

				echo $valorqtd;
		?>
        </div>
		<div class="espaco5">
            <b>DESCRIÇÃO:</b> <?php echo $descricao ?>
        </div>
		<div class="mt-3 th3"></div>
    </div>
	<div class="mt-2"></div>
    <?php } ?>

	<div class="row valores">
        <div class="col-6"><b>SUBTOTAL</b></div>
        <div class="col-6" align="right">R$ <?php echo @$sub_total?></div>
    </div>


    <div class="row valores">
        <div class="col-6"><b>DESCONTO</b></div>
        <div class="col-6" align="right"> <?php echo @$desconto ?></div>
    </div>



    <div class="row valores">
        <div class="col-6"><b>TOTAL PAGO</b></div>
        <div class="col-6" align="right">R$ <?php echo @$valor_recebido ?></div>
    </div>

    <div class="row valores">
        <div class="col-6"><b>TROCO</b></div>
        <div class="col-6" align="right">R$ <?php echo @$troco ?></div>
    </div>


    <div class="row valores">
        <div class="col-6"><b>TOTAL COMPRA</b></div>
        <div class="col-6" align="right">R$ <?php echo @$total ?></div>
    </div>

    <div class="th" style="margin-bottom: 10px"></div>

    <div class="row valores">
        <div class="col-6"><b>FORMA DE PAGAMENTO:</b> <?php echo @$nome_pgto ?></div>
  
        <div class="col-6" align="right"><b>VENDEDOR:</b> <?php echo @$nome_operador ?></div>
    </div>
    <div class="row valores">
        <div class="text-center" style="font-size: 8px;"><b>TROCA SOMENTE COM CUPOM FISCAL</b></div>
    </div>
	<div class="meu-espacamento2"></div>
    <div class="th" style="margin-bottom: 10px"></div>


    <div class="row valores">
        <div class="text-center"><b>DACOR TINTAS AUTOMOTIVAS AGRADECE A PREFERÊNCIA</b></div>
    </div>

    <div class="th" style="margin-bottom: 10px"></div>