<?php 
$pag = 'clientes';
@session_start();

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

<a href="index.php?pagina=<?php echo $pag ?>&funcao=novo" type="button" class="btn btn-success mt-2">Novo Cliente</a>

<div class="mt-4" style="margin-right:25px">
    <?php 
	$query = $pdo->query("SELECT * from clientes order by id desc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){ 
		?>
    <small>
        <table id="example" class="table table-hover my-4" style="width:100%">
            <thead>
                <tr class="bg-success">
                    <th class="text-white text-center">Nome</th>
                    <th class="text-white text-center">CPF</th>
                    <th class="text-white text-center">Telefone</th>
                    <th class="text-white text-center">Ações</th>
                </tr>
            </thead>
            <tbody>

                <?php 
					for($i=0; $i < $total_reg; $i++){
						foreach ($res[$i] as $key => $value){	}

							$id = $res[$i]['id'];
							$query2 = $pdo->query("SELECT * from contas_receber where vencimento < curDate() and cliente = '$id' and pago != 'Sim'");
							$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
							$total_reg2 = @count($res2);
							if($total_reg2 > 0){
								$debito = 'text-danger';
							}else{
								$debito = '';
							}

							?>

                <tr class="<?php echo $debito ?>">
                    <td class="text-center"><b><?php echo $res[$i]['nome'] ?></b></td>
                    <td class="text-center"><b><?php echo $res[$i]['cpf'] ?></b></td>
                    <td class="text-center"><b><?php echo $res[$i]['telefone'] ?></b></td>
                    <td class="text-center">
                            <a style="text-decoration: none"
                                href="index.php?pagina=<?php echo $pag ?>&funcao=editar&id=<?php echo $res[$i]['id'] ?>"
                                title="Editar Registro">
                                <i class="bi bi-pencil-fill text-primary"></i>
                            </a>

                            <a style="text-decoration: none"
                                href="index.php?pagina=<?php echo $pag ?>&funcao=deletar&id=<?php echo $res[$i]['id'] ?>"
                                title="Excluir Registro">
                                <i class="bi bi-trash-fill text-danger mx-1"></i>
                            </a>

                            <a style="text-decoration: none" href="#"
                                onclick="mostrarDados('<?php echo $res[$i]['endereco'] ?>', '<?php echo $res[$i]['nome'] ?>')"
                                title="Ver Endereço">
                                <i class="bi bi-geo-alt-fill text-warning"></i>
                            </a>

                            <a style="text-decoration: none" href="#"
                                onclick="mostrarContas('<?php echo $res[$i]['id'] ?>', '<?php echo $res[$i]['nome'] ?>')"
                                title="Ver Endereço">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-currency-dollar text-success" viewBox="0 0 16 16">
                                    <path
                                        d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z" />
                                </svg>
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


<?php 
if(@$_GET['funcao'] == "editar"){
	$titulo_modal = 'Editar Registro';
	$query = $pdo->query("SELECT * from clientes where id = '$_GET[id]'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){ 
		$nome = $res[0]['nome'];		
		$cpf = $res[0]['cpf'];
		$telefone = $res[0]['telefone'];
		$endereco = $res[0]['endereco'];
		

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

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"
                                    required="" value="<?php echo @$nome ?>">
                            </div>
                        </div>

                    </div>



                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Telefone</label>
                                <input type="text" class="form-control" id="telefone" name="telefone"
                                    placeholder="Telefone" required="" value="<?php echo @$telefone ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">CPF</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF / CNPJ"
                                    value="<?php echo @$cpf ?>">
                            </div>
                        </div>
                    </div>



                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Endereço</label>
                        <input type="text" class="form-control" id="endereco" name="endereco"
                            placeholder="Rua X Número X Bairro X ..." value="<?php echo @$endereco ?>">
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

                    <input name="antigo" type="hidden" value="<?php echo @$cpf ?>">


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





<div class="modal fade" tabindex="-1" id="modalDados">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dados do Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body mb-4">

                <b>Nome: </b>
                <span id="nome-registro"></span>
                <hr>
                <b>Endereço: </b>
                <span id="endereco-registro"></span>
            </div>

        </div>
    </div>
</div>






<div class="modal fade" tabindex="-1" id="modalContas">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><span id="nome-contas"></span></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body mb-4" id="listar-contas">


            </div>

        </div>
    </div>
</div>







<div class="modal fade" tabindex="-1" id="modalBaixar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Baixar Conta : R$ <span id="valor-conta"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="form-baixar">
                <div class="modal-body">

                    <p>Deseja Realmente Baixar a Conta?</p>

                    <small>
                        <div align="center" class="mt-1" id="mensagem-baixar">

                        </div>
                    </small>

                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar-baixar" class="btn btn-secondary"
                        data-bs-dismiss="modal">Fechar</button>
                    <button name="btn-excluir" id="btn-baixar" type="submit" class="btn btn-success">Baixar</button>

                    <input name="id" type="hidden" id="id-baixar">
                    <input name="id_cli" type="hidden" id="id-cli-baixar">

                </div>
            </form>
        </div>
    </div>
</div>







<div class="modal fade" tabindex="-1" id="modalBaixarContas">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Baixar Contas <span id="nome-baixar-contas"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="form-baixar-contas">
                <div class="modal-body">

                    <p>Confirmar pagamento do total de <b>R$ <span id="valor_contas"></span></b> Reais ou dar baixa
                        parcial no valor!</p>

                    <hr>

                    <div class="row">
                        <div class="col-md-2" style="margin-top: 3px">

                        </div>
                        <div class="col-md-3" style="margin-top: 3px">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label"><b>Total Pago</b></label>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <input type="text" class="form-control" id="total_pago" name="total_pago" required>
                            </div>
                        </div>
                    </div>


                    <small>
                        <div align="center" class="mt-1" id="mensagem-baixar-contas">

                        </div>
                    </small>

                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar-baixar-contas" class="btn btn-secondary"
                        data-bs-dismiss="modal">Fechar</button>
                    <button name="btn-excluir" id="btn-baixar-contas" type="submit"
                        class="btn btn-success">Baixar</button>

                    <input name="id" type="hidden" id="id-baixar-contas">

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



<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable({
        "ordering": false
    });

    $('#example_filter label input').focus();
});
</script>


<script type="text/javascript">
function mostrarDados(endereco, nome) {
    event.preventDefault();

    $('#endereco-registro').text(endereco);
    $('#nome-registro').text(nome);

    var myModal = new bootstrap.Modal(document.getElementById('modalDados'), {

    })

    myModal.show();
}
</script>




<script type="text/javascript">
function mostrarContas(id, nome) {
    event.preventDefault();

    listarContas(id);
    $('#nome-contas').text(nome);

    var myModal = new bootstrap.Modal(document.getElementById('modalContas'), {

    })

    myModal.show();
}
</script>




<script type="text/javascript">
var pag = "<?=$pag?>";

function listarContas(id) {
    $.ajax({
        url: pag + "/listar-contas.php",
        method: 'POST',
        data: {
            id
        },
        dataType: "html",

        success: function(result) {
            $("#listar-contas").html(result);
        }

    });
}
</script>



<script type="text/javascript">
function baixar(id, valor, id_cli) {
    $('#id-baixar').val(id);
    $('#valor-conta').text(valor);
    $('#id-cli-baixar').val(id_cli);
    var myModal = new bootstrap.Modal(document.getElementById('modalBaixar'), {

    })

    myModal.show();
}
</script>





<!--AJAX PARA EXCLUIR DADOS -->
<script type="text/javascript">
$("#form-baixar").submit(function() {
    var pag = "<?=$pag?>";
    event.preventDefault();
    var formData = new FormData(this);

    var id_cliente = $('#id-cli-baixar').val();

    $.ajax({
        url: pag + "/baixar.php",
        type: 'POST',
        data: formData,

        success: function(mensagem) {

            $('#mensagem').removeClass()

            if (mensagem.trim() == "Baixado com Sucesso!") {

                $('#mensagem-baixar').addClass('text-success')

                $('#btn-fechar-baixar').click();
                listarContas(id_cliente)

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





<!--AJAX PARA EXCLUIR DADOS -->
<script type="text/javascript">
$("#form-baixar-contas").submit(function() {
    var pag = "<?=$pag?>";
    event.preventDefault();
    var formData = new FormData(this);

    var id_cliente = $('#id-baixar-contas').val();

    $.ajax({
        url: pag + "/baixar_contas.php",
        type: 'POST',
        data: formData,

        success: function(mensagem) {

            $('#mensagem-baixar-contas').removeClass()

            if (mensagem.trim() == "Baixado com Sucesso!") {

                $('#mensagem-baixar-contas').addClass('text-success')

                $('#btn-fechar-baixar-contas').click();
                listarContas(id_cliente)

            } else {

                $('#mensagem-baixar-contas').addClass('text-danger')
            }

            $('#mensagem-baixar-contas').text(mensagem)

        },

        cache: false,
        contentType: false,
        processData: false,

    });
});
</script>