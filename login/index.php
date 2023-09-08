<?php
require_once("conexao.php");

// INSERIR UM USUÁRIO ADMINISTRADOR CASO NÃO EXISTA
$senha = '123';
$senha_crip = md5($senha);

$query = $pdo->query("SELECT * FROM usuarios WHERE nivel = 'Administrador'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg == 0) {
    // Substitua '$email_sistema' pelo valor desejado para o email
    $email_sistema = 'seu@email.com';
    
    $pdo->query("INSERT INTO usuarios SET nome = 'tcc', email = '$email_sistema', senha = '$senha', senha_crip = '$senha_crip', nivel = 'Administrador'");
}






?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Administração</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="./img/favicon.ico">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css/main.css">
    <link rel="stylesheet" type="text/css" href="vendor/css/util.css">
    <!--===============================================================================================-->


</head>

<body class="body">

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
                <form class="login100-form validate-form" action="autenticar.php" method="POST">
                    <div class="circular-image">
                        <img src="./img/img--login.png" alt="Ícone de Login">
                    </div>

                    <div class="wrap-input100 validate-input m-b-23" data-validate="Digite seu nome de usuário">
                        <label for="usuario" class="col-md-3 col-sm-3 form-label"><span class="login"
                                style="color: #00008b;"><b>Usuário:</b></span></label>
                        <input class="input100" type="text" name="usuario" placeholder="Digite seu usuário"
                            id="usuario">
                        <span class="focus-input100"><img src="img/pessoa.png" alt="Ícone de cadeado"
                                style="margin-top:49px; width:20px;"></span>

                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Digite sua senha">
                        <label for="senha" class="col-md-3 col-sm-3 form-label"
                            style="color: #00008b;"><b>Senha:</b></label>
                        <input class="input100" type="password" name="senha" placeholder="Digite sua senha"
                            id="password">
                        <span class="focus-input100"><img src="img/cadeado-fechado.png" alt="Ícone de cadeado"
                                style="margin-top:49px; width:20px;"></span>
                        <img src="img/olho-aberto.png" alt="Ícone de olho" class="password-icon" id="toggleIcon"
                            style="position: absolute; top: 70%; right: 5px; transform: translateY(-50%); width: 24px;"
                            onclick="togglePasswordVisibility()">

                    </div>


                    <div class="mt-4"></div>

                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn">
                                ENTRAR
                            </button>

                        </div>

                        <div class="mt-3">
                            <button type="button" class="btn btn-outline-info" onclick="window.location.href='../'">
                                <i class="bi bi-box-arrow-left"></i> SAIR
                            </button>
                        </div>


                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>

</div>

<script>
const passwordInput = document.getElementById('password');
const toggleIcon = document.getElementById('toggleIcon');
let isPasswordVisible = false;

toggleIcon.addEventListener('click', function() {
    if (isPasswordVisible) {
        passwordInput.type = 'password';
        toggleIcon.src = 'img/olho-aberto.png';
    } else {
        passwordInput.type = 'text';
        toggleIcon.src = 'img/olho-fechado.png';
    }

    isPasswordVisible = !isPasswordVisible;
});
</script>


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<!--===============================================================================================-->
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/bootstrap/js/popper.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/daterangepicker/moment.min.js"></script>
<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script src="js/main.js"></script>