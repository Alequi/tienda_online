<?php

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

//integracion stripe
require_once __DIR__ . '/../../vendor/autoload.php';
