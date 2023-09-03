<?php 
@session_start();

//VERIFICAR PERMISSÃO DO USUÁRIO
if(@$_SESSION['nivel_usuario'] != 'Operador' and @$_SESSION['nivel_usuario'] != 'Financeiro'){
	echo "<script language='javascript'>window.location='../index.php'</script>";
}

 ?>