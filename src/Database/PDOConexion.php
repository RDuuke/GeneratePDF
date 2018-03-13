<?php
namespace Certificado\Database;


class PDOConexion
{
    protected static $usuario = "root";
    protected static $server = "localhost";
    protected static $dns = "mysql:host=";
    protected static $password = "";
    protected static $db = "gestion_arroba";
    protected static $instance = null;

    static function instance()
    {
        if ( !isset(self::$instance)) {
            self::$instance = new PDOConexion();
        }
        return self::$instance;
    }

    public function getConexion()
    {
        $conn = null;

        try {
            $conn = new \PDO(self::$dns.self::$server.";dbname=".self::$db.";charset=utf8", self::$usuario, self::$password);
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $conn;

        } catch ( \PDOException $e ) {
            throw $e;

        } catch ( \Exception $e) {
            throw $e;
        }
    }

}