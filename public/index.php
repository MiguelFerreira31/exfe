<?php

if (session_status() === PHP_SESSION_NONE) session_start();


// Carregar as configurações iniciais
require_once('../config/config.php');


// Núcleo da Aplicação
$nucleo = new Core();
$nucleo->executar();



?>


