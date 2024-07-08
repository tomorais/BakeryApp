<?php 
    include('config/ligacao_db.php');

    $id_pe = '';
    if (isset($_POST['id_pe'])) {
        $id_pe = $_POST['id_pe'];
    }
    else {
        print_r('Variavel nao encontrado');
    }

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

    
    $nome_cliente = $Data_ = $NIF = '';
    $cod_pe = $id_pe;
    $erros = array('nome_cliente' => '', 'Data_' => '', 'NIF' => '', 'cod_pe' => '', 'cod_ne' => '');

    if(isset($_POST['submit'])){
        //check nome_cliente
        if(empty($_POST['nome_cliente'])){
            $erros['nome_cliente'] =  '*o nome do cliente é obrigatório <br />';
        } else {
            $nome_cliente = $_POST['nome_cliente'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $nome_cliente)){ //A condição diz que o 'nome' tem de começar por um caracter de a a z maiusculo ou minusculo.
                $erros['nome_cliente'] = '*o nome do cliente deve ser apenas letras e espaços <br />';
            }
        }

        //preg_match - 2 args (expressão regular, composicao propriamente dita)
        // - verifica se o nome apenas contem letras e espaços e é separado por virgulas
        //check Data_
        if(empty($_POST['Data_'])){
            $erros['Data_'] =  '*a data é obrigatória <br />';
        } else {
            $Data_ = $_POST['Data_'];
            if(!preg_match('/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-202[0-9]/', $Data_)){
                $erros['Data_'] = '*data deve estar no formato dd-mm-aaaa <br />';
            }
        }

        //check NIF
        if(empty($_POST['NIF'])){
            $erros['NIF'] =  '*o NIF é obrigatório <br />';
        } else {
            $NIF = $_POST['NIF'];
            if(!preg_match('/^\d+(\[0-9]{9})?$/', $NIF)){
                $erros['NIF'] = '*o NIF deve conter apenas números <br />';
            }
        }

        //Verifica se existem erros no array
        //Se existirem retorna true e irá devolver uma mensagem de erro
        //Caso contrario retorna False e irá redirecionar para a pagina inicial
        if(array_filter($erros)){
            //echo 'erros no formulario';
        } else {
            //Função para proteger a BD de injeção de dados maliciosos na BD
            $nome_cliente = mysqli_real_escape_string($ligacao, $_POST['nome_cliente']);
            $Data_ = mysqli_real_escape_string($ligacao, $_POST['Data_']);
            $NIF = mysqli_real_escape_string($ligacao, $_POST['NIF']);
            $cod_pe = mysqli_real_escape_string($ligacao, $_POST['id_pe']);

            //Inserir dados na BD
            $sql_encomenda = "INSERT INTO encomenda(nome_cliente, NIF, Data_, cod_pe) VALUES('$nome_cliente', '$NIF', '$Data_','$id_pe')";

            //Guardar na BD e verificar
            if(mysqli_query($ligacao, $sql_encomenda)){
                //Sucesso
                header('Location: display_encomendas.php');
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
        <h4 class="center">Adicionar Encomenda</h4>
        <form action="add_encomenda.php" class="white" method="POST">
        <input type="hidden" name="id_pe" value="<?php echo $id_pe; ?>">
            <label>Nome do Cliente:</label>
            <input type="text" name="nome_cliente" value="<?php echo htmlspecialchars($nome_cliente)?>">
            <div class="red-text"><?php echo $erros['nome_cliente']; ?></div>
            <label>Data:</label>
            <input type="text" name="Data_" value="<?php echo htmlspecialchars($Data_)?>">
            <div class="red-text"><?php echo $erros['Data_']; ?></div>
            <label>NIF:</label>
            <input type="text" name="NIF" value="<?php echo htmlspecialchars($NIF)?>">
            <div class="red-text"><?php echo $erros['NIF']; ?></div>
            <div class="center">
                <input type="submit" name="submit" class="btn brand z-depth-0" value="Encomendar" >
                <a href="index.php" class="btn brand z-depth-0">Cancelar</a>
            </div>
        </form>
    </section>

    <?php include('templates/footer.php') ?>
</html>