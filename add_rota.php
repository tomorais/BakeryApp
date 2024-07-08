<?php 
    include('config/ligacao_db.php');

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

    
    $nome = $distribuidor = '';
    $erros = array('nome' => '', 'distribuidor' => '', 'cod_rota' => '');

    if(isset($_POST['submit'])){
        //check nome
        if(empty($_POST['nome'])){
            $erros['nome'] =  '*o nome da rota é obrigatório <br />';
        } else {
            $nome = $_POST['nome'];
            if(!preg_match('/^[a-zA-Z0-9\s]+$/', $nome)){ //A condição diz que o 'nome' tem de começar por um caracter de a a z maiusculo ou minusculo.
                $erros['nome'] = '*o nome da rota deve ser apenas letras e espaços <br />';
            }
        }

        //check distribuidor
        if(empty($_POST['distribuidor'])){
            $erros['distribuidor'] =  '*o nome do distribuidor é obrigatório <br />';
        } else {
            $distribuidor = $_POST['distribuidor'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $distribuidor)){ //A condição diz que o 'nome' tem de começar por um caracter de a a z maiusculo ou minusculo.
                $erros['distribuidor'] = '*o nome do distribuidor deve ser apenas letras e espaços <br />';
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
            

            //Inserir dados na BD
            $sql = "INSERT INTO rota(nome, distribuidor) VALUES('$nome', '$distribuidor')";

            //Guardar na BD e verificar
            if(mysqli_query($ligacao, $sql)){
                //Sucesso
                header('Location: display_rota.php');
            } else {
                //Erro
                echo 'Erro na query: ' . mysqli_error($ligacao);
            }
        }
    } //Fim do POST check

?>

  <!DOCTYPE html>
<html>
    <?php include('templates/header.php') ?>

    <section class="container grey-text">
        <h4 class="center">Adicionar Rota</h4>
        <form action="" class="white" action="add_rota.php" method="POST">
            <label>Nome da Rota:</label>
            <input type="text" name="nome" value="<?php echo htmlspecialchars($nome)?>">
            <div class="red-text"><?php echo $erros['nome']; ?></div>
            <label>Nome do Distribuidor:</label>
            <input type="text" name="distribuidor" value="<?php echo htmlspecialchars($distribuidor)?>">
            <div class="red-text"><?php echo $erros['distribuidor']; ?></div>
            
            <div class="center">
                <input type="submit" name="submit" value="Adicionar" class="btn brand z-depth-0">
                <a href="display_rota.php" class="btn brand z-depth-0">Voltar</a>
            </div>
        </form>
    </section> 

    <?php include('templates/footer.php') ?>
</html>