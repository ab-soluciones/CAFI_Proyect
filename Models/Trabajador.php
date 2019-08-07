<?php namespace Models;

class Trabajador
{
    private $id;
    private $nombre;
    private $apaterno;
    private $amaterno;
    private $documento;
    private $numerodoc;
    private $direccion;
    private $telefono;
    private $correo;
    private $acceso;
    private $login;
    private $password;
    private $sueldo;
    private $estado;
    private $negocio;
    private $con;

    public function __construct()
    {
        $this->con = new Conexion();
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setApaterno($apaterno)
    {
        $this->apaterno = $apaterno;
    }
    public function setAmaterno($amaterno)
    {
        $this->amaterno = $amaterno;
    }
    public function setDocumento($documento)
    {
        $this->documento = $documento;
    }
    public function setNumDoc($numerodoc)
    {
        $this->numerodoc = $numerodoc;
    }
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }
    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }
    public function setAcceso($acceso)
    {
        $this->acceso = $acceso;
    }
    public function setLogin($login)
    {
        $this->login = $login;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function setSueldo($sueldo)
    {
        $this->sueldo = $sueldo;
    }
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
    public function setNegocio($negocio)
    {
        $this->negocio = $negocio;
    }


    public function guardar($idnegocio)
    {
        $sql = "INSERT INTO trabajador (idtrabajador, nombre, apaterno, amaterno, tipo_documento, 
        numero_documento, direccion, telefono, correo, acceso, login, password, sueldo , estado, negocios_idnegocios) 
        VALUES('{$this->id}', '{$this->nombre}', '{$this->apaterno}', '{$this->amaterno}', '{$this->documento}',
         '{$this->numerodoc}', '{$this->direccion}', '{$this->telefono}','{$this->correo}','{$this->acceso}',
         '{$this->login}', '{$this->password}', '{$this->sueldo}' ,'{$this->estado}' ,'$idnegocio')";

        $this->con->consultaSimple($sql);
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM trabajador WHERE idtrabajador= '$id'";
        $this->con->consultaSimple($sql);
    }

    public function editar($id)
    {
        $sql = "UPDATE trabajador SET nombre = '{$this->nombre}', apaterno = '{$this->apaterno}'
        ,amaterno ='{$this->amaterno}',tipo_documento ='{$this->documento}',numero_documento = '{$this->numerodoc}'
        ,direccion ='{$this->direccion}',telefono='{$this->telefono}',correo='{$this->correo}', acceso ='{$this->acceso}'
        , login='{$this->login}',password ='{$this->password}', sueldo = '{$this->sueldo}', estado ='{$this->estado}'  WHERE idtrabajador ='$id'";
        $this->con->consultaSimple($sql);
    }

    public function __destruct()
    {
        $this->con->cerrarConexion();
    }
}
