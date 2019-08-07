<?php namespace Models;

class DetalleVenta
{
    private $iddetalle_venta;
    private $idproducto;
    private $precio;
    private $idventa;
    private $cantidad;
    private $subtotal;
    private $con;

    public function __construct()
    {
        $this->con = new Conexion();
    }
    public function setIdDv($iddetalle_venta)
    {
        $this->iddetalle_venta = $iddetalle_venta;
    }

    public function setIdP($producto, $codigo, $descripcion, $negocio)
    {
        $nombre = "";
        $marca = "";
        $color = "";
        $talla = "";

        $producto = explode(" ", $producto);
        if (sizeof($producto) === 6) {
            $nombre = $producto[0];
            $marca = $producto[1];
            $color = $producto[3];
            $talla = $producto[5];
        }
        $query = "SELECT idproducto , precio_venta FROM producto WHERE nombre = '$nombre'
        AND color = '$color' AND marca = '$marca' AND talla_numero = '$talla' AND negocios_idnegocios ='$negocio'
        OR codigo_barras = '$codigo' AND negocios_idnegocios ='$negocio' OR descripcion = '$descripcion' AND negocios_idnegocios ='$negocio'";
        $res = $this->con->consultaRetorno($query);
        $this->idproducto = $res['idproducto'];
        $this->precio = $res['precio_venta'];
        if (!$res) {
            echo "<script> alert('El producto no existe');</script>";
        }
    }

    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }
    public function setIdVenta($idventa)
    {
        $this->idventa = $idventa;
    }
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    public function setSuptotal($cantidad)
    {
        $cantidad = floatval($cantidad);
        $this->subtotal = $this->precio * $cantidad;
    }
    public function guardar()
    {
        $sql = "SELECT iddetalle_venta FROM detalle_venta WHERE producto='$this->idproducto' AND idventa='$this->idventa'";
        $result = $this->con->consultaRetorno($sql);
        if (isset($result)) {
            echo "<script> alert('EL PRODUCTO YA EXISTE EN LA LISTA,MODIFIQUE LA CANTIDAD SI DESEA AGREGAR MAS PRODUCTOS DE ESTE TIPO');</script>";
        } else {
            $sql = "INSERT INTO detalle_venta (iddetalle_venta, producto, idventa, cantidad_producto, subtotal) 
            VALUES('{$this->iddetalle_venta}', '{$this->idproducto}', '{$this->idventa}',
            '{$this->cantidad}', '{$this->subtotal}')";
            $this->con->consultaSimple($sql);
        }
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM detalle_venta WHERE  iddetalle_venta = '$id'";
        $this->con->consultaSimple($sql);
    }

    public function editar($id)
    {
        $sql = "UPDATE detalle_venta SET cantidad_producto = '{$this->cantidad}', subtotal = '{$this->subtotal}' WHERE iddetalle_venta ='$id'";
        $this->con->consultaSimple($sql);
    }

    public function __destruct()
    {
        $this->con->cerrarConexion();
    }
}
