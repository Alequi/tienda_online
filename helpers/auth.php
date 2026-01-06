<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn(){
    return isset($_SESSION['user_id']) && isset($_SESSION['user_name']);
}

function requireLogin()
{
    if (!isset($_SESSION['user_id'])) {
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

function isAdmin(){
    return isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';
}

