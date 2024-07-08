<?php 
    include('config/ligacao_db.php');

    //Condição para verificar se existem dados para enviar ler.
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

    
    $composicao = $nome = $preço = $taxaIVA = '';
    $erros = array('nome' => '', 'composicao' => '', 'preço' => '', 'taxaIVA' => '', 'cod_produto' => '');

    if(isset($_POST['submit'])){
        //check nome
        if(empty($_POST['nome'])){
            $erros['nome'] =  '*o nome do produto é obrigatório <br />';
        } else {
            $nome = $_POST['nome'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $nome)){ //A condição diz que o 'nome' tem de começar por um caracter de a a z maiusculo ou minusculo.
                $erros['nome'] = '*o nome do produto deve ser apenas letras e espaços <br />';
            }
        }

        //preg_match - 2 args (expressão regular, composicao propriamente dita)
        // - verifica se o nome apenas contem letras e espaços e é separado por virgulas
        //check composicao
        if(empty($_POST['composicao'])){
            $erros['composicao'] =  '*pelo menos um ingrediente é obrigatório <br />';
        } else {
            $composicao = $_POST['composicao'];
            if(!preg_match('/^([a-zA-Z0-9\s]+)(,\s*[a-zA-Z0-9\s]*)*$/', $composicao)){
                $erros['composicao'] = '*o nome do produto deve ser apenas letras e espaços <br />';
            }
        }

        //check preço
        if(empty($_POST['preço'])){
            $erros['preço'] =  '*o preço do produto é obrigatório <br />';
        } else {
            $preço = $_POST['preço'];
            if(!preg_match('/^\d+(\.\d{1,2})?$/', $preço)){
                $erros['preço'] = '*o preço do produto deve ser apenas números <br />';
            }
        }

        //check taxaIVA
        if(empty($_POST['taxaIVA'])){
            $erros['taxaIVA'] =  '*o taxaIVA do produto é obrigatório <br />';
        } else {
            $taxaIVA = $_POST['taxaIVA'];
            if(!preg_match('/^(100|[1-9]?[0-9])$/', $taxaIVA)){
                $erros['taxaIVA'] = '*o taxaIVA do produto deve ser apenas números <br />';
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
            $composicao = mysqli_real_escape_string($ligacao, $_POST['composicao']);
            $preço = mysqli_real_escape_string($ligacao, $_POST['preço']);
            $taxaIVA = mysqli_real_escape_string($ligacao, $_POST['taxaIVA']);

            //Inserir dados na BD
            $sql = "INSERT INTO produto(nome, composicao, preço, taxaIVA) VALUES('$nome', '$composicao', '$preço', '$taxaIVA')";

            //Guardar na BD e verificar
            if(mysqli_query($ligacao, $sql)){
                //Sucesso
                header('Location: display_produto.php');
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
        <h4 class="center">Adicionar Produto</h4>
        <form action="" class="white" action="add_produto.php" method="POST">
            <label>Nome:</label>
            <input type="text" name="nome" value="<?php echo htmlspecialchars($nome)?>">
            <div class="red-text"><?php echo $erros['nome']; ?></div>
            <label>Composição (Separar por virgula):</label>
            <input type="text" name="composicao" value="<?php echo htmlspecialchars($composicao)?>">
            <div class="red-text"><?php echo $erros['composicao']; ?></div>
            <label>Preço:</label>
            <input type="text" name="preço" value="<?php echo htmlspecialchars($preço)?>">
            <div class="red-text"><?php echo $erros['preço']; ?></div>
            <label>taxaIVA(%):</label>
            <input type="text" name="taxaIVA" value="<?php echo htmlspecialchars($taxaIVA)?>">
            <div class="red-text"><?php echo $erros['taxaIVA']; ?></div>
            <div class="center">
                <input type="submit" name="submit" value="Adicionar" class="btn brand z-depth-0">
                <a href="display_produto.php" class="btn brand z-depth-0">Voltar</a>
            </div>
        </form>
    </section> 

    <?php include('templates/footer.php') ?>
</html>