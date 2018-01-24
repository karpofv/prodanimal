<?php
    include("includes/conexion.php");
    include("includes/conf/parametros.php");
    include("includes/conf/firewall.php");
    if (trim($_SESSION['usuario_tipo']) == ""){
        header('Location: index.php?error=3');
        exit;
    } else {
        header("Location: system/control.php");
    }
?>