<?php

namespace Models;

class Adeudo
{
    private $id;
    private $total;
    private $pago_minimo;
    private $estado;
    private $venta;
    private $negocio;
    private $cliente;
    private $con;

    public function __construct()
    {
        $this->con = new Conexion();
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }
    public function setPagoMinimo($pago_minimo)
    {
        $this->pago_minimo = $pago_minimo;
    }
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
    public function setVenta($venta)
    {
        $this->venta = $venta;
    }
    public function setNegocio($negocio)
    {
        $this->negocio = $negocio;
    }
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
    }
    public function guardar()
    {
        $sql = "INSERT INTO adeudos (idadeudos, total_deuda, pago_minimo, estado_deuda, ventas_idventas, 
         negocios_idnegocios, cliente_idcliente) 
        VALUES('{$this->id}', '{$this->total}', '{$this->pago_minimo}', '{$this->estado}', '{$this->venta}',
        '{$this->negocio}','{$this->cliente}')";

        $this->con->consultaSimple($sql);
    }
      public function editarTotalEstadoR($id, $idusuario)
    {
        $sql = "UPDATE adeudos INNER JOIN abono ON adeudos.idadeudos=abono.adeudos_id 
        SET adeudos.total_deuda=(adeudos.total_deuda-abono.cantidad),abono.estado='R',
        abono.trabajador_idtrabajador='$idusuario' WHERE abono.idabono='$id'";
        $result =  $this->con->consultaSimple($sql);
        $sql = "UPDATE adeudos INNER JOIN abono SET estado_deuda = IF(total_deuda = '0','L','A')  WHERE abono.idabono='$id'";
        $result = $this->con->consultaSimple($sql);
        return $result;
    }
    public function editarTotalEstadoC($id, $idusuario)
    {
        $sql = "UPDATE adeudos INNER JOIN abono ON adeudos.idadeudos=abono.adeudos_id 
        SET adeudos.total_deuda=(adeudos.total_deuda+abono.cantidad),abono.estado='C',
        abono.trabajador_idtrabajador='$idusuario' WHERE abono.idabono='$id'";
        $result = $this->con->consultaSimple($sql);
        $sql = "UPDATE adeudos INNER JOIN abono SET estado_deuda = IF(total_deuda = '0','L','A')  WHERE abono.idabono='$id'";
        $result = $this->con->consultaSimple($sql);
        return $result;
    }

    public function __destruct()
    {
        $this->con->cerrarConexion();
    }
}
