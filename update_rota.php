<?php
    include('config/ligacao_db.php');

    if (isset($_POST['submit'])) {
        // Obter os dados do formulário
        $id_rota = mysqli_real_escape_string($ligacao, $_POST['id_rota']);
        $nome = mysqli_real_escape_string($ligacao, $_POST['nome']);
        $distribuidor = mysqli_real_escape_string($ligacao, $_POST['distribuidor']);
    
        // Verifica se o ID do produto é válido
        if (empty($id_rota)) {
            echo "ID do produto inválido.";
            exit;
        }

        //Atualizar dados na BD
        $sql_update = "UPDATE rota SET nome = '$nome', distribuidor = '$distribuidor' WHERE cod_rota = $id_rota";

        //Guardar na BD e verificar
        if(mysqli_query($ligacao, $sql_update)){
            //Sucesso
            header('Location: display_rota.php');
        } else {
            //Erro
            echo 'Erro na query: ' . mysqli_error($ligacao);
        }

        mysqli_close($ligacao);
    } else {
        echo "Acesso inválido.";
    }

?>
