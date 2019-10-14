<?php namespace Models;

class Cliente
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
    private $estado;
    private $con;

    public function __construct( )
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
    public function getDocumento()
    {
        return $this->documento;
    }
    public function getNumDoc()
    {
        return $this->numerodoc;
    }
    public function getDireccion()
    {
        return $this->direccion;
    }
    public function getTelefono()
    {
        return $this->telefono;
    }
    public function getCorreo()
    {
        return $this->correo;
    }
    public function getId()
    {
        return $this->id;
    }

    public function guardar($negocio, $trabajador)
    {
        $datos = array($this->id,$this->nombre,$this->apaterno,$this->amaterno,$this->documento,$this->numerodoc,
        $this->direccion,$this->telefono,$this->correo,$this->estado,$negocio,$trabajador);

        $sql = "INSERT INTO cliente (idcliente, nombre, apaterno, amaterno, tipo_documento, 
        numero_documento, direccion, telefono, correo, estado, negocios_idnegocios, trabajador_idtrabajador) 
        VALUES('{$this->id}', '{$this->nombre}', '{$this->apaterno}', '{$this->amaterno}', '{$this->documento}','{$this->numerodoc}'
        ,'{$this->direccion}','{$this->telefono}','{$this->correo}','{$this->estado}','$negocio' ,'$trabajador')";

        return $this->con->consultaSimple($sql);
    }

    public function eliminar($id)
    {
        $datos = array($id);
        $sql = "DELETE FROM cliente WHERE  idcliente = '$id'";
        $this->con->consultaSimple($sql);
    }

    public function editar($id, $trabajador)
    {
        $datos = array($this->nombre,$this->apaterno,$this->amaterno,$this->documento,$this->numerodoc,
        $this->direccion,$this->telefono,$this->correo,$this->estado,$trabajador,$id);
        
        $sql = "UPDATE cliente SET nombre = '{$this->nombre}', apaterno = '{$this->apaterno}'
        ,amaterno ='{$this->amaterno}',tipo_documento ='{$this->documento}',numero_documento = '{$this->numerodoc}'
        ,direccion ='{$this->direccion}',telefono='{$this->telefono}',correo='{$this->correo}'
        , estado ='{$this->estado}', trabajador_idtrabajador = '$trabajador' WHERE idcliente ='$id'";

        return $this->con->consultaSimple($sql);
    }

    public function __destruct()
    {
        $this->con->cerrarConexion();
    }
}
