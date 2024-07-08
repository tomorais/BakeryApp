<!DOCTYPE html>
<html>       
    
    <?php include('templates/header.php') ?>
    <?php 
        include('config/ligacao_db.php');

        //Query para obter todos os produtos
        $sql = 'SELECT * FROM rota';

        //Executar a query
        $resultado = mysqli_query($ligacao, $sql);

        //obter as linhas resultantes em forma de array
        $rotas = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        
        //Liberta o resultado da memoria
        mysqli_free_result($resultado);

    echo '<table border="10" cellspacing=10" cellpadding="2">
        <tr>
            <td class=center> <font face="Arial">Codigo da rota</font> </td>
            <td class=center> <font face="Arial">Nome da Rota</font> </td>
            <td class=center> <font face="Arial">Distribuidor</font> </td>
            
        </tr>';

    //Percorrer o array de produtos
    foreach($rotas as $rota){
        echo '<tr>
            <td class=center> <font face="Arial">'. $rota['cod_rota'].'</font> </td>
            <td class=center> <font face="Arial">'. $rota['nome']. '</font> </td>
            <td class=center> <font face="Arial">'. $rota['distribuidor']. '</font> </td>
            <td class=center> <form action="display_pe.php" method="post">
                <input type="hidden" name="id_rota" value="'. $rota["cod_rota"].'">
                <input type="submit" class="btn brand z-depth-0" value="Pontos de Entrega" >
                </form>
            </td>
            <td class=center> <form action="modify_rota.php" method="post">
                <input type="hidden"  name="id" value="'. $rota["cod_rota"].'">
                <input type="submit" class="btn brand z-depth-0" value="Alterar" >
                </form>
            </td>
            <td class=center> <form action="delete_rota.php" method="post">
                <input type="hidden" name="id" value="'. $rota["cod_rota"].'">
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
        <a href="add_rota.php" class="btn brand z-depth-0">Adicionar Nova Rota</a>
        <a href="index.php" class="btn brand z-depth-0">Voltar</a>
    </div>
    <?php include('templates/footer.php') ?>
</html>