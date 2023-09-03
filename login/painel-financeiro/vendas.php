<?php 
$pag = 'vendas';

require_once('../conexao.php');
require_once('verificar-permissao.php')

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
	$query = $pdo->query("SELECT * from vendas order by id desc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){ 
		?>
		<small>
			<table id="example" class="table table-hover my-4" style="width:100%">
				<thead>
					<tr class="bg-success">
						<th class="text-white text-center">Status</th>
						<th class="text-white text-center">Valor</th>
						<th class="text-white text-center">Data</th>
						<th class="text-white text-center">Hora</th>
						<th class="text-white text-center">Operador</th>
						<th class="text-white text-center">Pagamento</th>						
						<th class="text-white text-center">Ações</th>
					</tr>
				</thead>
				<tbody>

					<?php 
					for($i=0; $i < $total_reg; $i++){
						foreach ($res[$i] as $key => $value){	}

							$id_operador = $res[$i]['operador'];
						$tipo_pgto = $res[$i]['forma_pgto'];

						$data2 = implode('/', array_reverse(explode('-', $res[$i]['data'])));

						$total = number_format( $res[$i]['valor'] , 2, ',', '.');

						$res_2 = $pdo->query("SELECT * from forma_pgtos where codigo = '$tipo_pgto' ");
						$dados = $res_2->fetchAll(PDO::FETCH_ASSOC);
						$nome_pgto = $dados[0]['nome'];

						$res_2 = $pdo->query("SELECT * from usuarios where id = '$id_operador' ");
						$dados = $res_2->fetchAll(PDO::FETCH_ASSOC);
						if ($dados && count($dados) > 0) {
							$nome_operador = $dados[0]['nome'];
						}



						if($res[$i]['status'] == 'Concluída'){
							$classe = 'text-success';
						}else{
							$classe = 'text-danger';
						}

						if($res[$i]['forma_pgto'] == '4' ){
							$cor_texto = 'text-danger';
						}else{
							$cor_texto = '';
						}


						?>

						<tr>
							<td  class="text-center">
								<i class="bi bi-square-fill <?php echo $classe ?>"></i>
								<?php echo $res[$i]['status'] ?></td>
								<td  class="text-center"><b>R$ <?php echo $total ?></b></td>
								<td  class="text-center"><b><?php echo $data2 ?></b></td>
								<td  class="text-center"><b><?php echo $res[$i]['hora'] ?></b></td>
								<td  class="text-center"><b><?php echo $nome_operador ?></b></td>
								<td class="<?php echo $cor_texto  ?> text-center"><b><?php echo $nome_pgto ?></b></td>


								<td  class="text-center">
									<a href="../rel/comprovante.php?id=<?php echo $res[$i]['id'] ?>&imp=Não" title="Gerar Comprovante" target="_blank" style="text-decoration: none">
										<i class="bi bi-clipboard-check text-info"></i>
									</a>

									<?php if($res[$i]['status'] == 'Concluída'){ ?>

									
								<?php } ?>
								</td>
							</tr>

						<?php } ?>

					</tbody>

				</table>
			</small>
		<?php }else{
			echo '<p>Não existem dados para serem exibidos!!';
		} ?>
	</div>




	<script type="text/javascript">
		$(document).ready(function() {
			$('#example').DataTable({
				"ordering": false
			});
		} );
	</script>



