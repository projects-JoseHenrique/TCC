<?php 
$pag = 'compras';
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
<link rel="stylesheet" type="text/css" href="../vendor/DataTables/datatables.css" />


<div class="mt-4" style="margin-right:25px">
    <?php 
	$query = $pdo->query("SELECT * from compras order by id desc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){ 
		?>
    <small>
        <table id="example" class="table table-hover my-4" style="width:100%;  margin-left:10px;">
            <thead>
                <tr class="bg-success">
                    <th class="text-white text-center">Pago</th>
                    <th class="text-white text-center">Produto</th>
                    <th class="text-white text-center">Total</th>
                    <th class="text-white text-center">Data</th>
                    <th class="text-white text-center">Gerente</th>
                    <th class="text-white text-center">Fornecedor</th>
                    <th class="text-white text-center">Tel Fornecedor</th>
                    <th class="text-white text-center">Lote</th>
                    <th class="text-white text-center">Validade</th>
                    <th class="text-white text-center">Arquivo</th>
                    <th class="text-white text-center">Excluir</th>
                </tr>
            </thead>
            <tbody>

                <?php 
					for($i=0; $i < $total_reg; $i++){
						foreach ($res[$i] as $key => $value){	}

							$arquivo = $res[$i]['arquivo'];

							//BUSCAR OS DADOS DO USUARIO
						$id_usu = $res[$i]['usuario'];
						$query_f = $pdo->query("SELECT * from usuarios where id = '$id_usu'");
						$res_f = $query_f->fetchAll(PDO::FETCH_ASSOC);
						$total_reg_f = @count($res_f);
						if($total_reg_f > 0){ 
							$nome_usu = $res_f[0]['nome'];
							
						}


						//BUSCAR OS DADOS DO FORNECEDOR
						$id_forn = $res[$i]['fornecedor'];
						$query_f = $pdo->query("SELECT * from fornecedores where id = '$id_forn'");
						$res_f = $query_f->fetchAll(PDO::FETCH_ASSOC);
						$total_reg_f = @count($res_f);
						if($total_reg_f > 0){ 
							$nome_forn = $res_f[0]['nome'];
							$tel_forn = $res_f[0]['telefone'];
						}

						
						//BUSCAR NOME PRODUTO
						$id_prod = $res[$i]['produto'];
						$nome_prod = '';
						$query_f = $pdo->query("SELECT * from produtos where id = '$id_prod'");
						$res_f = $query_f->fetchAll(PDO::FETCH_ASSOC);
						$total_reg_f = @count($res_f);
						if($total_reg_f > 0){ 
							$nome_prod = $res_f[0]['nome'];
							
						}


						if($res[$i]['pago'] == 'Sim'){
							$classe = 'text-success';
						}else{
							$classe = 'text-danger';
						}


						//extensão do arquivo
$ext = pathinfo($arquivo, PATHINFO_EXTENSION);
if($ext == 'pdf'){
	$tumb_arquivo = 'pdf.png';
}else if($ext == 'rar' || $ext == 'zip'){
	$tumb_arquivo = 'rar.png';
}else if($ext == 'doc' || $ext == 'docx' || $ext == 'txt'){
	$tumb_arquivo = 'word.png';
}else if($ext == 'xlsx' || $ext == 'xlsm' || $ext == 'xls'){
	$tumb_arquivo = 'excel.png';
}else if($ext == 'xml'){
	$tumb_arquivo = 'xml.png';
}else{
	$tumb_arquivo = $arquivo;
}

if($arquivo == ""){
	$tumb_arquivo = 'sem-foto.jpg';
}

						?>

                <tr>
                    <td class="text-center"><i class="bi bi-square-fill <?php echo $classe ?>"></i>
                    </td>
                    <td class="text-center"><b><?php echo $nome_prod ?></b></td>
                    <td class="text-center"><b>R$ <?php echo number_format($res[$i]['total'], 2, ',', '.'); ?></b></td>

                    <td class="text-center">
                        <b><?php echo implode('/', array_reverse(explode('-', $res[$i]['data']))); ?></td>

                    <td class="text-center"><b><?php echo $nome_usu ?></td>

                    <td class="text-center"><b><?php echo $nome_forn ?></td>

                    <td class="text-center"><b><?php echo $tel_forn ?></td>
                    <td class="text-center"><b><?php echo $res[$i]['lote'] ?></td>
                    <td class="text-center">
                        <b><?php echo implode('/', array_reverse(explode('-', $res[$i]['validade']))); ?></td>

                    <td class="text-center"><a target="_blank" href="../img/arquivos/<?php echo $arquivo ?>"><img
                                src="../img/arquivos/<?php echo $tumb_arquivo ?>" width="40px"></a></td>

                    <td class="text-center">
                        <?php if($res[$i]['pago'] != 'Sim'){ ?>

                        <a href="index.php?pagina=<?php echo $pag ?>&funcao=deletar&id=<?php echo $res[$i]['id'] ?>"
                            title="Excluir Registro" style="text-decoration: none">
                            <i class="bi bi-trash-fill text-danger mx-1"></i>
                        </a>
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



<div class="modal fade" tabindex="-1" id="modalDeletar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Excluir Registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="form-excluir">
                <div class="modal-body">

                    <p>Deseja Realmente Excluir o Registro?</p>

                    <small>
                        <div align="center" class="mt-1" id="mensagem-excluir">

                        </div>
                    </small>

                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar" class="btn btn-secondary"
                        data-bs-dismiss="modal">Fechar</button>
                    <button name="btn-excluir" id="btn-excluir" type="submit" class="btn btn-danger">Excluir</button>

                    <input name="id" type="hidden" value="<?php echo @$_GET['id'] ?>">

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
$("#form-excluir").submit(function() {
    var pag = "<?=$pag?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: pag + "/excluir.php",
        type: 'POST',
        data: formData,

        success: function(mensagem) {

            $('#mensagem').removeClass()

            if (mensagem.trim() == "Excluído com Sucesso!") {

                $('#mensagem-excluir').addClass('text-success')

                $('#btn-fechar').click();
                window.location = "index.php?pagina=" + pag;

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
});
</script>