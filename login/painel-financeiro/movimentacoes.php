<?php 
$pag = 'movimentacoes';
@session_start();

require_once('../conexao.php');
require_once('verificar-permissao.php');

?>
<style>
#example {
    border-collapse: collapse;
    /* Mescla as bordas das células */
}

#example th,
#example td {
    border-left: 1px solid #ccc;
    /* Adiciona uma borda esquerda às células */
    border-right: 1px solid #ccc;
    /* Adiciona uma borda direita às células */
    padding: 8px;
    /* Adicione um espaçamento interno para melhor aparência */
    border: 2px solid black;

}
</style>

<div class="mt-4" style="margin-right:25px">
	<?php 
	$query = $pdo->query("SELECT * from movimentacoes order by id desc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){ 
		?>
		<small>
			<table id="example" class="table table-hover my-4" style="width:100%">
				<thead>
					<tr class="bg-success">
						<th class="text-white text-center">Tipo</th>
						<th class="text-white text-center">Descrição</th>
						<th class="text-white text-center">Valor</th>
						<th class="text-white text-center">Usuário</th>
						<th class="text-white text-center">Data</th>
						
					</tr>
				</thead>
				<tbody>

					<?php 
					for($i=0; $i < $total_reg; $i++){
						foreach ($res[$i] as $key => $value){	}


							//BUSCAR OS DADOS DO USUARIO
							$id_usu = $res[$i]['usuario'];
						$query_f = $pdo->query("SELECT * from usuarios where id = '$id_usu'");
						$res_f = $query_f->fetchAll(PDO::FETCH_ASSOC);
						$total_reg_f = @count($res_f);
						if($total_reg_f > 0){ 
							$nome_usuario = $res_f[0]['nome'];
							
						}


						if($res[$i]['tipo'] == 'Entrada'){
							$classe = 'text-success';
							
						}else{
							$classe = 'text-danger';
							
						}


						
						?>

						<tr>
							<td  class="text-center">								<i class="bi bi-square-fill <?php echo $classe ?>"></i> 
								<span class="d-none"><b><?php echo $res[$i]['tipo'] ?></b></span>
							</td>

							<td  class="text-center"><b><?php echo $res[$i]['descricao'] ?></b></td>
							<td  class="text-center"><b>R$ <?php echo number_format($res[$i]['valor'], 2, ',', '.'); ?></b></td>

							<td  class="text-center"><b><?php echo $nome_usuario ?></b></td>

							

							<td  class="text-center"><b><?php echo implode('/', array_reverse(explode('-', $res[$i]['data']))); ?></td>

							

							
							
						</tr>

					<?php } ?>

				</tbody>

			</table>

		</small>
	<?php }else{
		echo '<p>Não existem dados para serem exibidos!!';
	} ?>
</div>

<?php 
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

		}

	}

	?>

	<small>
		<div class="row bg-light mt-4 py-2">
			<div class="col-md-8">
				<span><b>Entradas :</b> <span class="text-success">R$ <?php echo $entradasF ?></span></span>
				<span class="mx-4"><b>Saídas :</b><span class="text-danger"> R$ <?php echo $saidasF ?></span></span>
			</div>

			<div align="right" class="col-md-4">
				<span class="mx-4"><b>Saldo do Dia :</b> <span class="<?php echo $classeSaldo ?>">R$ <?php echo $saldoF ?></span></span>
			</div>
		</div>
	</small>




	<script type="text/javascript">
		$(document).ready(function() {
			$('#example').DataTable({
				"ordering": false
			});
		} );
	</script>




