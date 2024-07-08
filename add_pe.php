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

    
    $morada = $nome = /*$coordenada1 = $coordenada2 = */ $cod_rota = '';
    $erros = array('nome' => '', 'morada' => '', 'cod_rota' => '', 'cod_pe' => '');

    if(isset($_POST['submit'])){
        //check nome
        if(empty($_POST['nome'])){
            $erros['nome'] =  '*o nome do ponto de entrega é obrigatório <br />';
        } else {
            $nome = $_POST['nome'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $nome)){ 
                $erros['nome'] = '*o nome da rota deve ser apenas letras e espaços <br />';
            }
        }
        
        //check morada
        if(empty($_POST['morada'])){
            $erros['morada'] =  '*a morada é obrigatória <br />';
        } else {
            $morada = $_POST['morada'];
            if(!preg_match('/^([a-zA-Z0-9\s]+)(,\s*[a-zA-Z0-9\s]*)*$/', $morada)){ 
                $erros['coordenada1'] = '*o valor da coordenada deve ser apenas algarismos <br />';
            }
        }

        //check coordenada1
        /*if(empty($_POST['coordenada1'])){
            $erros['coordenada1'] =  '*o valor da coordenada é obrigatória <br />';
        } else {
            $coordenada1 = $_POST['coordenada1'];
            if(!preg_match('/^\d+(\.\d{1,2})?$/', $coordenada1)){ 
                $erros['coordenada1'] = '*o valor da coordenada deve ser apenas algarismos <br />';
            }
        }

        //check coordenada2
        if(empty($_POST['coordenada2'])){
            $erros['coordenada2'] =  '*o valor da coordenada é obrigatória <br />';
        } else {
            $coordenada2 = $_POST['coordenada2'];
            if(!preg_match('/^\d+(\.\d{1,2})?$/', $coordenada2)){ 
                $erros['coordenada2'] = '*o valor da coordenada deve ser apenas algarismos <br />';
            }
        }*/

        //check cod_rota
        if(empty($_POST['cod_rota'])){
            $erros['cod_rota'] =  '*o codigo da rota é obrigatório <br />';
        } else {
            $cod_rota = $_POST['cod_rota'];
            if(!preg_match('/^\d+(\[0-9]{9})?$/', $cod_rota)){ 
                $erros['cod_rota'] = '*o codigo da rota deve ser apenas algarismos <br />';
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
            $morada = mysqli_real_escape_string($ligacao, $_POST['morada']);
            //$coordenada1 = mysqli_real_escape_string($ligacao, $_POST['coordenada1']);
            //$coordenada2 = mysqli_real_escape_string($ligacao, $_POST['coordenada2']);
            $cod_rota = mysqli_real_escape_string($ligacao, $_POST['cod_rota']);

            //Inserir dados na BD
            $sql = "INSERT INTO ponto_entrega(nome, morada, cod_rota) VALUES('$nome', '$morada', '$cod_rota')"; 

            //Guardar na BD e verificar
            if(mysqli_query($ligacao, $sql)){
                //Sucesso
                header('Location: index.php');
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
        <h4 class="center">Adicionar Ponto de Entrega</h4>
        <form action="" class="white" action="add_pe.php" method="POST">
            <label>Nome do Ponto de Entrega:</label>
            <input type="text" name="nome" value="<?php echo htmlspecialchars($nome)?>">
            <div class="red-text"><?php echo $erros['nome']; ?></div>
           <label> Morada:</label>
            <input type="text" name="morada" value="<?php echo htmlspecialchars($morada)?>">
            <div class="red-text"><?php echo $erros['morada']; ?></div> 
            <!-- <label>Coordenada 1(Latitude):</label>
            <input type="text" name="coordenada1" value="<?php echo htmlspecialchars($coordenada1)?>">
            <div class="red-text"><?php echo $erros['coordenada1']; ?></div>
            <label>Coordenada 2(Longitude):</label>
            <input type="text" name="coordenada2" value="<?php echo htmlspecialchars($coordenada2)?>">
            <div class="red-text"><?php echo $erros['coordenada2']; ?></div>-->
            <label> Codigo da Rota:</label>
            <input type="text" name="cod_rota" value="<?php echo htmlspecialchars($cod_rota)?>">
            <div class="red-text"><?php echo $erros['cod_rota']; ?></div>
            <div class="center">
                <input type="submit" name="submit" value="Adicionar" class="btn brand z-depth-0">
                <a href="display_rota.php" class="btn brand z-depth-0">Voltar</a>
            </div>
        </form>
    </section> 

    <?php include('templates/footer.php') ?>
</html>