<?php namespace Models;

class Usuarioab
{
    private $id;
    private $nombre;
    private $apaterno;
    private $amaterno;
    private $acceso;
    private $login;
    private $password;
    private $estado;
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
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
    public function getApaterno()
    {
        return $this->apaterno;
    }
    public function getAmaterno()
    {
        return $this->amaterno;
    }
    public function getAcceso()
    {
        return $this->acceso;
    }
    public function getLogin()
    {
        return $this->login;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getEstado()
    {
        return $this->estado;
    }
    public function getId()
    {
        return $this->id;
    }

    public function guardar()
    {
        $datos = array($this->id,$this->nombre,$this->apaterno,$this->amaterno,$this->acceso,$this->login,
        $this->password,$this->estado);

        $sql = "INSERT INTO usuariosab(idusuariosab,nombre,apaterno,amaterno,acceso,login,password,estado)
        VALUES  ('{$this->id}', '{$this->nombre}', '{$this->apaterno}',
        '{$this->amaterno}','{$this->acceso}','{$this->login}','{$this->password}','{$this->estado}')";

    return $this->con->consultaSimple($sql);
    
    }

    public function eliminar($id)
    {
        $datos = array($id);
        $sql = "DELETE FROM usuariosab WHERE idusuariosab='$id'";
        $this->con->consultaSimple($sql);
    }

    public function editar($id)
    {
        $datos = array($this->nombre,$this->apaterno,$this->amaterno,$this->acceso,$this->login,$this->password,
        $this->estado,$id);
        
        $sql = "UPDATE usuariosab SET nombre = '{$this->nombre}',apaterno = '{$this->apaterno}'
        ,amaterno ='{$this->amaterno}', acceso = '{$this->acceso}',login = '{$this->login}'
        ,password =  '{$this->password}' ,estado ='{$this->estado}' WHERE idusuariosab = '$id'";

        return $this->con->consultaSimple($sql);
    }

    public function __destruct()
    {
        $this->con->cerrarConexion();
    }
}
