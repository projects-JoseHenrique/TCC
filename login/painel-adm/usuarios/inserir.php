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
$genero = $_POST['genero'];
$telefone = $_POST['telefone'];
$id = $_POST['id'];

if($senha != $conf_senha){
	echo 'As senhas são diferentes!!';
	exit();
}

$antigo = $_POST['antigo'];
$antigo2 = $_POST['antigo2'];
$antigo3 = $_POST['antigo3'];


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

 // EVITAR DUPLICIDADE DE TELEFONE
if($antigo3 != $telefone){
        $query_con = $pdo->prepare("SELECT * from usuarios WHERE telefone = :telefone");
        $query_con->bindValue(":telefone", $telefone);
        $query_con->execute();
        $res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
        if(@count($res_con) > 0){
            echo 'O telefone do usuário já está cadastrado!';
            exit();
        }
    }


if ($id == "") {
    $res = $pdo->prepare("INSERT INTO usuarios (nome, telefone, email, cpf, senha, senha_crip, nivel, genero, endereco) VALUES (:nome, :telefone, :email, :cpf, :senha, :senha_crip, :nivel, :genero, :endereco)");
    $res->bindValue(":nome", $nome);
    $res->bindValue(":telefone", $telefone);
    $res->bindValue(":email", $email);
    $res->bindValue(":cpf", $cpf);
    $res->bindValue(":senha", $senha);
    $res->bindValue(":senha_crip", $senha_crip);
    $res->bindValue(":nivel", $nivel);
    $res->bindValue(":endereco", $endereco);
    $res->bindValue(":genero", $genero); // Insira o gênero no banco de dados
    $res->execute();
} else {
    $res = $pdo->prepare("UPDATE usuarios SET nome = :nome, telefone = :telefone, email = :email, cpf = :cpf, senha = :senha, senha_crip = :senha_crip, nivel = :nivel, genero = :genero, endereco = :endereco WHERE id = :id");
    $res->bindValue(":nome", $nome);
    $res->bindValue(":telefone", $telefone);
    $res->bindValue(":email", $email);
    $res->bindValue(":cpf", $cpf);
    $res->bindValue(":senha", $senha);
    $res->bindValue(":senha_crip", $senha_crip);
    $res->bindValue(":nivel", $nivel);
    $res->bindValue(":genero", $genero); // Atualize o gênero no banco de dados
    $res->bindValue(":endereco", $endereco);
    $res->bindValue(":id", $id);
    $res->execute();
}

echo 'Salvo com Sucesso!';

?>