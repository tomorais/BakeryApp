<style>
    .input-field input:focus + label,
    .input-field input:valid + label {
        display: none;
    }
</style>

<?php
session_start();

// Conexão à BD
include('config/ligacao_db.php');

// Inicializar variáveis
$distribuidor = $password = '';
$erros = array('distribuidor' => '', 'password' => '');

// Verificar se o formulário foi submetido
if(isset($_POST['action'])){

    // Check distribuidor
    if(empty($_POST['distribuidor'])){
        $erros['distribuidor'] = '*o nome do utilizador é obrigatório <br />';
    } else {
        $distribuidor = $_POST['distribuidor'];
        if($distribuidor !== 'admin' && !preg_match('/^([a-zA-Z\s]+)$/', $distribuidor)){
            $erros['distribuidor'] = '*o nome do distribuidor deve ser um nome válido <br />';
        }
    }

    // Check password
    if(empty($_POST['password'])){
        $erros['password'] = '*a password é obrigatória <br />';
    } else {
        $password = $_POST['password'];
        if($distribuidor !== 'admin' && !ctype_digit($password)){
            $erros['password'] = '*a password deve ser um número válido <br />';
        }
    }

    // Verifica se existem erros no array
    if(array_filter($erros)){
        // Existem erros no formulário
    } else {
        // Função para proteger a BD de injeção de dados maliciosos na BD
        $distribuidor = mysqli_real_escape_string($ligacao, $_POST['distribuidor']);
        $password = mysqli_real_escape_string($ligacao, $_POST['password']);

        if($distribuidor === 'admin') {
            // Verificação especial para admin
            $admin_password = 'admin'; // Defina a senha do admin
            if($password === $admin_password){
                $_SESSION['distribuidor'] = $distribuidor;
                $_SESSION['is_admin'] = true; // Indica que este é um usuário admin
                header('Location: index.php'); // Redireciona para a página do admin
            } else {
                $erros['password'] = '*Senha do admin incorreta';
            }
        } else {
            // Query para obter o distribuidor e verificar a senha (id)
            $sql = "SELECT * FROM rota WHERE distribuidor = '$distribuidor' AND cod_rota = '$password'";

            // Executar a query e verificar
            $resultado = mysqli_query($ligacao, $sql);

            // Verificar se existe algum resultado
            if(mysqli_num_rows($resultado) == 1){
                // Login bem-sucedido
                $_SESSION['distribuidor'] = $distribuidor;
                $_SESSION['password'] = $password;
                header('Location: display_encomendas_dist.php');
            } else {
                // Erro de login
                $erros['login'] = 'Nome de utilizador ou senha incorretos.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <?php include('templates/header.php') ?>

    <!-- FORMULÁRIO DE LOGIN -->
    <div class="container valign-wrapper" style="height: 100vh;">
        <div class="row center-align" style="width: 100%;">
            <div class="col s12 m8 offset-m2 l6 offset-l3">
                <form class="col s12" action="login.php" method="post">
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" id="distribuidor" name="distribuidor" required>
                            <label for="distribuidor">Utilizador</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="password" id="password" name="password" required>
                            <label for="password">Password</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 center-align">
                            <button class="btn waves-effect waves-light red" type="submit" name="action">Login
                                <i class="material-icons right"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include('templates/footer.php') ?>
</html>