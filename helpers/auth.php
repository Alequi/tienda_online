<?php
session_start();

function isLoggedIn(){
    return isset($_SESSION['email']);
}

function requireLogin()
{
    if (!isset($_SESSION['email'])) {
        header("Location: ../views/auth/login.php");
        exit();
    };
}

function requireAdmin(){
    requireLogin();
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
        header("Location: ../views/error.php");
        exit;
    }
}

