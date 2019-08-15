<?php

namespace Models;

class OtrosIngresos
{

    private $id_otros_ingresos;
    private $cantidad;
    private $tipo;
    private $forma_ingreso;
    private $fecha;
    private $estado;
    private $con;

    public function __construct()
    {
        $this->con = new Conexion();
    }

    public function setIdOtrosIngresos($id)
    {
        $this->id_otros_ingresos = $id;
    }
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
    public function setFormaIngreso($forma_ingreso)
    {
        $this->forma_ingreso = $forma_ingreso;
    }
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function guardar($id, $negocio)
    {
        $sql = "INSERT INTO otros_ingresos (id_otros_ingresos,cantidad,tipo,forma_ingreso,fecha,estado,
        trabajador_idpersona,negocios_idnegocios) VALUES('{$this->id_otros_ingresos}','{$this->cantidad}',
        '{$this->tipo}','{$this->forma_ingreso}','{$this->fecha}','{$this->estado}','$id','$negocio')";
        return $this->con->consultaSimple($sql);
    }


    public function editar($trabajador)
    {
        $sql = "UPDATE otros_ingresos SET cantidad='{$this->cantidad}',tipo='{$this->tipo}',forma_ingreso='{$this->forma_ingreso}',
        fecha='{$this->fecha}',estado='{$this->estado}',trabajador_idpersona='$trabajador' WHERE id_otros_ingresos='{$this->id_otros_ingresos}'";
        return $this->con->consultaSimple($sql);
    }

    public function __destruct()
    {
        $this->con->cerrarConexion();
    }
}
