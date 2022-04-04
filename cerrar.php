<?php

session_start();

unset($_SESSION['usuario']);
unset($_SESSION['password']);
unset($_SESSION['nombreusuario']);

$_SESSION = array();
session_destroy();

die("<script> window.location.href='index.php' </script>");
