<!DOCTYPE html>
<html>       
    
    <?php include('templates/header.php') ?>
    <?php 
        include('config/ligacao_db.php');

        //Query para obter todos os produtos
        $sql = 'SELECT * FROM ponto_entrega';

        //Executar a query
        $resultado = mysqli_query($ligacao, $sql);

        //obter as linhas resultantes em forma de array
        $pes = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        
        //Liberta o resultado da memoria
        mysqli_free_result($resultado);
    
    echo '<table border="10" cellspacing=10" cellpadding="2">
        <tr>
            <td class=center> <font face="Arial">Codigo do Ponto de Entrega</font> </td>
            <td class=center> <font face="Arial">Nome</font> </td>
            <td class=center> <font face="Arial">Morada</font> </td>
            <td class=center> <font face="Arial">Codigo da Rota</font> </td>

        </tr>';

    //Percorrer o array de produtos
    foreach($pes as $pe){
        echo '<tr>
            <td class=center> <font face="Arial">'. $pe['cod_pe'].'</font> </td>
            <td class=center> <font face="Arial">'. $pe['nome']. '</font> </td>
            <td class=center> <font face="Arial">'. $pe['morada']. '</font> </td>
            <td class=center> <font face="Arial">'. $pe['cod_rota']. '</font> </td>

            <td> <form action="add_encomenda.php" method="post">
                <input type="hidden"  name="id_pe" value="'. $pe["cod_pe"].'">
                <input type="submit" class="btn brand z-depth-0" value="Selecionar" >
                </form>
            </td>
        </tr>';
    }
    echo '</table>';
    

    //Fechar a ligação
    mysqli_close($ligacao);
    
?>
    <a href="display_encomendas.php" class="btn brand z-depth-0">Voltar</a>
    <?php include('templates/footer.php') ?>
</html>