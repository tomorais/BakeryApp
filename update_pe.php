<?php
    include('config/ligacao_db.php');

    if (isset($_POST['submit'])) {
        // Obter os dados do formulário
        $id_pe = mysqli_real_escape_string($ligacao, $_POST['id_pe']);
        $nome = mysqli_real_escape_string($ligacao, $_POST['nome']);
        $coordenada1 = mysqli_real_escape_string($ligacao, $_POST['morada']);
        //$coordenada2 = mysqli_real_escape_string($ligacao, $_POST['coordenada2']);
        $cod_rota = mysqli_real_escape_string($ligacao, $_POST['cod_rota']);
    
        // Verifica se o ID do produto é válido
        if (empty($id_produto)) {
            echo "ID do produto inválido.";
            exit;
        }

        //Atualizar dados na BD
        $sql_update = "UPDATE ponto_entrega SET nome = '$nome', morada = '$morada', cod_rota = '$cod_rota' WHERE cod_pe = $id_pe";

        //Guardar na BD e verificar
        if(mysqli_query($ligacao, $sql_update)){
            //Sucesso
            header('Location: display_pe.php');
        } else {
            //Erro
            echo 'Erro na query: ' . mysqli_error($ligacao);
        }

        mysqli_close($ligacao);
    } else {
        echo "Acesso inválido.";
    }

?>
