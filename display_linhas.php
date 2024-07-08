<!DOCTYPE html>
<html>
<style>
    .title-box {
        border: 2px solid #000;
        padding: 10px;
        background-color: darkgreen;
        font-family: Arial;
        font-weight: bold;
        text-align: center;
        
    }
</style>
    
    <?php include('templates/header.php') ?>
    <?php 
        include('config/ligacao_db.php');
        if (isset($_POST['id_ne'])) {
            $id_ne = $_POST['id_ne'];
        } else {
            die('Variável id_ne não encontrada');
        }

        //Query para obter todos os produtos
        $sql = "SELECT linha_ne.cod_ne, produto.nome AS nome_produto, linha_ne.quantidade 
                FROM linha_ne 
                JOIN produto ON linha_ne.cod_produto = produto.cod_produto 
                WHERE linha_ne.cod_ne = $id_ne";

        //Executar a query
        $resultado = mysqli_query($ligacao, $sql);

        //obter as linhas resultantes em forma de array
        $linhas = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        
        //Liberta o resultado da memoria
        mysqli_free_result($resultado);
//----------------------------------------------------------------
        // Query para obter o total de cada produto
        $sql_total = "SELECT produto.nome AS nome_produto, SUM(linha_ne.quantidade) AS total_quantidade 
                      FROM linha_ne 
                      JOIN produto ON linha_ne.cod_produto = produto.cod_produto 
                      WHERE linha_ne.cod_ne = $id_ne 
                      GROUP BY produto.nome";

        // Executar a query
        $resultado_total = mysqli_query($ligacao, $sql_total);

        // obter as linhas resultantes em forma de array
        $totais = mysqli_fetch_all($resultado_total, MYSQLI_ASSOC);
        
        // Liberta o resultado da memoria
        mysqli_free_result($resultado_total);
/*//----------------------------------------------------------------
        //Query para obter o valor total de cada produto
        $sql_valor = "SELECT produto.nome AS nome_produto, SUM(linha_ne.quantidade * produto.preco) AS total_valor 
                      FROM linha_ne 
                      JOIN produto ON linha_ne.cod_produto = produto.cod_produto 
                      WHERE linha_ne.cod_ne = $id_ne 
                      GROUP BY produto.nome";

        // Executar a query
        $resultado_valor = mysqli_query($ligacao, $sql_valor);

        // obter as linhas resultantes em forma de array
        $valores = mysqli_fetch_all($resultado_valor, MYSQLI_ASSOC);
        
        // Liberta o resultado da memoria
        mysqli_free_result($resultado_valor);
    
        -------------- GET ID ---------------------------------
    //check GET request cod_produto param
    if (isset($_GET['cod_produto'])) {
        $cod_produto = mysqli_real_escape_string($ligacao, $_GET['cod_produto']);

        //Query para obter todos os produtos
        $sql_modify = "SELECT * FROM produto WHERE cod_produto = $cod_produto";

        //Executar a query
        $resultado_modify = mysqli_query($ligacao, $sql_modify);

        //obter as linhas resultantes em forma de array
        $produtos_modify = mysqli_fetch_assoc($resultado_modify);

        mysqli_free_result($resultado_modify);
        mysqli_close($ligacao);
    }
    //-------------------------------------------------------*/

    echo '<table border="10" cellspacing=10" cellpadding="2">
        <tr>
            <td class = center> <font face="Arial">Codigo de Encomenda</font> </td>
            <td class = center> <font face="Arial">Produto</font> </td>
            <td class = center> <font face="Arial">Quantidade</font> </td>
          </tr>';

    //Percorrer o array de produtos
    foreach($linhas as $linha){
        echo '<tr>
            <td class=center> <font face="Arial">'. $linha['cod_ne'].'</font> </td>
            <td class=center> <font face="Arial">'. $linha['nome_produto']. '</font> </td>
            <td class=center> <font face="Arial">'. $linha['quantidade']. '</font> </td>
        </tr>';
    }
    // Adicionar linha total
    echo '<tr>
        <td colspan="3" class="center title-box "> <font face="Arial">Total por Produto</font> </td>
    </tr>';

    foreach($totais as $total){
            echo '<tr>
                <td class="center"> <font face="Arial">-</font> </td>
                <td class="center"> <font face="Arial">'. $total['nome_produto']. '</font> </td>
                <td class="center"> <font face="Arial">'. $total['total_quantidade']. '</font> </td>
            </tr>';
        }
    echo '</table>';

    //Fechar a ligação
    mysqli_close($ligacao);
    
?>
    <div class="center">
        <a href="display_encomendas.php" class="btn brand z-depth-0">Voltar</a>
    </div>
    <?php include('templates/footer.php') ?>
</html>