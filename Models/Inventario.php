<?php

namespace Models;

class Inventario
{
    private $cantidad;
    private $codigob;
    private $negocio;
    private $trabajador;
    private $con;

    public function __construct()
    {
        $this->con = new Conexion();
    }
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    public function setCodigoB($producto)
    {
        $query = "SELECT codigo_barras FROM producto WHERE (SELECT CONCAT(nombre,' ',marca,' color ' ,color,' talla ', talla_numero))='$producto'";
        $result = $this->con->consultaRetorno($query);

        $this->codigob = $result['codigo_barras'];
    }
    public function getCodigoBarras()
    {
        $codigob =  $this->codigob;
        return $codigob;
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
        $query = "INSERT INTO inventario (cantidad,producto_codigo_barras,negocios_idnegocios,trabajador_idtrabajador) 
    VALUES ('{$this->cantidad}','{$this->codigob}','{$this->negocio}','{$this->trabajador}')";
        return $this->con->consultaSimple($query);
    }

    public function editar()
    {
        $query = "UPDATE invetario SET cantidad = '{$this->cantidad}', producto_codigo_barras = '{$this->codigob}', trabajador_idtrabajador = '{$this->trabajador}' WHERE producto_codigo_barras = '{$this->trabajador}'";

        return $this->con->consultaSimple($query);
    }

    public function actualizarStock($idventa, $negocio)
    {
        $query = "SELECT inventario.producto_codigo_barras ,(cantidad - cantidad_producto) AS stock FROM
        inventario INNER JOIN detalle_venta ON inventario.producto_codigo_barras = detalle_venta.producto_codigo_barras
        WHERE detalle_venta.idventa='$idventa'";
        $row = $this->con->consultaListar($query);
        while ($renglon = mysqli_fetch_array($row)) {
            $query = "UPDATE inventario SET cantidad = '$renglon[stock]' WHERE producto_codigo_barras = '$renglon[producto_codigo_barras]' AND negocios_idnegocios = '$negocio'";
            $this->con->consultaSimple($query);
        }
    }

    public function actualizarStock2($idventa, $negocio)
    {
        $query = "SELECT inventario.producto_codigo_barras ,(cantidad + cantidad_producto) AS stock FROM
        inventario INNER JOIN detalle_venta ON inventario.producto_codigo_barras = detalle_venta.producto_codigo_barras
        WHERE detalle_venta.idventa='$idventa'";
        $row = $this->con->consultaListar($query);
        while ($renglon = mysqli_fetch_array($row)) {
            $query = "UPDATE inventario SET cantidad = '$renglon[stock]' WHERE producto_codigo_barras = '$renglon[producto_codigo_barras]' AND negocios_idnegocios = '$negocio'";
            $this->con->consultaSimple($query);
        }
    }

    public function __destruct()
    {
        $this->con->cerrarConexion();
    }
}
