<!DOCTYPE html>
<html>       
    
    <?php include('templates/header.php') ?>
    <?php 
        include('config/ligacao_db.php');
        $id_rota = '';
        if (isset($_POST['id_rota'])) {
        $id_rota = $_POST['id_rota'];
        }
        else {
            print_r('Variavel nao encontrado');
        }


        //Query para obter todos os produtos
        $sql = "SELECT * FROM ponto_entrega WHERE cod_rota =  $id_rota ";

        //Executar a query
        $resultado = mysqli_query($ligacao, $sql);

        //obter as linhas resultantes em forma de array
        $pes = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        
        //Liberta o resultado da memoria
        mysqli_free_result($resultado);
    
    //-----------------------------------------------
    //Query para obter todos os produtos
    $sql2 = "SELECT nome FROM rota WHERE cod_rota =  $id_rota ";

    //Executar a query
    $resultado = mysqli_query($ligacao, $sql2);

    //obter as linhas resultantes em forma de array
    $n_rota = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    
    //Liberta o resultado da memoria
    mysqli_free_result($resultado);
  

    foreach($n_rota as $n){
        echo '<h5 class="center"><font face="Arial">Rota: '. $n['nome']. '</font></h5>';
    }
   
    echo '<table border="10" cellspacing=10" cellpadding="2">
        <tr>
            <td class = center> <font face="Arial">Codigo do Ponto de Entrega</font> </td>
            <td class = center> <font face="Arial">Nome</font> </td>
            <td class = center> <font face="Arial">Morada</font> </td>
            <td class = center> <font face="Arial">Codigo da Rota</font> </td>

        </tr>';

    //Percorrer o array de produtos
    foreach($pes as $pe){
        echo '<tr>
            <td class=center> <font face="Arial">'. $pe['cod_pe'].'</font> </td>
            <td class=center> <font face="Arial">'. $pe['nome']. '</font> </td>
            <td class=center> <font face="Arial">'. $pe['morada']. '</font> </td>
            <td class=center> <font face="Arial">'. $pe['cod_rota']. '</font> </td>

            <td class=center> <form action="modify_pe.php" method="post">
                <input type="hidden"  name="id" value="'. $pe["cod_pe"].'">
                <input type="submit" class="btn brand z-depth-0" value="Alterar" >
                </form>
            </td>
            <td class=center> <form action="delete_pe.php" method="post">
                <input type="hidden" name="id" value="'. $pe["cod_pe"].'">
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
        <a href="add_pe.php" class="btn brand z-depth-0">Adicionar Ponto de Entrega</a>
        <a href="display_rota.php" class="btn brand z-depth-0">Voltar</a>
    </div>
    <?php include('templates/footer.php') ?>
</html>