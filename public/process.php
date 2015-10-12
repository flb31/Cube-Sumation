<?php

    require_once __DIR__ . '/../vendor/autoload.php';

    $cube = new Cube\Cube();
    echo $cube->executeCommand($_GET['command']);
    
?>