<?php
    include('config/ligacao_db.php');

    if (isset($_POST['submit'])) {
        // Obter os dados do formulário
        $id_produto = mysqli_real_escape_string($ligacao, $_POST['id_produto']);
        $nome = mysqli_real_escape_string($ligacao, $_POST['nome']);
        $composicao = mysqli_real_escape_string($ligacao, $_POST['composicao']);
        $preço = mysqli_real_escape_string($ligacao, $_POST['preço']);
        $taxaIVA = mysqli_real_escape_string($ligacao, $_POST['taxaIVA']);
    
        // Verifica se o ID do produto é válido
        if (empty($id_produto)) {
            echo "ID do produto inválido.";
            exit;
        }

        //Atualizar dados na BD
        $sql_update = "UPDATE produto SET nome = '$nome', composicao = '$composicao', preço = '$preço', taxaIVA = '$taxaIVA' WHERE cod_produto = $id_produto";

        //Guardar na BD e verificar
        if(mysqli_query($ligacao, $sql_update)){
            //Sucesso
            header('Location: display_produto.php');
        } else {
            //Erro
            echo 'Erro na query: ' . mysqli_error($ligacao);
        }

        mysqli_close($ligacao);
    } else {
        echo "Acesso inválido.";
    }
?>
