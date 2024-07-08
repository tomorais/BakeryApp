<!DOCTYPE html>
<html>       
    
    <?php include('templates/header.php'); ?>
    <?php 
        include('config/ligacao_db.php');
        $produtos = '';

        if (isset($_POST['id_ne'])) {
            $id_ne = $_POST['id_ne'];
        } else {
            die('Variável id_ne não encontrada');
        }

        // Query para obter todos os produtos
        $sql = 'SELECT * FROM produto';

        // Executar a query
        $resultado = mysqli_query($ligacao, $sql);

        // Obter as linhas resultantes em forma de array
        $produtos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        
        // Liberta o resultado da memória
        mysqli_free_result($resultado);
        
        // Verificar se o formulário foi submetido
        if (isset($_POST['quantidade']) && isset($_POST['cod_produto'])) {
            $quantidade = mysqli_real_escape_string($ligacao, $_POST['quantidade']);
            $cod_produto = mysqli_real_escape_string($ligacao, $_POST['cod_produto']);

            // Query para adicionar à tabela linha_ne
            $sql_linha = "INSERT INTO linha_ne(cod_ne, cod_produto, quantidade) VALUES('$id_ne', '$cod_produto', '$quantidade')";

            // Executar a query
            if (mysqli_query($ligacao, $sql_linha)) {
                echo "Registro inserido com sucesso.";
            } else {
                echo "Erro: " . mysqli_error($ligacao);
            }
        }

        echo '<table border="10" cellspacing="5" cellpadding="1">
            <tr>
                <td class="center"><font face="Arial">Nome</font></td>
                <td class="center"><font face="Arial">Preco</font></td>
                <td class="center"><font face="Arial">Quantidade</font></td>
            </tr>';

        // Percorrer o array de produtos
        foreach($produtos as $produto) {
            echo '<tr>
                <td class="center"><font face="Arial">' . $produto['nome'] . '</font></td>
                <td class="center"><font face="Arial">' . $produto['preço'] . '€</font></td>
                <td class="center">
                    <form method="POST" action="">
                        <input type="hidden" name="id_ne" value="' . $id_ne . '">
                        <input type="hidden" name="cod_produto" value="' . $produto['cod_produto'] . '">
                        <input type="number" min="0" max="100" step="1" value="0" size="1" name="quantidade">
                        <input action="add_linha.php" type="submit" value="Adicionar">
                    </form>
                </td>      
            </tr>';
        }

        echo '</table>';

        // Fechar a ligação
        mysqli_close($ligacao);
    ?>
    <div class="center">
        <a href="display_encomendas.php" class="btn brand z-depth-0">Voltar </a>
    </div>

    <?php include('templates/footer.php'); ?>
</html>
