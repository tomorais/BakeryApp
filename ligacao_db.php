<?php 

//Ligação a Base de Dados pelo mySQLi
    //Dados para ligação:
    //Host: localhost
    //Username: tomorais
    //Password: morais123
    //Database: db_bakery
    $ligacao = mysqli_connect('localhost', 'tomorais', 'morais123', 'db_bakery');

    //Verificar ligação
    if(!$ligacao){
        echo 'Erro na ligação: ' . mysqli_connect_error();
    }

?>