<?php
require_once('../conexao.php');
require_once('verificar-permissao.php');

$id_usuario = $_SESSION['id_usuario'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div>
        <a href="pdv.php" class="btn btn-danger btn-lg " role="button" aria-pressed="true">SAIR</a>
    </div>
    <a href="pdv.php" class="btn btn-success btn-lg " role="button" aria-pressed="true">SISTEMA PDV</a>
</body>
</html>