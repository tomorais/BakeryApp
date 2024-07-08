<?php 
    include('config/ligacao_db.php');
    $pe_modify =[];

    if (isset($_POST['id'])) {
        $id_pe = $_POST['id'];
    }
    else {
        print_r('Variavel nao encontrado');
    }

    //Obter os dados do produto com o cod_produto passado acima
    //Query para obter todos os produtos
    $sql_modify = "SELECT * FROM ponto_entrega WHERE cod_pe = $id_pe";

    //Executar a query
    $resultado_modify = mysqli_query($ligacao, $sql_modify);

    //obter as linhas resultantes em forma de array
    $produtos_modify = mysqli_fetch_assoc($resultado_modify);

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

    $nome = $pe_modify['nome'];
    $coordenada1 = $pe_modify['coordenada1'];
    $coordenada2 = $pe_modify['coordenada2'];
    $cod_rota = $pe_modify['cod_rota'];
    $erros = array('nome' => '', 'coordenada1' => '', 'coordenada2' => '', 'cod_rota' => '', 'cod_pe' => '');

    if(isset($_POST['submit'])){
        //check nome
        if(empty($_POST['nome'])){
            $erros['nome'] =  '*o nome do ponto de entrega é obrigatório <br />';
        } else {
            $nome = $_POST['nome'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $nome)){ //A condição diz que o 'nome' tem de começar por um caracter de a a z maiusculo ou minusculo.
                $erros['nome'] = '*o nome da rota deve ser apenas letras e espaços <br />';
            }
        }

        //check coordenada1
        if(empty($_POST['coordenada1'])){
            $erros['coordenada1'] =  '*o valor da coordenada é obrigatória <br />';
        } else {
            $coordenada1 = $_POST['coordenada1'];
            if(!preg_match('/^\d+(\.\d{1,2})?$/', $coordenada1)){ //A condição diz que o 'nome' tem de começar por um caracter de a a z maiusculo ou minusculo.
                $erros['coordenada1'] = '*o valor da coordenada deve ser apenas algarismos <br />';
            }
        }

        //check coordenada2
        if(empty($_POST['coordenada2'])){
            $erros['coordenada2'] =  '*o valor da coordenada é obrigatória <br />';
        } else {
            $coordenada2 = $_POST['coordenada2'];
            if(!preg_match('/^\d+(\.\d{1,2})?$/', $coordenada2)){ //A condição diz que o 'nome' tem de começar por um caracter de a a z maiusculo ou minusculo.
                $erros['coordenada2'] = '*o valor da coordenada deve ser apenas algarismos <br />';
            }
        }

        //check cod_rota
        if(empty($_POST['cod_rota'])){
            $erros['cod_rota'] =  '*o codigo da rota é obrigatório <br />';
        } else {
            $nome = $_POST['cod_rota'];
            if(!preg_match('/^\d+(\.\d{1,2})?$/', $cod_rota)){ //A condição diz que o 'nome' tem de começar por um caracter de a a z maiusculo ou minusculo.
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
            $coordenada1 = mysqli_real_escape_string($ligacao, $_POST['coordenada1']);
            $coordenada2 = mysqli_real_escape_string($ligacao, $_POST['coordenada2']);
            $cod_rota = mysqli_real_escape_string($ligacao, $_POST['cod_rota']);
        }
    } //Fim do POST check

?>

  <!DOCTYPE html>
<html>
    <?php include('templates/header.php') ?>

    <section class="container grey-text">
        <h4 class="center">Alterar Ponto de Entrega</h4>
        <form action="update_pe.php" class="white"  method="POST">
        <input type="hidden" name="id_pe" value="<?php echo $id_pe; ?>">
            <label>Nome do Ponto de Entrega:</label>
            <input type="text" name="nome" value="<?php echo htmlspecialchars($nome)?>">
            <div class="red-text"><?php echo $erros['nome']; ?></div>
            <label>Coordenada 1(Latitude):</label>
            <input type="text" name="coordenada1" value="<?php echo htmlspecialchars($coordenada1)?>">
            <div class="red-text"><?php echo $erros['coordenada1']; ?></div>
            <label>Coordenada 2(Longitude):</label>
            <input type="text" name="coordenada2" value="<?php echo htmlspecialchars($coordenada2)?>">
            <div class="red-text"><?php echo $erros['coordenada2']; ?></div>
            <label> Codigo da Rota:</label>
            <input type="text" name="cod_rota" value="<?php echo htmlspecialchars($cod_rota)?>">
            <div class="red-text"><?php echo $erros['cod_rota']; ?></div>
            <div class="center">
            <input type="submit" name="submit" value="Alterar" class="btn brand z-depth-0">
            <a href="display_pe.php" class="btn brand z-depth-0">Voltar</a>
            </div>
        </form>
    </section> 

    <?php include('templates/footer.php') ?>
</html>