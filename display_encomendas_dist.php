<!DOCTYPE html>
<html>       
    
    <?php include('templates/header.php') ?>
    <?php 
        include('config/ligacao_db.php');
        session_start();
        if(isset($_POST['password'])){
            $password = $_POST['password'];
            }
        //Obter o código da rota do utilizador logado
        $cod_rota = $_SESSION['password'];

        //Query para obter todos os produtos
        $sql = "SELECT e.*
            FROM encomenda e
            JOIN ponto_entrega pe ON e.cod_pe = pe.cod_pe
            JOIN rota r ON pe.cod_rota = r.cod_rota
            WHERE r.cod_rota = '$cod_rota'
            ORDER BY e.Data_";

        //Executar a query
        $resultado = mysqli_query($ligacao, $sql);

        //obter as linhas resultantes em forma de array
        $encs = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        
        //Liberta o resultado da memoria
        mysqli_free_result($resultado);
    
        /*-------------- GET ID ---------------------------------
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
    //---------------------------------------*/

    echo '<table border="10" cellspacing=10" cellpadding="2">
        <tr>
            <td class = center> <font face="Arial">Codigo de Encomenda</font> </td>
            <td class = center> <font face="Arial">Nome do Cliente</font> </td>
            <td class = center> <font face="Arial">NIF</font> </td>
            <td class = center> <font face="Arial">Data</font> </td>
            <td class = center> <font face="Arial">Codigo do Ponto de Entrega</font> </td>
        </tr>';

    //Percorrer o array de produtos
    foreach($encs as $enc){
        echo '<tr>
            <td class=center> <font face="Arial">'. $enc['cod_ne'].'</font> </td>
            <td class=center> <font face="Arial">'. $enc['nome_cliente']. '</font> </td>
            <td class=center> <font face="Arial">'. $enc['NIF']. '</font> </td>
            <td class=center> <font face="Arial">'. $enc['Data_'].'</font> </td>
            <td class=center> <font face="Arial">'. $enc['cod_pe']. '</font> </td>
            <td class=center> <form action="display_linhas.php" method="post">
                <input type="hidden"  name="id_ne" value="'. $enc["cod_ne"].'">
                <input type="submit" class="btn brand z-depth-0" value="Detalhes" >
                </form>
            </td>
            <td class=center> <form action="add_linha.php" method="post">
                <input type="hidden"  name="id_ne" value="'. $enc["cod_ne"].'">
                <input type="submit" class="btn brand z-depth-0" value="Encomendar" >
                </form>
            </td>
        </tr>';
    }
    echo '</table>';

    //Fechar a ligação
    mysqli_close($ligacao);
    
?>
    <div class="center">
        <a href="select_pe.php" class="btn brand z-depth-0">Adicionar Encomenda</a>
        <a href="index.php" class="btn brand z-depth-0">Voltar</a>
    </div>
    <?php include('templates/footer.php') ?>
</html>