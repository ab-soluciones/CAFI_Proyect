<?php

namespace Models;

class Gasto
{
    private $id;
    private $concepto;
    private $pago;
    private $descripcion;
    private $monto;
    private $estado;
    private $fecha;
    private $con;


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
    public function setPago($pago)
    {
        $this->pago = $pago;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
    public function setMonto($monto)
    {
        $this->monto = $monto;
    }
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }
    public function guardar($negocio, $trabajador)
    {
        $datos = array($this->id,$this->concepto,$this->pago,$this->descripcion,$this->monto,$this->estado,$this->fecha,
        $negocio,$trabajador);
        $sql = "INSERT INTO gastos(idgastos,concepto, pago , descripcion, monto, estado, fecha,  negocios_idnegocios, trabajador_idtrabajador) 
        VALUES('{$this->id}', '{$this->concepto}', '{$this->pago}', '{$this->descripcion}', '{$this->monto}' , '{$this->estado}' ,'{$this->fecha}','$negocio', '$trabajador')";
        return $this->con->consultaSimple($sql);
    }

    public function eliminar($id)
    {
        $datos = array($id);
        $sql = "DELETE FROM gastos WHERE  idgastos = '$id'";
        $this->con->consultaSimple($sql);
    }

    public function editar($id, $trabajador)
    {
        $datos = array($this->concepto,$this->pago,$this->descripcion,$this->monto,$this->estado,$this->fecha,$trabajador,$id);
        
        $sql = "UPDATE gastos SET concepto = '{$this->concepto}', pago = '{$this->pago}', descripcion = '{$this->descripcion}', 
        monto ='{$this->monto}', estado ='{$this->estado}', fecha ='{$this->fecha}' , trabajador_idtrabajador = '{$trabajador}'
        WHERE idgastos ='$id'";
        return $this->con->consultaSimple($sql);
    }

    public function __destruct()
    {
        $this->con->cerrarConexion();
    }
}
