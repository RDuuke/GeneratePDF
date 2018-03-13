<?php
namespace Certificado;

use Certificado\Database\PDOConexion;

class Usuario{

    protected $username;
    protected $tabla_usuario;
    protected $pdo;
    protected $id;
    protected $container;
    protected $tipo;
    function __construct($username, $tabla_usuario, $tipo,  \PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->username = $username;
        $this->tabla_usuario = $tabla_usuario;
        $this->tipo = $tipo;
    }

    function find()
    {
        $stm = $this->pdo->prepare("SELECT id FROM {$this->tabla_usuario} WHERE documento = '{$this->username}' OR correo = '{$this->username}'");
        if ($stm->execute()) {
            $a = $stm->fetch(\PDO::FETCH_OBJ);
            $this->id = $a->id;
            return $this;
        }

    }

    function get()
    {
        $stm = $this->pdo->prepare("SELECT cg.*, v.nombre, v.documento FROM certificado_usuario cu
                                    INNER JOIN generador_certificado cg ON cu.certificado_id = cg.id
                                    INNER JOIN {$this->tabla_usuario} v ON cu.usuario_id = v.id
                                    WHERE cu.usuario_id = {$this->id} AND cg.tipo = {$this->tipo}");
        if ($stm->execute()) {
            $this->container = $stm->fetch(\PDO::FETCH_OBJ);
            return $this;
        }
    }

    function all()
    {
        return $this->container;
    }

    function __get($key)
    {
        if ( $this->container->$key) {
            return $this->container->$key;
        }
        return null;
    }
}