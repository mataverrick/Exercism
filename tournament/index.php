<?php
    require_once 'Tournament.php';
    system("clear");

    $tournament= new Tournament();
    
     echo $tournament->tally("Courageous Californians;Devastating Donkeys;win");

?>