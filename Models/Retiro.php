<?php

namespace Models;

date_default_timezone_set("America/Mexico_City");
class Retiro
{
    private $id;
    private $tipo;
    private $concepto;
    private $cantidad;
    private $descripcion;
    private $fecha;
    private $hora;
    private $estado;
    private $negocio;
    private $trabajador;


    public function __construct()
    {
        $this->con = new Conexion();
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setConcepto($concepto)
    {
        $this->concepto = $concepto;
    }
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
    public function setFecha()
    {
        $año = date("Y");
        $mes = date("m");
        $dia = date("d");
        $this->fecha = $año . "-" . $mes . "-" . $dia;
    }
    public function setHora()
    {
        $hora = date("H");
        $minuto = date("i");
        $segundo = date("s");
        $this->hora = $hora . ":" . $minuto . ":" . $segundo;
    }
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
    public function setNegocio($negocio)
    {
        $this->negocio = $negocio;
    }
    public function setTrabajador($trabajador)
    {
        $this->trabajador = $trabajador;
    }
    public function guardar()
    {
        $datos = array($this->id,$this->concepto,$this->tipo,$this->cantidad,$this->descripcion,$this->fecha,$this->hora,
        $this->estado,$this->negocio,$this->trabajador);

        $sql = "INSERT INTO retiros (idretiro, concepto, tipo, cantidad, descripcion, fecha, hora,estado, negocios_idnegocios, trabajador_idtrabajador) 
        VALUES ('$this->id', '$this->concepto','$this->tipo','$this->cantidad', '$this->descripcion', '$this->fecha','$this->hora','$this->estado', '$this->negocio', '$this->trabajador')";
        return $this->con->consultaSimple($sql);
    }

    public function editar($id)
    {
        $datos = arrays($this->estado,$this->trabajador,$id);
        
        $sql = "UPDATE retiros SET estado = '$this->estado', trabajador_idtrabajador='$this->trabajador' WHERE idretiro='$id'";
        return $this->con->consultaSimple($sql);
    }

    public function __destruct()
    {
        $this->con->cerrarConexion();
    }
}
