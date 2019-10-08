<?php

namespace Models;

class DetalleVenta
{
    private $usuario;
    private $codigo_barras;
    private $cantidad;
    private $subtotal;
    private $con;

    public function __construct()
    {
        $this->con = new Conexion();
    }
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
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
        $datos = array($this->usuario,$this->codigo_barras,$this->cantidad,$this->subtotal);

        $sql = "INSERT INTO detalle_venta (usuario,idventa, producto_codigo_barras, cantidad_producto, subtotal) 
            VALUES('{$this->usuario}',NULL,'{$this->codigo_barras}',
            '{$this->cantidad}', '{$this->subtotal}')";
        return $this->con->consultaSimple($sql);
    }

    public function eliminar()
    {
        $datos = array($this->usuario,$this->codigo_barras);
        $sql = "DELETE FROM detalle_venta WHERE usuario = '{$this->usuario}' AND idventa IS NULL AND producto_codigo_barras = '{$this->codigo_barras}'";
        return $this->con->consultaSimple($sql);
    }

    public function editar()
    {
        $datos = array($this->cantidad,$this->subtotal,$this->usuario,$this->codigo_barras);

        $sql = "UPDATE detalle_venta SET cantidad_producto = '{$this->cantidad}', subtotal = '{$this->subtotal}' WHERE usuario = '{$this->usuario}' AND idventa IS NULL AND producto_codigo_barras = '{$this->codigo_barras}'";
        return $this->con->consultaSimple($sql);
    }

    public function quitarNullIdVenta($venta)
    {
        $datos = array($venta,$this->usuario);
        $sql = "UPDATE detalle_venta SET idventa = '$venta' WHERE usuario = '{$this->usuario}' AND idventa IS NULL";
        return $this->con->consultaSimple($sql);
    }

    public function __destruct()
    {
        $this->con->cerrarConexion();
    }
}
