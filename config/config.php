<?php

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

define("BASE_URL", "http://localhost/exfe/public/");

define("DB_HOST", "127.0.0.1:3306");
define("DB_NAME", "db_exfe");
define("DB_USER", "root");
define("DB_PASS", "");

define('EMAIL_HOST', 'smtp.hostinger.com');
define('EMAIL_PORT', '465');
define('EMAIL_USER', 'innovaclicktipi02@smpsistema.com.br');
define('EMAIL_PASS', 'Senac@tipi02');

// Sistema de autoload das class
spl_autoload_register(function ($classe){

    if(file_exists('../app/controllers/' . $classe .'.php')){

        require_once '../app/controllers/'. $classe .'.php';
    }

    if(file_exists('../app/models/'. $classe .'.php')){
        require_once '../app/models/'. $classe .'.php';
    }

    if(file_exists('../core/'. $classe .'.php')){
        require_once '../core/'. $classe .'.php';
    }

});


