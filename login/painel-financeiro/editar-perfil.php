<?php 
require_once("../conexao.php");

$nome = $_POST['nome-perfil'];
$email = $_POST['email-perfil'];
$telefone = $_POST['telefone-perfil'];
$senha = $_POST['senha-perfil'];
$conf_senha = $_POST['conf-senha-perfil'];
$genero = $_POST['genero-perfil'];
$id = $_POST['id-perfil'];


$antigo = $_POST['antigo-perfil'];
$antigo2 = $_POST['antigo2-perfil'];



if($senha != $conf_senha){
	echo 'As senhas são diferentes!!';
	exit();
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


if($antigo != $telefone){
	// EVITAR DUPLICIDADE NO telefone
		$query_con = $pdo->prepare("SELECT * from usuarios WHERE telefone = :telefone");
		$query_con->bindValue(":telefone", $telefone);
		$query_con->execute();
		$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
		if(@count($res_con) > 0){
			echo 'O telefone do usuário já está cadastrado!';
			exit();
		}
	}
	




	$res = $pdo->prepare("UPDATE usuarios SET nome = :nome, email = :email, telefone = :telefone, senha = :senha, genero = :genero WHERE id = :id");
	$res->bindValue(":nome", $nome);
	$res->bindValue(":genero", $genero);
	$res->bindValue(":email", $email);
	$res->bindValue(":telefone", $telefone);
	$res->bindValue(":senha", $senha);
	
	$res->bindValue(":id", $id);
	$res->execute();



echo 'Salvo com Sucesso!';
?>