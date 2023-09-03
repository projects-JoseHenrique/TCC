<?php 
require_once("../../conexao.php");

$nome = $_POST['nome'];
$email = $_POST['email'];
$cpf = $_POST['cpf'];
$senha = $_POST['senha'];
$senha_crip = md5($senha);
$conf_senha = $_POST['conf_senha'];
$nivel = $_POST['nivel'];
$endereco = $_POST['endereco'];
$id = $_POST['id'];

$foto = '';

if($senha != $conf_senha){
	echo 'As senhas são diferentes!!';
	exit();
}

$antigo = $_POST['antigo'];
$antigo2 = $_POST['antigo2'];

// EVITAR DUPLICIDADE NO EMAIL
if($antigo2 != $email){
	$query_con = $pdo->prepare("SELECT * from usuarios WHERE email = :email");
	$query_con->bindValue(":email", $email);
	$query_con->execute();
	$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res_con) > 0){
		echo 'O email do usuário já está cadastrado!';
		exit();
	}
}

if($antigo != $cpf){
// EVITAR DUPLICIDADE NO CPF
	$query_con = $pdo->prepare("SELECT * from usuarios WHERE cpf = :cpf");
	$query_con->bindValue(":cpf", $cpf);
	$query_con->execute();
	$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res_con) > 0){
		echo 'O CPF do usuário já está cadastrado!';
		exit();
	}
}



//SCRIPT PARA SUBIR FOTO NO BANCO
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['imagem']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = '../../img/produtos/' .$nome_img;
if (@$_FILES['imagem']['name'] == ""){
  $imagem = "sem-foto.jpg";
}else{
    $imagem = $nome_img;
}

$imagem_temp = @$_FILES['imagem']['tmp_name']; 
$ext = pathinfo($imagem, PATHINFO_EXTENSION);   
if($ext == 'JPG' or $ext == 'jpg' or $ext == 'jpeg'){ 
move_uploaded_file($imagem_temp, $caminho);
}else{
	echo 'Extensão de Imagem não permitida, use somente imagem jpg!!';
	exit();
}



if ($id == "") {
    $res = $pdo->prepare("INSERT INTO usuarios (nome, email, cpf, senha, senha_crip, nivel, foto, endereco) VALUES (:nome, :email, :cpf, :senha, :senha_crip, :nivel, :foto, :endereco)");
    $res->bindValue(":nome", $nome);
    $res->bindValue(":email", $email);
    $res->bindValue(":cpf", $cpf);
    $res->bindValue(":senha", $senha);
    $res->bindValue(":senha_crip", $senha_crip);
    $res->bindValue(":nivel", $nivel);
    $res->bindValue(":foto", $foto);
    $res->bindValue(":endereco", $endereco);
    $res->execute();
} else {
    $res = $pdo->prepare("UPDATE usuarios SET nome = :nome, email = :email, cpf = :cpf, senha = :senha, senha_crip = :senha_crip, nivel = :nivel, foto = :foto, endereco = :endereco WHERE id = :id");
    $res->bindValue(":nome", $nome);
    $res->bindValue(":email", $email);
    $res->bindValue(":cpf", $cpf);
    $res->bindValue(":senha", $senha);
    $res->bindValue(":senha_crip", $senha_crip);
    $res->bindValue(":nivel", $nivel);
    $res->bindValue(":foto", $foto);
    $res->bindValue(":endereco", $endereco);
    $res->bindValue(":id", $id);
    $res->execute();
}




echo 'Salvo com Sucesso!';
?>