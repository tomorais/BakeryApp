<?php 
    include('config/ligacao_db.php');
    $rota_modify =[];

    if (isset($_POST['id'])) {
        $id_rota = $_POST['id'];
    }
    else {
        print_r('Variavel nao encontrado');
    }

    //Obter os dados do produto com o cod_produto passado acima
    //Query para obter todos os produtos
    $sql_modify = "SELECT * FROM rota WHERE cod_rota = $id_rota";

    //Executar a query
    $resultado_modify = mysqli_query($ligacao, $sql_modify);

    //obter as linhas resultantes em forma de array
    $rota_modify = mysqli_fetch_assoc($resultado_modify);

    mysqli_free_result($resultado_modify);
    //mysqli_close($ligacao);
    
    
    //Condição para verificar se existem dados para enviar ler.
    #Condição para verificar se existem dados para enviar ler.
    #Se existirem, então é feita a conexão à base de dados 
    #e é feita a inserção dos dados na tabela produtos.
    #Caso contrario, é apenas mostrado o formulário para adicionar produtos.
    //serve para prevenir no caso de algum user introduzir codigo malicioso
    //num dos campos a preencher
    //htmlspecialchars - pega nos dados introduzidos e converte para entidades html
    //Entidades html são strings seguras para caracteres especiais
    //if...else para verificar se os campos estao vazios
    //preg_match - 2 args (expressão regular, nome propriamente dito)
    // - verifica se o nome apenas contem letras e espaços

    $nome = $rota_modify['nome'];
    $distribuidor = $rota_modify['distribuidor'];
    $erros = array('nome' => '', 'distribuidor' => '', 'cod_rota' => '');

    if(isset($_POST['submit'])){
        //check distribuidor
        if(empty($_POST['distribuidor'])){
            $erros['distribuidor'] =  '*o nome do distribuidor é obrigatório <br />';
        } else {
            $nome = $_POST['distribuidor'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $distribuidor)){ //A condição diz que o 'nome' tem de começar por um caracter de a a z maiusculo ou minusculo.
                $erros['distribuidor'] = '*o nome do distribuidor deve ser apenas letras e espaços <br />';
            }
        }

        //check nome
        if(empty($_POST['nome'])){
            $erros['nome'] =  '*o nome da rota é obrigatório <br />';
        } else {
            $nome = $_POST['nome'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $nome)){ //A condição diz que o 'nome' tem de começar por um caracter de a a z maiusculo ou minusculo.
                $erros['nome'] = '*o nome da rota deve ser apenas letras e espaços <br />';
            }
        }

        //Verifica se existem erros no array
        //Se existirem retorna true e irá devolver uma mensagem de erro
        //Caso contrario retorna False e irá redirecionar para a pagina inicial
        if(array_filter($erros)){
            //echo 'erros no formulario';
        } else {
            //Função para proteger a BD de injeção de dados maliciosos na BD
            $nome = mysqli_real_escape_string($ligacao, $_POST['nome']);
            $distribuidor = mysqli_real_escape_string($ligacao, $_POST['distribuidor']);
        }
    } //Fim do POST check

?>

<!DOCTYPE html>
<html>
    <?php include('templates/header.php') ?>

    <section class="container grey-text">
        <h4 class="center">Alterar Rota</h4>
        <form action="update_rota.php" class="white" method="POST">
        <input type="hidden" name="id_rota" value="<?php echo $id_rota; ?>">
            <label>Nome do Distribuidor:</label>
            <input type="text" name="distribuidor" value="<?php echo htmlspecialchars($distribuidor)?>">
            <div class="red-text"><?php echo $erros['distribuidor']; ?></div>
            <label>Nome da Rota:</label>
            <input type="text" name="nome" value="<?php echo htmlspecialchars($nome)?>">
            <div class="red-text"><?php echo $erros['nome']; ?></div>
            <div class="center">
                <input type="submit" name="submit" value="Alterar" class="btn brand z-depth-0">
                <a href="display_rota.php" class="btn brand z-depth-0">Voltar</a>
            </div>
        </form>
    </section> 

    <?php include('templates/footer.php') ?>
</html>