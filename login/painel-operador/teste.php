<?php 
$data_hoje = date('Y-m-d');
@session_start();
$id_usuario = $_SESSION['id_usuario'];
require_once('../conexao.php');
require_once('verificar-permissao.php');

$pag = 'pdv';

if($desconto_porcentagem == 'Sim'){
  $desc = '%';
}else{
  $desc = 'R$';
}

?>

<!DOCTYPE html>
<html class="wide wow-animation" lang="pt-br">

<head>
    <title><?php echo $nome_sistema ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../vendor/css/telapdv.css">

    <link rel="shortcut icon" href="../img/favicon.ico" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">


</head>

<body class="body">
    <div class="col-md-12 col-sm-12 mb-4">
        <form method="post" id="form-buscar">
            <div class="order py-2">
                <div class="row">
                    <div class="col-lg-4 mb-3">
                        <div class="card shadow" style="margin-top: 10px;">
                            <div class="card-header py-2"
                                style="background: linear-gradient(to right, #004480, #6a6a6a);">
                                <h5 class="m-0  text-white text-center " style="font-size: 20px;">INFORMAÇÕES</h5>
                            </div>


                        </div>
                        <div class="mt-2"></div>
                        <div class="card shadow">
                            <div class="card-header py-1"
                                style="background: linear-gradient(to right, #004480, #6a6a6a);">
                                <h7 class="fonte1 m-0 font-weight-bold text-white">CÓDIGO DE BARRAS</h7>
                            </div>
                            <input type="text" class="form-control form-control-lg" id="codigo" name="codigo"
                                placeholder="Código de Barras">


                        </div>
                        <div class="mt-2"></div>
                        <div class="card shadow">
                            <div class="card-header py-1"
                                style="background: linear-gradient(to right, #004480, #6a6a6a);">
                                <h7 class="fonte1 m-0 font-weight-bold text-white">PRODUTO</h7>
                            </div>
                            <input type="text" class="form-control  form-control-md" id="produto" name="produto"
                                placeholder="Produto">

                        </div>

                        <div class="mt-2"></div>
                        <div class="card shadow">
                            <div class="card-header py-1"
                                style="background: linear-gradient(to right, #004480, #6a6a6a);">
                                <h7 class="fonte1 m-0 font-weight-bold text-white">DESCRIÇÃO</h7>
                            </div>
                            <input type="text" class="form-control  form-control-md" id="descricao" name="descricao"
                                placeholder="Descrição do Produto">

                        </div>



                        <div class="mt-3"></div>
                        <div class="card shadow col-md-6">
                            <div class="card-header py-1"
                                style="background: linear-gradient(to right, #004480, #6a6a6a);">
                                <h7 class="fonte1 m-0 font-weight-bold text-white " style="text-align: center;">
                                    QUANTIDADE
                                </h7>
                            </div>
                            <input type="text" class="form-control  form-control-md" id="quantidade" name="quantidade"
                                placeholder="Quantidade">
                        </div>
                        <div class="card shadow col-md-6 lado2">
                            <div class="card-header py-1"
                                style="background: linear-gradient(to right, #004480, #6a6a6a);">
                                <h7 class="fonte1 m-0 font-weight-bold text-white " style="text-align: center;">ESTOQUE
                                    ATUAL
                                </h7>
                            </div>
                            <input type="text" class="form-control  form-control-md" id="estoque" name="estoque"
                                placeholder="Estoque">

                        </div>



                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                    </div>


                    <div class="container lista">
                        <div class="row justify-content-center">
                            <div class="col-5">
                                <div class="card shadow">
                                    <div class="card-header py-2"
                                        style="background: linear-gradient(to right, #004480, #6a6a6a);">
                                        <h5 class="order py-2">LISTA DE PRODUTOS</h5>
                                    </div>
                                    <span id="listar"></span>
                                </div>
                            </div>

                            <div class="col-3  lista2">
                                <div class="card shadow">
                                    <div class="card-header py-2"
                                        style="background: linear-gradient(to right, #004480, #6a6a6a);">
                                        <h5 class="m-0  text-white text-center " style="font-size: 20px;">FINANCEIRO
                                        </h5>
                                    </div>

                                </div>
                                <div class="mt-4"></div>
                                <div class="col-md-6">
                                    <div class="card shadow">
                                        <div class="card-header py-2"
                                            style="background: linear-gradient(to right, #004480, #6a6a6a);">
                                            <h5 class="fonte2 m-0 font-weight-bold text-white">VALOR UNITÁRIO</h5>
                                        </div>
                                        <input type="text" class="form-control  form-control-md" id="valor_unitario"
                                            name="valor_unitario" placeholder="Total da Compra" required="">

                                    </div>
                                </div>

                                <div class="col-md-6 lado">
                                    <div class="card shadow">
                                        <div class="card-header py-2"
                                            style="background: linear-gradient(to right, #004480, #6a6a6a);">
                                            <h5 class="fonte2 m-0 font-weight-bold text-white">SUB TOTAL</h5>
                                        </div>
                                        <input type="text" class="form-control  form-control-md" id="sub_total_item"
                                            name="sub_total" placeholder="Sub Total">

                                    </div>
                                </div>
                                <div class="mt-4"></div>
                                <div class="col-md-6">
                                    <div class="card shadow">
                                        <div class="card-header py-2"
                                            style="background: linear-gradient(to right, #004480, #6a6a6a);">
                                            <h5 class="fonte2 m-0 font-weight-bold text-white">DESCONTO EM %</h5>
                                        </div>
                                        <input type="text" class="form-control  form-control-md" id="desconto"
                                            name="desconto" placeholder="Desconto em <?php echo $desc ?>">

                                    </div>

                                </div>

                                <div class="col-md-6 lado">
                                    <div class="card shadow">
                                        <div class="card-header py-2"
                                            style="background: linear-gradient(to right, #004480, #6a6a6a);">
                                            <h5 class="fonte2 m-0 font-weight-bold text-white">VALOR RECEBIDO</h5>
                                        </div>
                                        <input type="text" class="form-control  form-control-md" id="valor_recebido"
                                            name="valor_recebido" placeholder="R$ 0,00">

                                    </div>
                                </div>
                                <div class="mt-4"></div>
                                <div class="col-md-6">
                                    <div class="card shadow">
                                        <div class="card-header py-2"
                                            style="background: linear-gradient(to right, #004480, #6a6a6a);">
                                            <h5 class="fonte2 m-0 font-weight-bold text-white">TROCO</h5>
                                        </div>
                                        <input type="text" class="form-control  form-control-md" id="valor_troco"
                                            name="valor_troco" placeholder="Valor Troco">
                                    </div>

                                </div>

                                <div class="col-md-6 lado">
                                    <div class="card shadow">
                                        <div class="card-header py-2"
                                            style="background: linear-gradient(to right, #004480, #6a6a6a);">
                                            <h5 class="fonte2 m-0 font-weight-bold text-white">TOTAL COMPRA</h5>
                                        </div>
                                        <input type="text" class="form-control  form-control-md" id="total_compra"
                                            name="total_compra" placeholder="Total da Compra" required="">
                                            <input type="hidden" name="forma_pgto_input" id="forma_pgto_input">
                                        <input type="hidden" name="cliente_input" id="cliente_input">
                                        <input type="hidden" name="data_pgto" id="data_pgto">
                                    </div>
                                </div>

                            </div>



                        </div>

                    </div>
                    <?php 
                    setlocale(LC_ALL, 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                    $data_hoje = strftime('%d/%m/%Y', strtotime('today'));
                                  
                    $operador = $id_usuario;
                    $query_con = $pdo->query("SELECT * FROM usuarios WHERE id = '$operador'");
                    $res = $query_con->fetchAll(PDO::FETCH_ASSOC);
                    if(@count($res) > 0){
                        $nome_operador = $res[0]['nome'];
                    
                    }
                    ?>
                    <div class="col-12 rodape">
                        <div class="card shadow">
                            <div class="card-header py-2"
                                style="background: linear-gradient(to right, #004480, #6a6a6a);">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="text-white" style="font-size: 20px; margin-top:13px;">
                                        <b>OPERADOR:</b><?php echo $nome_operador ?></p>
                                    <p class="text-danger lista5"><b>DATA:</b> <?php echo($data_hoje); ?></p>
                                    <span class="lista6">HORAS<p id="hora"></p></span>
                                </div>
                            </div>
                        </div>
                    </div>

        </form>


    </div>
</body>



</html>







<div class="modal fade" tabindex="-1" id="modalDeletar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Excluir Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="form-excluir">
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Gerente</label>
                        <select class="form-select mt-1" aria-label="Default select example" name="gerente">
                            <?php 
              $query = $pdo->query("SELECT * from usuarios where nivel = 'Administrador' order by nome asc");
              $res = $query->fetchAll(PDO::FETCH_ASSOC);
              $total_reg = @count($res);
              if($total_reg > 0){ 

                for($i=0; $i < $total_reg; $i++){
                  foreach ($res[$i] as $key => $value){ }
                    ?>

                            <option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

                            <?php }

              }else{ 
                echo '<option value="">Cadastre um Gerente Administrador</option>';

              } ?>


                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Senha Gerente</label>
                        <input type="password" class="form-control" id="senha_gerente" name="senha_gerente"
                            placeholder="Senha Gerente" required="">
                    </div>

                    <small>
                        <div align="center" class="mt-1" id="mensagem-excluir">

                        </div>
                    </small>

                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar" class="btn btn-secondary"
                        data-bs-dismiss="modal">Fechar</button>
                    <button name="btn-excluir" id="btn-excluir" type="submit" class="btn btn-danger">Excluir</button>

                    <input name="id" type="hidden" id="id_deletar_item">

                </div>
            </form>
        </div>
    </div>
</div>







<div class="modal fade" tabindex="-1" id="modalVenda">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Fechar Venda - Total: <span id="total-modal-venda"></span></h4>
                <a type="button" class="btn-close" href="pdv.php" aria-label="Close"></a>
            </div>
            <form method="POST" id="form-fechar-venda">
                <div class="modal-body">


                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Cliente</label>
                                <select class="form-select mt-1 sel2" aria-label="Default select example" name="cliente"
                                    id="cliente" style="width:100%">
                                    <option value="">Selecionar Cliente</option>
                                    <?php 
                  $query = $pdo->query("SELECT * from clientes order by nome asc");
                  $res = $query->fetchAll(PDO::FETCH_ASSOC);
                  $total_reg = @count($res);
                  if($total_reg > 0){ 

                    for($i=0; $i < $total_reg; $i++){
                      foreach ($res[$i] as $key => $value){ }
                        ?>

                                    <option <?php if(@$cliente == $res[$i]['id']){ ?> selected <?php } ?>
                                        value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

                                    <?php }

                  } ?>


                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Vencimento</label>
                                <input type="date" name="data_pg" id="data_pg" class="form-control"
                                    value="<?php echo $data_hoje ?>">
                            </div>
                        </div>

                    </div>


                    <?php 
              $query = $pdo->query("SELECT * from forma_pgtos order by id asc limit 6");
              $res = $query->fetchAll(PDO::FETCH_ASSOC);
              $total_reg = @count($res);
              if($total_reg > 0){ 

                for($i=0; $i < $total_reg; $i++){
                  foreach ($res[$i] as $key => $value){ }
                    ?>
                    <span class=""><small><small><small><?php echo $i + 1 ?> - <?php echo $res[$i]['nome'] ?> /
                                </small></small></small></span>
                    <?php } } ?>

                    <div class="mb-3">

                        <select class="form-select form-select-sm mt-1" aria-label="Default select example"
                            name="forma_pgto" id="forma_pgto" onchange="mudarPgto()">
                            <?php 
              $query = $pdo->query("SELECT * from forma_pgtos order by id asc");
              $res = $query->fetchAll(PDO::FETCH_ASSOC);
              $total_reg = @count($res);
              if($total_reg > 0){ 

                for($i=0; $i < $total_reg; $i++){
                  foreach ($res[$i] as $key => $value){ }
                    ?>

                            <option value="<?php echo $res[$i]['codigo'] ?>"><?php echo $res[$i]['nome'] ?></option>

                            <?php }

              }else{ 
                echo '<option value="">Cadastre uma Forma de Pagamento</option>';

              } ?>


                        </select>
                    </div>


                    <div id="listar_pix" align="center">

                    </div>


                    <input type="hidden" id="textovenda">
                    <small>
                        <div align="center" class="mt-1" id="mensagem-venda">

                        </div>
                    </small>

                </div>
                <div class="modal-footer">
                    <a type="button" id="btn-fechar-venda" class="btn btn-secondary" href="pdv.php">Fechar</a>
                    <button name="btn-venda" id="btn-venda" type="submit" class="btn btn-success">Fechar Venda</button>


                </div>
            </form>
        </div>
    </div>
</div>




<input type="hidden" id="total_venda_sem_formatacao">



<div class="modal fade" tabindex="-1" id="modalBuscarProduto">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Buscar Produto </h4>
                <button id="btn-fechar-modal-prod" type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div>
                    <?php 
  $query = $pdo->query("SELECT * from produtos order by id desc");
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  $total_reg = @count($res);
  if($total_reg > 0){ 
    ?>
                    <small>
                        <table id="example" class="table table-hover my-4" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Código</th>
                                    <th>Estoque</th>
                                    <th>Valor</th>
                                    <th>Foto</th>


                                </tr>
                            </thead>
                            <tbody>

                                <?php 
          for($i=0; $i < $total_reg; $i++){
            foreach ($res[$i] as $key => $value){ }

              $id_cat = $res[$i]['categoria'];
            $query_2 = $pdo->query("SELECT * from categorias where id = '$id_cat'");
            $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
            $nome_cat = $res_2[0]['nome'];


            //BUSCAR OS DADOS DO FORNECEDOR
            $id_forn = $res[$i]['fornecedor'];
            $query_f = $pdo->query("SELECT * from fornecedores where id = '$id_forn'");
            $res_f = $query_f->fetchAll(PDO::FETCH_ASSOC);
            $total_reg_f = @count($res_f);
            if($total_reg_f > 0){ 
              $nome_forn = $res_f[0]['nome'];
              $tel_forn = $res_f[0]['telefone'];
            }else{
              $nome_forn = '';
              $tel_forn = '';
            }

            $cod_prod = $res[$i]['codigo'];

            ?>


                                <tr onclick="selecionarProduto('<?php echo $cod_prod ?>')">
                                    <td><?php echo $res[$i]['nome'] ?></td>
                                    <td><?php echo $res[$i]['codigo'] ?></td>
                                    <td><?php echo $res[$i]['estoque'] ?></td>
                                    <td>R$ <?php echo number_format($res[$i]['valor_venda'], 2, ',', '.'); ?></td>

                                    <td><img src="../img/produtos/<?php echo $res[$i]['foto'] ?>" width="40"></td>

                                </tr>


                                <?php } ?>

                            </tbody>

                        </table>
                    </small>
                    <?php }else{
    echo '<p>Não existem dados para serem exibidos!!';
  } ?>
                </div>

            </div>

        </div>

    </div>
</div>





<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>




<script type="text/javascript">
$(document).ready(function() {
    listarProdutos();
    buscarDados();
    document.getElementById('codigo').focus();
    document.getElementById('quantidade').value = '1';
    $('#imagem').attr('src', '../img/produtos/sem-foto.jpg');
});
</script>




<!--AJAX PARA BUSCAR DADOS PARA OS INPUTS -->


<script type="text/javascript">
var pag = "<?=$pag?>";

function buscarDados() {

    var valor_prod = $('#valor_unitario').val();

    $.ajax({
        url: pag + "/buscar-dados.php",
        method: 'POST',
        data: $('#form-buscar').serialize(),
        dataType: "html",

        success: function(result) {

            $('#mensagem-venda').text("");



            if (result.trim() === "Não é possível efetuar uma venda sem itens!") {
                $('#mensagem-venda').addClass('text-danger')
                $('#mensagem-venda').text(result)
                document.getElementById('forma_pgto_input').value = "";
                return;
            }

            var array = result.split("&-/z");

            if (array[0] === "Venda Salva!") {

                //$('#btn-fechar-venda').click();

                let a = document.createElement('a');
                a.target = '_blank';
                a.href = '../rel/comprovante.php?id=' + array[1];
                a.click();
                return;
            }


            if (array[0] === "Quantidade em Estoque Insuficiente!") {
                texto_msg = result.replace("&-/z", " ");
                alert(texto_msg)
                return;
            }

            if (array[0] === "Código do Produto não Encontrado!") {
                alert(array[0])
                return;
            }

            if (array[0] === "Preencha um Valor para o Produto!") {
                alert(array[0]);
                document.querySelector("#valor_unitario").select();
                return;
            }

            if (array[0] === "Selecione um Cliente!") {
                alert(array[0]);
                return;
            }





            if (array.length == 2) {
                var ms1 = array[0];
                var ms2 = array[1];

            } else {

                var estoque = array[0];
                var nome = array[1];
                var descricao = array[2];
                var imagem = array[3];
                var valor = array[4];
                var subtotal = array[5];
                var subtotalF = array[6];
                var totalVenda = array[7];
                var totalVendaF = array[8];
                var troco = array[9];
                var trocoF = array[10];
                console.log(result);



                document.getElementById('total_venda_sem_formatacao').value = totalVenda;

                document.getElementById('total_compra').value = 'R$ ' + totalVendaF;
                $('#total-modal-venda').text('R$ ' + totalVendaF);


                document.getElementById('valor_troco').value = 'R$ ' + trocoF;


                if (nome.trim() != "Código não Cadastrado") {

                    document.getElementById('estoque').value = estoque;
                    document.getElementById('produto').value = nome;
                    document.getElementById('descricao').value = descricao;
                    document.getElementById('valor_unitario').value = valor;

                    if (imagem.trim() === "") {
                        $('#imagem').attr('src', '../img/produtos/sem-foto.jpg');
                    } else {
                        $('#imagem').attr('src', '../img/produtos/' + imagem);
                    }


                    var audio = new Audio('../img/barCode.wav');
                    audio.addEventListener('canplaythrough', function() {
                        audio.play();
                    });


                    valor_format = "R$ " + valor.replace(".", ",");
                    document.getElementById('total_item').value = valor_format;

                    document.getElementById('sub_total_item').value = 'R$ ' + subtotalF;


                    document.getElementById('codigo').value = "";
                    document.getElementById('quantidade').value = "1";
                    document.getElementById('valor_unitario').value = "";
                    document.getElementById('codigo').focus();

                    listarProdutos();

                }

            }





        }

    });
}
</script>







<!--AJAX PARA MOSTRAR OS PRODUTOS DO ITEM DA VENDA -->

<script type="text/javascript">
var pag = "<?=$pag?>";

function listarProdutos() {
    $.ajax({
        url: pag + "/listar-produtos.php",
        method: 'POST',
        data: $('#form-buscar').serialize(),
        dataType: "html",

        success: function(result) {
            $("#listar").html(result);
        }

    });
}
</script>







<!--AJAX PARA EXCLUIR DADOS -->
<script type="text/javascript">
$("#form-excluir").submit(function() {
    var pag = "<?=$pag?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: pag + "/excluir-item.php",
        type: 'POST',
        data: formData,

        success: function(mensagem) {

            $('#mensagem').removeClass()

            if (mensagem.trim() == "Excluído com Sucesso!") {

                $('#mensagem-excluir').addClass('text-success')

                $('#btn-fechar').click();
                window.location = "pdv.php";

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
function modalExcluir(id) {
    event.preventDefault();

    document.getElementById('id_deletar_item').value = id;


    var myModal = new bootstrap.Modal(document.getElementById('modalDeletar'), {

    })

    myModal.show();
}
</script>




<script type="text/javascript">
$("#desconto").keyup(function() {
    buscarDados();
});
</script>


<script type="text/javascript">
$("#valor_recebido").keyup(function() {
    buscarDados();
});
</script>


<script type="text/javascript">
$(document).keyup(function(e) {

    if (e.keyCode === 113) {
        var myModal = new bootstrap.Modal(document.getElementById('modalVenda'), {})
        myModal.show();
    }


    if (e.keyCode === 18) {
        var myModal = new bootstrap.Modal(document.getElementById('modalBuscarProduto'), {})
        myModal.show();
    }


    var codigo = $("#codigo").val();
    if (codigo === '') {
        if ($("#textovenda").val() === '') {
            if (e.keyCode === 13) {
                $("#textovenda").val('aberto');
                var myModal = new bootstrap.Modal(document.getElementById('modalVenda'), {
                    backdrop: 'static',
                })

                myModal.show();
            }

            $("#textovenda").val('1');
        } else {

            if (e.keyCode === 13) {
                $('#btn-venda').click();
            }

            if (e.keyCode === 49 || e.keyCode === 97) {

                document.getElementById("forma_pgto").options.selectedIndex = 0;
                $('#forma_pgto').val($('#forma_pgto').val()).change();
            }

            if (e.keyCode === 50 || e.keyCode === 98) {
                document.getElementById("forma_pgto").options.selectedIndex = 1;
                $('#forma_pgto').val($('#forma_pgto').val()).change();
            }

            if (e.keyCode === 51 || e.keyCode === 99) {
                document.getElementById("forma_pgto").options.selectedIndex = 2;
                $('#forma_pgto').val($('#forma_pgto').val()).change();
            }


            if (e.keyCode === 52 || e.keyCode === 100) {
                document.getElementById("forma_pgto").options.selectedIndex = 3;
                $('#forma_pgto').val($('#forma_pgto').val()).change();
            }

            if (e.keyCode === 53 || e.keyCode === 101) {
                document.getElementById("forma_pgto").options.selectedIndex = 4;
                $('#forma_pgto').val($('#forma_pgto').val()).change();
            }

            if (e.keyCode === 54 || e.keyCode === 102) {
                document.getElementById("forma_pgto").options.selectedIndex = 5;
                $('#forma_pgto').val($('#forma_pgto').val()).change();
            }



            if (e.keyCode === 17) {
                verificarPgto();
            }

        }

    } else {
        if (e.which == 13) {
            buscarDados();
        }
    }




});
</script>



<script type="text/javascript">
$("#form-fechar-venda").submit(function() {
    event.preventDefault();
    var pgto = document.getElementById('forma_pgto').value;
    document.getElementById('forma_pgto_input').value = pgto;

    var cliente = document.getElementById('cliente').value;
    document.getElementById('cliente_input').value = cliente;

    var data_pgto = document.getElementById('data_pg').value;
    document.getElementById('data_pgto').value = data_pgto;

    buscarDados();

    setTimeout(function() {
        location.reload();
    }, 2000)
})
</script>


<link rel="stylesheet" type="text/css" href="../vendor/DataTables/datatables.min.css" />

<script type="text/javascript" src="../vendor/DataTables/datatables.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable({
        "ordering": false
    });

    //$('#example_filter label input').focus();
});
</script>


<script type="text/javascript">
function selecionarProduto(codigo) {
    $('#codigo').val(codigo);
    $('#btn-fechar-modal-prod').click();
    document.querySelector("#quantidade").select();
}
</script>







<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    $('.sel2').select2({
        dropdownParent: $('#modalVenda')
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
function mudarPgto() {
    var pgto = $('#forma_pgto').val();
    var valor = $('#total_venda_sem_formatacao').val();
    $("#listar_pix").html('');

    $.ajax({
        url: "../pix/pix.php",
        method: 'POST',
        data: {
            pgto,
            valor
        },
        dataType: "html",

        success: function(result) {
            $("#listar_pix").html(result);
        }

    });

    setInterval(verificarPgto, 10000);
}


function verificarPgto() {

    var ref = $("#id_ref").val();

    $.ajax({
        url: "../pix/verificar_pgto.php",
        method: 'POST',
        data: {
            ref
        },
        dataType: "html",

        success: function(result) {
            $('#span_ctrl').removeClass()

            if (result.trim() === 'Pagamento Aprovado!') {
                $('#span_ctrl').addClass('text-success')
            } else {
                $('#span_ctrl').addClass('text-danger')
            }

            $("#span_ctrl").text(result);
        }

    });
}
</script>