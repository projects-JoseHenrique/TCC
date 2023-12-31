<?php 
$pag = 'alertas';
@session_start();

require_once('../conexao.php');
require_once('verificar-permissao.php');

$data_hoje = date('Y-m-d');

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
<link rel="stylesheet" type="text/css" href="../vendor/DataTables/datatables.css"/>

<div class="mt-4" style="margin-right:25px">

	
	<?php 
	$query = $pdo->query("SELECT * from alerta_vencimentos where data_alerta <= curDate() order by id asc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){ 
		?>
		<small>
			<table id="example" class="table table-hover my-4" style="width:100%;  margin-left:10px;">
				<thead>
					<tr class="bg-success">
						<th class="text-white text-center">Produto</th>
						<th class="text-white text-center">Data Compra</th>
						<th class="text-white text-center">Quantidade Comprada</th>
						<th class="text-white text-center">Lote</th>
						<th class="text-white text-center">Vencimento</th>						
						<th class="text-white text-center">Operações</th>
					</tr>
				</thead>
				<tbody>

					<?php 
					for($i=0; $i < $total_reg; $i++){
						foreach ($res[$i] as $key => $value){	}
						
						$id_alerta = $res[$i]['id'];
						$obs = $res[$i]['obs'];
						$status = $res[$i]['status'];
						$data_vencimento = $res[$i]['data_vencimento'];									
						//BUSCAR NOME PRODUTO
						$id_prod = $res[$i]['produto'];						
						$query_f = $pdo->query("SELECT * from produtos where id = '$id_prod'");
						$res_f = $query_f->fetchAll(PDO::FETCH_ASSOC);
						$total_reg_f = @count($res_f);
						if($total_reg_f > 0){ 
							$nome_prod = $res_f[0]['nome'];							
						}


						//BUSCAR DADOS COMPRA
$id_compra = $res[$i]['compra'];						
$query_f = $pdo->query("SELECT * from compras where id = '$id_compra'");
$res_f = $query_f->fetch(PDO::FETCH_ASSOC); // Use fetch em vez de fetchAll, pois você está buscando apenas um registro

if (!empty($res_f)) { 
    $data = $res_f['data'];        
    $quantidade = $res_f['quantidade'];        
    $lote = $res_f['lote'];
} else {
    // Lide com o caso em que não há resultados encontrados, se necessário
}

						

						if($res[$i]['status'] == 'Conferido'){
							$classe = 'text-primary';
						}else{
							$classe = 'text-danger';
						}


						if(strtotime($data_vencimento) == strtotime($data_hoje)){
							$classe_data = 'text-danger';
						}else{
							$classe_data = '';
						}
						

						?>

						<tr>
						
						<td class="text-center"><b> 
							<i class="bi bi-square-fill <?php echo $classe ?>"></i>
							<?php echo $nome_prod ?></b></td>
						<td><b> <?php echo implode('/', array_reverse(explode('-', $data))); ?></b></td>
							
							<td class="text-center" ><b><?php echo $quantidade ?></b></td>

							<td class="text-center"><b> <?php echo $lote ?></td>						
							<b><td class="text-center" class="<?php echo $classe_data ?>"><b><?php echo implode('/', array_reverse(explode('-', $res[$i]['data_vencimento']))); ?></b></td>

							<td class="text-center">

								<a href="#" onclick="obs('<?php echo $id_alerta ?>', '<?php echo $obs ?>', '<?php echo $status ?>')" title="Lançar Observações" style="text-decoration: none">
									<i class="bi bi-lightbulb-fill text-warning mx-1"></i>
								</a>						

								<a href="index.php?pagina=<?php echo $pag ?>&funcao=deletar&id=<?php echo $res[$i]['id'] ?>" title="Excluir Registro" style="text-decoration: none">
									<i class="bi bi-trash-fill text-danger mx-1"></i>
								</a>
						
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



<div class="modal fade" tabindex="-1" id="modalDeletar" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Excluir Registro</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form method="POST" id="form-excluir">
				<div class="modal-body">

					<p>Deseja Realmente Excluir o Registro?</p>

					<small><div align="center" class="mt-1" id="mensagem-excluir">
						
					</div> </small>

				</div>
				<div class="modal-footer">
					<button type="button" id="btn-fechar" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
					<button name="btn-excluir" id="btn-excluir" type="submit" class="btn btn-danger">Excluir</button>

					<input name="id" type="hidden" value="<?php echo @$_GET['id'] ?>">

				</div>
			</form>
		</div>
	</div>
</div>





<div class="modal fade" tabindex="-1" id="modalObs" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Observações</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form method="POST" id="form-obs">
				<div class="modal-body">

					<div class="col-md-12">
							<div class="mb-3">
								<label for="exampleFormControlInput1" class="form-label">Observações</label>
								<textarea maxlength="255" class="form-control" id="obs" name="obs"   ></textarea>
							</div> 
						</div>



					<div class="col-md-6">
							<div class="mb-3">
								<label for="exampleFormControlInput1" class="form-label">Status</label>
								<select class="form-control" name="status" id="status">
									<option value="Pendente">Pendente</option>
									<option value="Conferido">Conferido</option>
								</select>
							</div> 
						</div>


							<br><small><div align="center" class="mt-1" id="mensagem-obs">

				</div>
				<div class="modal-footer">	
				<button type="button" id="btn-fechar-obs" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>				
					<button name="btn-excluir" id="btn-salvar-obs" type="submit" class="btn btn-success">Salvar</button>

					<input name="id" type="hidden" id="id_obs">

				</div>
			</form>
		</div>
	</div>
</div>


<?php 
if(@$_GET['funcao'] == "deletar"){ ?>
	<script type="text/javascript">
		var myModal = new bootstrap.Modal(document.getElementById('modalDeletar'), {
			
		})

		myModal.show();
	</script>
<?php } ?>




<!--AJAX PARA EXCLUIR DADOS -->
<script type="text/javascript">
	$("#form-excluir").submit(function () {
		var pag = "<?=$pag?>";
		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: pag + "/excluir.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {

				$('#mensagem').removeClass()

				if (mensagem.trim() == "Excluído com Sucesso!") {

					$('#mensagem-excluir').addClass('text-success')

					$('#btn-fechar').click();
					window.location = "index.php?pagina="+pag;

				} else {

					$('#mensagem-excluir').addClass('text-danger')
				}

				$('#mensagem-excluir').text(mensagem)

			},

			cache: false,
			contentType: false,
			processData: false,

		});
	});
</script>






<script type="text/javascript">
	$(document).ready(function() {
		$('#example').DataTable({
			"ordering": false
		});
	} );
</script>


<script type="text/javascript">
	function obs(id, obs, status){	

		$('#id_obs').val(id)
		$('#obs').val(obs)
		$('#status').val(status)
		var myModal = new bootstrap.Modal(document.getElementById('modalObs'), {
			
		})

		myModal.show();

		}
	</script>




<!--AJAX PARA EXCLUIR DADOS -->
<script type="text/javascript">
	$("#form-obs").submit(function () {
		var pag = "<?=$pag?>";
		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: pag + "/obs.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {

				$('#mensagem-obs').removeClass()

				if (mensagem.trim() == "Excluído com Sucesso!") {

					$('#mensagem-obs').addClass('text-success')

					$('#btn-fechar-obs').click();
					window.location = "index.php?pagina="+pag;

				} else {

					$('#mensagem-obs').addClass('text-danger')
				}

				$('#mensagem-obs').text(mensagem)

			},

			cache: false,
			contentType: false,
			processData: false,

		});
	});
</script>