<?php
    $pass = $_POST[pass];
    $user = $_POST[user];
    // chequear si se llama directo al script.
    if ($_SERVER['HTTP_REFERER'] == '') {
        die(header("Location:  $redir?info=2"));
        exit;
    }
if($_GET[info]==4){
    die(header("Location:  $redir?info=4"));
}
if (isset($user) && isset($pass) && ($user!='') && ($pass!='')) {
    session_start();    
    session_destroy();
    $usu = trim($user);
    $login = stripslashes($usu);
    $login = preg_replace("/[';]/", "", $login);
    $conexion = new Conexion();
    $conectar = $conexion->obtenerConexionMy();
    $usuario_consulta = $conectar->prepare("SELECT * FROM $auth_table WHERE Usuario='$user'") or die(header("Location:  $redir?info=1"));
    $usuario_consulta->execute();
    if ($usuario_consulta->rowCount() == 1) {
        $password = trim($pass);
        $password = md5($password);
        // almacenamos datos del Usuario en un array para empezar a chequear.
        $usuario_datos = $usuario_consulta->fetch(PDO::FETCH_ASSOC);
        // liberamos la memoria usada por la consulta, ya que tenemos estos datos en el Array.
        $usuario_consulta->closeCursor();
        if ($login != $usuario_datos['Usuario']) {
            Header("Location: $redir?info=1");
            exit;
        }
		print_r($usuario_datos['contrasena']);
		print_r($password);
        if ($password != $usuario_datos['contrasena']) {
            Header("Location: $redir?info=1");
            exit;
        }
        session_start();
        session_cache_limiter('nocache,private');
        $_SESSION['usuario_tipo'] = $usuario_datos['Tipo'];
        $_SESSION['ci'] = $usuario_datos['Cedula'];
        $_SESSION['usuario_password']  = $usuario_datos['contrasena'];
        $_SESSION['user_pass_ne'] = $pass;
        $_SESSION['usuario_perfil'] = $usuario_datos['Nivel'];
        $_SESSION['usuario_stilo']=$usuario_datos['Stilo'];
        $_SESSION['imgperfil']=$usuario_datos['Img_perfil'];
        //Verificacion de los permisos de lectura escritura
        $pag = $_SERVER['PHP_SELF'];
        Header("Location: $pag");
        exit;
    } else {
        Header("Location: $redir?info=1");
        exit;
    }
} else {
    session_start();
    if (!isset($_SESSION['usuario_login']) && !isset($_SESSION['usuario_password'])) {
        session_destroy();
        Header("Location: $redir?info=1");
        exit;
    }
}
?>