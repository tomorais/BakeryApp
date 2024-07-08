<?php
    include('config/ligacao_db.php');

    if (isset($_POST['id'])) {
        // Obter os dados do formulário
        $id_rota = mysqli_real_escape_string($ligacao, $_POST['id']);
    
        // Verifica se o ID do produto é válido
        if (empty($id_rota)) {
            echo "ID do produto inválido.";
            exit;
        }

        //Atualizar dados na BD
        $sql_delete = "DELETE FROM rota WHERE cod_rota = $id_rota";

        //Guardar na BD e verificar
        if(mysqli_query($ligacao, $sql_delete)){
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
