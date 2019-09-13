<?php

namespace Models;

class DetalleVenta
{
    private $venta;
    private $codigo_barras;
    private $cantidad;
    private $subtotal;
    private $con;

    public function __construct()
    {
        $this->con = new Conexion();
    }


    public function setVenta($venta)
    {
        $this->venta = $venta;
    }
    public function setCodigodeBarras($codigo_barras)
    {
        $this->codigo_barras = $codigo_barras;
    }
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;
    }
    public function guardar()
    {
        $sql = "INSERT INTO detalle_venta (idventa, producto_codigo_barras, cantidad_producto, subtotal) 
            VALUES('{$this->venta}','{$this->codigo_barras}',
            '{$this->cantidad}', '{$this->subtotal}')";
         return $this->con->consultaSimple($sql);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM detalle_venta WHERE idventa = '{$this->venta}' AND producto_codigo_barras = '{$this->codigo_barras}'";
       return $this->con->consultaSimple($sql);
    }

    public function editar()
    {
        $sql = "UPDATE detalle_venta SET cantidad_producto = '{$this->cantidad}', subtotal = '{$this->subtotal}' WHERE idventa ='{$this->venta}' AND producto_codigo_barras = '{$this->codigo_barras}'";
        return $this->con->consultaSimple($sql);
    }

    public function __destruct()
    {
        $this->con->cerrarConexion();
    }
}
