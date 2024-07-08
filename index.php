<?php
session_start();

// Verificar se o usuário está logado
if(!isset($_SESSION['distribuidor'])){
    header('Location: login.php');
    exit();
}

?>


<!DOCTYPE html>
<html>
    <?php include('templates/header.php') ?>

    <!-- PRODUTOS -->
    <div class="container ">
        <div class="row">
            <div class="col s6 md3 "> <!-- BOX PRODUTOS -->
                <div class="card z-depth-0">
                    <div class="card-content center">
                        <h5 class="center red-text">Produtos</h5>
                    </div>
                <div class="card-action right-align">
                    <a href="display_produto.php" class="brand-text">Mais Info</a>
                </div>
                </div>
            </div>

            <div class="col s6 md3 "> <!-- BOX ENCOMENDAS -->
                <div class="card z-depth-0">
                    <div class="card-content center">
                        <h5 class="center red-text">Encomendas</h5>
                    </div>
                <div class="card-action right-align">
                    <a href="display_encomendas.php" class="brand-text">Mais Info</a>
                </div>
                </div>
            </div>

            <div class="col s6 md3 "> <!-- BOX ROTAS -->
                <div class="card z-depth-0">
                    <div class="card-content center">
                        <h5 class="center red-text">Rotas e Pontos de Entrega</h5>
                    </div>
                <div class="card-action right-align">
                    <a href="display_rota.php" class="brand-text">Mais Info</a>
                </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include('templates/footer.php') ?>
</html>