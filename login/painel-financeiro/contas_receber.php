<?php 
$pag = 'contas_receber';
@session_start();
$data_hoje = date('Y-m-d');
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

<a href="index.php?pagina=<?php echo $pag ?>&funcao=novo" type="button" class="btn btn-success mt-2">Nova Conta</a>

<div class="mt-4" style="margin-right:25px">
    <?php 
	$query = $pdo->query("SELECT * from contas_receber order by id desc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){ 
		?>
    <small>
        <table id="example" class="table table-hover my-4" style="width:100%">
            <thead>
                <tr class="bg-success">
                    <th class="text-white text-center">Pago</th>
                    <th class="text-white text-center">Descrição</th>
                    <th class="text-white text-center">Valor</th>
                    <th class="text-white text-center">Usuário</th>
                    <th class="text-white text-center">Vencimento</th>
                    <th class="text-white text-center">Arquivo</th>
                    <th class="text-white text-center">Ações</th>
                </tr>
            </thead>
            <tbody>

                <?php 
					for($i=0; $i < $total_reg; $i++){
						foreach ($res[$i] as $key => $value){	}

							$id = $res[$i]['id'];

						$id_usu = $res[$i]['usuario'];
						$query_p = $pdo->query("SELECT * from usuarios where id = '$id_usu'");
						$res_p = $query_p->fetchAll(PDO::FETCH_ASSOC);
						if (!empty($res_p)) {
							$nome_usu = $res_p[0]['nome'];
						} else {
							// Trate o caso em que $res_p está vazio (ou seja, não encontrou nenhum usuário com o ID especificado)
							$nome_usu = "Usuário não encontrado";
						}

						if($res[$i]['pago'] == 'Sim'){
							$classe = 'text-success';
						}else{
							$classe = 'text-danger';
						}

						$extensao = strchr($res[$i]['arquivo'], '.');
						if($extensao == '.pdf'){
							$arquivo_pasta = 'pdf.png';
						}else{
							$arquivo_pasta = $res[$i]['arquivo'];
						}

						$cliente = $res[$i]['cliente'];
						$query_p = $pdo->query("SELECT * from clientes where id = '$cliente'");
						$res_p = $query_p->fetchAll(PDO::FETCH_ASSOC);
						if(@count($res_p) > 0){
							$nome_cli = '('.@$res_p[0]['nome'].')';
						}else{
							$nome_cli = '';
						}

						$data_venc =  $res[$i]['vencimento'];
						$pago =  $res[$i]['pago'];

						if(strtotime($data_venc) < strtotime($data_hoje) and $pago != 'Sim'){
							$vencido = 'text-danger';

						}else{
							$vencido = '';
						}
						

						?>

                <tr class="<?php echo $vencido ?>">
                    <td class="text-center"> <i class="bi bi-square-fill <?php echo $classe ?>"></i>
                    </td>

                    <td class="text-center"><b><?php echo $res[$i]['descricao'] ?><small><span
                                style="color:blue"><?php echo $nome_cli ?></b></span></small></td>

                    <td class="text-center"><b>R$ <?php echo number_format($res[$i]['valor'], 2, ',', '.'); ?></b></td>

                    <td class="text-center"><b><?php echo $nome_usu ?></b></td>

                    <td class="text-center"><b><?php echo implode('/', array_reverse(explode('-', $res[$i]['vencimento']))); ?></b></td>

                    <td class="text-center"><a href="../img/<?php echo $pag ?>/<?php echo $res[$i]['arquivo'] ?>" title="Ver Arquivo"
                            style="text-decoration: none" target="_blank">
                            <img src="../img/<?php echo $pag ?>/<?php echo $arquivo_pasta ?>" width="30px">
                        </a>
                    </td>
                    <td class="text-center">
                        <?php if($res[$i]['pago'] != 'Sim'){ ?>
                        <a href="index.php?pagina=<?php echo $pag ?>&funcao=editar&id=<?php echo $res[$i]['id'] ?>"
                            title="Editar Registro" style="text-decoration: none">
                            <i class="bi bi-pencil-fill text-primary"></i>
                        </a>

                        <a href="index.php?pagina=<?php echo $pag ?>&funcao=deletar&id=<?php echo $res[$i]['id'] ?>"
                            title="Excluir Registro" style="text-decoration: none">
                            <i class="bi bi-trash-fill text-danger mx-1"></i>
                        </a>


                        <a href="#" onclick="parcelar('<?php echo $id ?>')" title="Parcelar Conta"
                            style="text-decoration: none">
                            <i class="bi bi-calendar2-check text-warning mx-1"></i>

                        </a>


                        <a href="index.php?pagina=<?php echo $pag ?>&funcao=baixar&id=<?php echo $res[$i]['id'] ?>"
                            title="Baixar Registro" style="text-decoration: none">
                            <i class="bi bi-check-square-fill text-success mx-1"></i>

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


<?php 
if(@$_GET['funcao'] == "editar"){
	$titulo_modal = 'Editar Registro';
	$query = $pdo->query("SELECT * from contas_receber where id = '$_GET[id]'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){ 
		$valor = $res[0]['valor'];
		$descricao = $res[0]['descricao'];
		$arquivo = $res[0]['arquivo'];
		$vencimento = $res[0]['vencimento'];
		$cliente = $res[0]['cliente'];


		$extensao2 = strchr($arquivo, '.');
						if($extensao2 == '.pdf'){
							$arquivo_pasta2 = 'pdf.png';
						}else{
							$arquivo_pasta2 = $arquivo;
						}

	}
}else{
	$titulo_modal = 'Inserir Registro';
}
?>


<div class="modal fade" tabindex="-1" id="modalCadastrar" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $titulo_modal ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="form">
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Cliente</label>
                        <select class="form-select mt-1 sel3" aria-label="Default select example" name="cliente"
                            style="width:100%">
                            <option value="">Selecionar Cliente</option>
                            <?php 
									$query = $pdo->query("SELECT * from clientes order by nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									$total_reg = @count($res);
									if($total_reg > 0){ 

										for($i=0; $i < $total_reg; $i++){
											foreach ($res[$i] as $key => $value){	}
												?>

                            <option <?php if(@$cliente == $res[$i]['id']){ ?> selected <?php } ?>
                                value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

                            <?php }

									} ?>


                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Descrição</label>
                        <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição"
                            required="" value="<?php echo @$descricao ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">

                                <label for="exampleFormControlInput1" class="form-label">Valor</label>
                                <input type="text" class="form-control" id="valor" name="valor" placeholder="Valor"
                                    required="" value="<?php echo @$valor ?>">
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Vencimento</label>
                                <input type="date" class="form-control" id="vencimento" name="vencimento" required=""
                                    value="<?php echo @$vencimento ?>">
                            </div>

                        </div>


                    </div>




                    <div class="form-group">
                        <label>Arquivo</label>
                        <input type="file" value="<?php echo @$foto ?>" class="form-control-file" id="imagem"
                            name="imagem" onChange="carregarImg();">
                    </div>

                    <div id="divImgConta" class="mt-4">
                        <?php if(@$arquivo != ""){ ?>
                        <img src="../img/<?php echo $pag ?>/<?php echo @$arquivo_pasta2 ?>" width="200px" id="target">
                        <?php  }else{ ?>
                        <img src="../img/<?php echo $pag ?>/sem-foto.jpg" width="200px" id="target">
                        <?php } ?>
                    </div>




                    <small>
                        <div align="center" class="mt-1" id="mensagem">

                        </div>
                    </small>

                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar" class="btn btn-secondary"
                        data-bs-dismiss="modal">Fechar</button>
                    <button name="btn-salvar" id="btn-salvar" type="submit" class="btn btn-primary">Salvar</button>

                    <input name="id" type="hidden" value="<?php echo @$_GET['id'] ?>">



                </div>
            </form>
        </div>
    </div>
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





<div class="modal fade" tabindex="-1" id="modalBaixar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Baixar Registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="form-baixar">
                <div class="modal-body">

                    <p>Deseja Realmente confirmar o Recebimento do pagamento desta conta?</p>

                    <small>
                        <div align="center" class="mt-1" id="mensagem-baixar">

                        </div>
                    </small>

                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar-baixar" class="btn btn-secondary"
                        data-bs-dismiss="modal">Fechar</button>
                    <button name="btn-baixar" id="btn-excluir" type="submit" class="btn btn-success">Baixar</button>

                    <input name="id" type="hidden" value="<?php echo @$_GET['id'] ?>">

                </div>
            </form>
        </div>
    </div>
</div>







<div class="modal fade" tabindex="-1" id="modalParcelar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Parcelar Conta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="form-parcelar">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Parcelas</label>
                                <input type="number" class="form-control" id="parcelas" name="parcelas"
                                    placeholder="Parcelas" required="" value="">
                            </div>
                        </div>



                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Frequência</label>
                                <select class="form-control" name="frequencia" id="frequencia">
                                    <option value="30">Mensal</option>
                                    <option value="7">Semanal</option>
                                    <option value="1">Diária</option>
                                </select>
                            </div>
                        </div>
                    </div>



                    <small>
                        <div align="center" class="mt-1" id="mensagem-parcelar">

                        </div>
                    </small>

                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar-parcelar" class="btn btn-secondary"
                        data-bs-dismiss="modal">Fechar</button>
                    <button name="btn-parcelar" id="btn-excluir" type="submit" class="btn btn-success">Baixar</button>

                    <input name="id" type="hidden" id="id_parcelar">

                </div>
            </form>
        </div>
    </div>
</div>




<?php 
if(@$_GET['funcao'] == "novo"){ ?>
<script type="text/javascript">
var myModal = new bootstrap.Modal(document.getElementById('modalCadastrar'), {
    backdrop: 'static'
})

myModal.show();
</script>
<?php } ?>



<?php 
if(@$_GET['funcao'] == "editar"){ ?>
<script type="text/javascript">
var myModal = new bootstrap.Modal(document.getElementById('modalCadastrar'), {
    backdrop: 'static'
})

myModal.show();
</script>
<?php } ?>



<?php 
if(@$_GET['funcao'] == "deletar"){ ?>
<script type="text/javascript">
var myModal = new bootstrap.Modal(document.getElementById('modalDeletar'), {

})

myModal.show();
</script>
<?php } ?>



<?php 
if(@$_GET['funcao'] == "baixar"){ ?>
<script type="text/javascript">
var myModal = new bootstrap.Modal(document.getElementById('modalBaixar'), {

})

myModal.show();
</script>
<?php } ?>




<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
$("#form").submit(function() {
    var pag = "<?=$pag?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: pag + "/inserir.php",
        type: 'POST',
        data: formData,

        success: function(mensagem) {

            $('#mensagem').removeClass()

            if (mensagem.trim() == "Salvo com Sucesso!") {

                //$('#nome').val('');
                //$('#cpf').val('');
                $('#btn-fechar').click();
                window.location = "index.php?pagina=" + pag;

            } else {

                $('#mensagem').addClass('text-danger')
            }

            $('#mensagem').text(mensagem)

        },

        cache: false,
        contentType: false,
        processData: false,
        xhr: function() { // Custom XMLHttpRequest
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                myXhr.upload.addEventListener('progress', function() {
                    /* faz alguma coisa durante o progresso do upload */
                }, false);
            }
            return myXhr;
        }
    });
});
</script>




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






<!--AJAX PARA EXCLUIR DADOS -->
<script type="text/javascript">
$("#form-baixar").submit(function() {
    var pag = "<?=$pag?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: pag + "/baixar.php",
        type: 'POST',
        data: formData,

        success: function(mensagem) {

            $('#mensagem-baixar').removeClass()

            if (mensagem.trim() == "Baixado com Sucesso!") {

                $('#mensagem-baixar').addClass('text-success')

                $('#btn-fechar-baixar').click();
                window.location = "index.php?pagina=" + pag;

            } else {

                $('#mensagem-baixar').addClass('text-danger')
            }

            $('#mensagem-baixar').text(mensagem)

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






<!--SCRIPT PARA CARREGAR IMAGEM -->
<script type="text/javascript">
function carregarImg() {

    var target = document.getElementById('target');
    var file = document.querySelector("input[type=file]").files[0];

    var arquivo = file['name'];
    resultado = arquivo.split(".", 2);
    //console.log(resultado[1]);

    if (resultado[1] === 'pdf') {
        $('#target').attr('src', "../img/contas_pagar/pdf.png");
        return;
    }

    var reader = new FileReader();

    reader.onloadend = function() {
        target.src = reader.result;
    };

    if (file) {
        reader.readAsDataURL(file);


    } else {
        target.src = "";
    }
}
</script>



<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    $('.sel2').select2({
        dropdownParent: $('#modalCadastrar')
    });
});
</script>

<script type="text/javascript">
$(document).ready(function() {
    $('.sel3').select2({
        dropdownParent: $('#modalCadastrar')
    });
});
</script>




<style type="text/css">
.select2-selection__rendered {
    line-height: 36px !important;
    font-size: 16px !important;
    color: #666666 !important;

}

.select2-selection {
    height: 36px !important;
    font-size: 16px !important;
    color: #666666 !important;

}
</style>





<script type="text/javascript">
function parcelar(id) {

    $('#id_parcelar').val(id);
    var myModal = new bootstrap.Modal(document.getElementById('modalParcelar'), {

    })

    myModal.show();
}
</script>





<!--AJAX PARA EXCLUIR DADOS -->
<script type="text/javascript">
$("#form-parcelar").submit(function() {
    var pag = "<?=$pag?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: pag + "/parcelar.php",
        type: 'POST',
        data: formData,

        success: function(mensagem) {

            $('#mensagem-parcelar').removeClass()

            if (mensagem.trim() == "Parcelado com Sucesso") {

                $('#mensagem-parcelar').addClass('text-success')

                $('#btn-fechar-parcelar').click();
                window.location = "index.php?pagina=" + pag;

            } else {

                $('#mensagem-parcelar').addClass('text-danger')
            }

            $('#mensagem-parcelar').text(mensagem)

        },

        cache: false,
        contentType: false,
        processData: false,

    });
});
</script>