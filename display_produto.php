<!DOCTYPE html>
<html>       
    
    <?php include('templates/header.php') ?>
    <?php 
        include('config/ligacao_db.php');

        //Query para obter todos os produtos
        $sql = 'SELECT * FROM produto';

        //Executar a query
        $resultado = mysqli_query($ligacao, $sql);

        //obter as linhas resultantes em forma de array
        $produtos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        
        //Liberta o resultado da memoria
        mysqli_free_result($resultado);

    echo '<table border="10" cellspacing=10" cellpadding="2">
        <tr>
            <td class = center> <font face="Arial">Codigo de Produto</font> </td>
            <td class = center> <font face="Arial">Nome</font> </td>
            <td class = center> <font face="Arial">Composicao</font> </td>
            <td class = center> <font face="Arial">Preco</font> </td>
            <td class = center> <font face="Arial">TaxaIVA</font> </td>
            <td class = center> <font face="Arial">Criado Em</font> </td>
        </tr>';

    //Percorrer o array de produtos
    foreach($produtos as $produto){
        echo '<tr>
            <td class=center> <font face="Arial">'. $produto['cod_produto'].'</font> </td>
            <td class=center> <font face="Arial">'. $produto['nome']. '</font> </td>
            <td class=center> <font face="Arial">'. $produto['composicao']. '</font> </td>
            <td class=center> <font face="Arial">'. $produto['preço']. '€' .'</font> </td>
            <td class=center> <font face="Arial">'. $produto['taxaIVA']. '%' . '</font> </td>
            <td class=center> <font face="Arial">'. $produto['criado_em']. '</font> </td>
            <td class=center> <form align="center" action="modify_produto.php" method="post">
                <input type="hidden"  name="id" value="'. $produto["cod_produto"].'">
                <input type="submit" class="btn brand z-depth-0" value="Alterar" >
                </form>
            </td>
            <td class=center> <form align="center" action="delete_produto.php" method="post">
                <input  type="hidden" name="id" value="'. $produto["cod_produto"].'">
                <input type="submit" class="btn brand z-depth-0" value="Eliminar" >
                </form>
            </td>
        </tr>';
    }
    echo '</table>';

    //Fechar a ligação
    mysqli_close($ligacao);
    
?>
    <div class="center">
        <a href="add_produto.php" class="btn brand z-depth-0">Adicionar</a>
        <a href="index.php" class="btn brand z-depth-0">Voltar</a>
    </div>
    <?php include('templates/footer.php') ?>
</html>