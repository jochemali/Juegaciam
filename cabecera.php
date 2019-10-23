<?php
    //ESTO SIEMPRE ES LO PRIMERO
	session_start();


    // Establecer tiempo de vida de la sesión en segundos
    $inactividad = 60*15;
    // Comprobar si $_SESSION["timeout"] está establecida
    if(isset($_SESSION["timeout"])){
        // Calcular el tiempo de vida de la sesión (TTL = Time To Live)
        $sessionTTL = time() - $_SESSION["timeout"];
        if($sessionTTL > $inactividad){
            session_destroy();
            header("Location: logout.php");
        }
    } 
    
    // El siguiente key se crea cuando se inicia sesión
    $_SESSION["timeout"] = time();


?> 

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>PHP</title>
	<link rel="stylesheet" href="css/estilos.css">
</head>
<body>

