<?php 
$pag = 'usuarios';
@session_start();

require_once('../conexao.php');
require_once('verificar-permissao.php')

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
</head>
<body>
    
</body>
</html>




<a href="index.php?pagina=<?php echo $pag ?>&funcao=novo" type="button" class="btn btn-success mt-2">Novo Usuário</a>

<div class="mt-5" style="margin-right:25px">
    <?php 
	$query = $pdo->query("SELECT * from usuarios order by id desc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){ 
		?>
    <small>
        <table id="example" class="table table-hover my-4" style="width:100%; margin-left:10px;">

            <thead>
                <tr class="bg-success">
                    <th class="text-white text-center">Foto</th>
                    <th class="text-white text-center">Nome</th>
                    <th class="text-white text-center">Telefone</th>
                    <th class="text-white text-center">Email</th>
                    <th class="text-white text-center">Senha</th>
                    <th class="text-white text-center">CPF</th>
                    <th class="text-white text-center">Endereço</th>
                    <th class="text-white text-center">Acesso</th>
                    <th class="text-white text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
</div>

<?php 
					for($i=0; $i < $total_reg; $i++){
						foreach ($res[$i] as $key => $value){	}
							?>

<tr>
    <td class="text-center">
        <img src="<?php echo ($res[$i]['genero'] === 'masculino') ? '../img/usuarios/masc-user.png' : (($res[$i]['genero'] === 'feminino') ? '../img/usuarios/fem-user.png' : '../img/usuarios/sem-foto.jpg'); ?>"
            alt="Ícone de Gênero" width="40px" height="40px">
    </td>

    <td class="text-center"><b><?php echo $res[$i]['nome'] ?></b></td>
    <td class="text-center"><b><?php echo $res[$i]['telefone'] ?></b></td>
    <td class="text-center"><b><?php echo $res[$i]['email'] ?></b></td>
    <td class="text-center"><b><?php echo $res[$i]['senha'] ?></b></td>
    <td class="text-center"><b><?php echo $res[$i]['cpf'] ?></b></td>
    <td class="text-center"><b><?php echo $res[$i]['endereco'] ?></b></td>
    <td class="text-center"><b><?php echo $res[$i]['nivel'] ?></b></td>

    <td class="text-center">
        <a href="index.php?pagina=<?php echo $pag ?>&funcao=editar&id=<?php echo $res[$i]['id'] ?>"
            title="Editar Registro">
            <i class="bi bi-pencil-fill text-primary"></i>
        </a>

        <a href="index.php?pagina=<?php echo $pag ?>&funcao=deletar&id=<?php echo $res[$i]['id'] ?>"
            title="Excluir Registro">
            <i class="bi bi-trash-fill text-danger mx-1"></i>
        </a>

        <a href="#" onclick="mostrarDados('<?php echo $nome ?>')"
            title="Ver Descriçao" style="text-decoration: none">
            <i class="bi bi-border-width text-info mx-1"></i>
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
	$query = $pdo->query("SELECT * from usuarios where id = '$_GET[id]'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){ 
		$nome = $res[0]['nome'];
        $telefone = $res[0]['telefone'];
		$email = $res[0]['email'];
		$cpf = $res[0]['cpf'];
        $endereco = $res[0]['endereco'];
		$senha = $res[0]['senha'];
		$nivel = $res[0]['nivel'];

 

	}
}else{
	$titulo_modal = 'Inserir Registro';
}
?>


<div class="modal fade" tabindex="-1" id="modalCadastrar" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b><?php echo $titulo_modal ?></b></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="form">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label"><b>Nome</b></label>
                                <input type="text" class="form-control form-control-md" id="nome" name="nome"
                                    placeholder="Nome" required="" value="<?php echo @$nome ?>">
                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label"><b>Email</b></label>
                                <input type="email" class="form-control form-control-md" id="email" name="email"
                                    placeholder="Email" required="" value="<?php echo @$email ?>">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label"><b>Telefone</b></label>
                                <input type="text" class="form-control form-control-md" id="telefone" name="telefone"
                                    placeholder="Telefone" required="" value="<?php echo @$telefone ?>">
                            </div>
                        </div>

                        

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label"><b>CPF</b></label>
                                <input type="text" class="form-control form-control-md" id="cpf" name="cpf"
                                    placeholder="CPF" required="" value="<?php echo @$cpf ?>">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label"><b>Senha</b></label>
                                <input type="password" class="form-control form-control-md" id="senha" name="senha"
                                    placeholder="Senha" required="" value="<?php echo @$senha ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label"><b>Confirmar Senha</b></label>
                                <input type="password" class="form-control form-control-md" id="conf_senha"
                                    name="conf_senha" placeholder="Confirmar Senha" required=""
                                    value="<?php echo @$conf_senha ?>">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label"><b>Endereço</b></label>
                        <input type="text" class="form-control form-control-md" id="endereco" name="endereco"
                            placeholder="Endereço" required="" value="<?php echo @$endereco ?>">
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label"><b>Sexo</b></label>
                        <select class="form-select mt-1" aria-label="Default select example" name="genero"
                            id="gender-select">
                            <option value="masculino">Masculino</option>
                            <option value="feminino">Feminino</option>
                            <option value="">Nenhum</option>
                        </select>
                    </div>



                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label"><b>Nível</b></label>
                        <select class="form-select mt-1" aria-label="Default select example" name="nivel">

                            <option <?php if(@$nivel == 'Operador'){ ?> selected <?php } ?> value="Operador">
                                Operador</option>

                            <option <?php if(@$nivel == 'Administrador'){ ?> selected <?php } ?> value="Administrador">
                                Administrador</option>

                            <option <?php if(@$nivel == 'Financeiro'){ ?> selected <?php } ?> value="Financeiro">
                                Financeiro</option>


                        </select>
                    </div>

                    <small>
                        <div align="center" class="mt-1" id="mensagem">

                        </div>
                    </small>

                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar" class="btn btn-primary"
                        data-bs-dismiss="modal">Fechar</button>
                    <button name="btn-salvar" id="btn-salvar" type="submit" class="btn btn-success">Salvar</button>

                    <input name="id" type="hidden" value="<?php echo @$_GET['id'] ?>">

                    <input name="antigo" type="hidden" value="<?php echo @$cpf ?>">
                    <input name="antigo2" type="hidden" value="<?php echo @$email ?>">
                    <input name="antigo3" type="hidden" value="<?php echo @$telefone ?>">

                </div>
            </form>
        </div>
    </div>
</div>


<?php 
if(@$_GET['funcao'] == "deletar"){
	$titulo_modal = 'deletar Registro';
	$query = $pdo->query("SELECT * from usuarios where id = '$_GET[id]'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){ 
		$nome = $res[0]['nome'];
	}
}
?>
<div class="modal fade" tabindex="-1" id="modalDeletar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Apagar Usuário</b></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="form-excluir">
                <div class="modal-body">

                

                    <p>Você realmente deseja excluir o usuário(a) <b><?php echo @$nome ?>?</b></p>

                    <small>
                        <div align="center" class="mt-1" id="mensagem-excluir">

                        </div>
                    </small>

                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar" class="btn btn-success"
                        data-bs-dismiss="modal">Fechar</button>
                    <button name="btn-excluir" id="btn-excluir" type="submit" class="btn btn-danger">Excluir</button>

                    <input name="id" type="hidden" value="<?php echo @$_GET['id'] ?>">

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




<script type="text/javascript">
function mostrarDados(nome) {
    event.preventDefault();

    if (nome_forn.trim() === "") {
        document.getElementById("div-forn").style.display = 'none';
    } else {
        document.getElementById("div-forn").style.display = 'block';
    }

    $('#nome-registro').text(nome);



    var myModal = new bootstrap.Modal(document.getElementById('modalDados'), {

    })

    myModal.show();
}
</script>





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

<!--SCRIPT PARA CARREGAR IMAGEM -->
<script type="text/javascript">
function carregarImg() {

    var target = document.getElementById('target');
    var file = document.querySelector("input[type=file]").files[0];
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