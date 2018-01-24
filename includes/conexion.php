<?php
    require_once 'conf/db.php';
    /* CREAMOS LA CONEXION CON PDO */
    class Conexion extends datosConexion {
        //obtener la conexion a la base de datos MYSQL
        public function obtenerConexionMy() {
            try {
                $conectarMYSQL = new PDO("mysql:host=$this->servidorMy;dbname=$this->dbMy;charset=UTF8", $this->usuarioMy, $this->claveMy);
                return $conectarMYSQL;
            } catch (PDOException $e) {
                return 'Error: ' . $e->getMessage();
                exit;
            }
        }
    }
?>