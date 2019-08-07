<?php namespace Models;

class Producto
{
    private $id;
    private $nombre;
    private $imagen;
    private $color;
    private $marca;
    private $descripcion;
    private $cantidad;
    private $unidad_medida;
    private $talla_numero;
    private $tipo;
    private $precio_compra;
    private $precio_venta;
    private $codigo_barras;
    private $pestado;
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
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }
    public function setColor($color)
    {
        $this->color = $color;
    }
    public function setMarca($marca)
    {
        $this->marca = $marca;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }
    public function setUnidad_Medida($unidad_medida)
    {
        $this->unidad_medida = $unidad_medida;
    }
    public function setTalla_numero($talla_numero)
    {
        $this->talla_numero = $talla_numero;
    }
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
    public function setPrecioCompra($precio_compra)
    {
        $this->precio_compra = $precio_compra;
    }
    public function setPrecioVenta($precio_venta)
    {
        $this->precio_venta = $precio_venta;
    }
    public function setCodigoBarras($codigo_barras)
    {
        $this->codigo_barras = $codigo_barras;
    }
    public function setPestado($pestado)
    {
        $this->pestado = $pestado;
    }

    public function guardar($negocio, $trabajador)
    {
        $sql = "INSERT INTO producto (idproducto, nombre, imagen,color,marca ,descripcion, cantidad , unidad_medida, talla_numero,
        tipo, precio_compra, precio_venta, codigo_barras, pestado, negocios_idnegocios, trabajador_idtrabajador) 
        VALUES('{$this->id}', '{$this->nombre}', '{$this->imagen}','{$this->color}','{$this->marca}','{$this->descripcion}', '{$this->cantidad}', 
        '{$this->unidad_medida}', '{$this->talla_numero}', '{$this->tipo}','{$this->precio_compra}'
        ,'{$this->precio_venta}','{$this->codigo_barras}','{$this->pestado}','$negocio' ,'$trabajador')";

        $this->con->consultaSimple($sql);
    }

    public function editar($id, $trabajador)
    {
        $sql = "UPDATE producto SET nombre = '{$this->nombre}', imagen = '{$this->imagen}', color = '{$this->color}', marca = '{$this->marca}',descripcion = '{$this->descripcion}'
        ,cantidad ='{$this->cantidad}', unidad_medida ='{$this->unidad_medida}', talla_numero = '{$this->talla_numero}', tipo = '{$this->tipo}',
         precio_compra = '{$this->precio_compra}',precio_venta ='{$this->precio_venta}', codigo_barras = '{$this->codigo_barras}', pestado = '{$this->pestado}'
         ,trabajador_idtrabajador = '{$trabajador}' WHERE idproducto ='$id'";
        $this->con->consultaSimple($sql);
    }
    public function editarSinImagen($id, $trabajador)
    {
        $sql = "UPDATE producto SET nombre = '{$this->nombre}', color = '{$this->color}', marca = '{$this->marca}',descripcion = '{$this->descripcion}'
        ,cantidad ='{$this->cantidad}', unidad_medida ='{$this->unidad_medida}', talla_numero = '{$this->talla_numero}', tipo = '{$this->tipo}',
         precio_compra = '{$this->precio_compra}',precio_venta ='{$this->precio_venta}', codigo_barras = '{$this->codigo_barras}', pestado = '{$this->pestado}'
         ,trabajador_idtrabajador = '{$trabajador}' WHERE idproducto ='$id'";
        $this->con->consultaSimple($sql);
    }

    public function actualizarStock($idventa)
    {
        $query = "SELECT producto.idproducto,(cantidad-cantidad_producto) AS stock FROM
         producto INNER JOIN detalle_venta ON producto.idproducto = detalle_venta.producto WHERE
         detalle_venta.idventa='$idventa'";
        $row = $this->con->consultaListar($query);
        while ($renglon = mysqli_fetch_array($row)) {
            $query = "UPDATE producto SET cantidad = '$renglon[stock]' WHERE idproducto='$renglon[idproducto]'";
            $this->con->consultaSimple($query);
        }
    }

    public function actualizarStock2($idventa)
    {
        $query = "SELECT producto.idproducto,(cantidad+cantidad_producto) AS stock FROM
        producto INNER JOIN detalle_venta ON producto.idproducto = detalle_venta.producto WHERE
        detalle_venta.idventa='$idventa'";
        $row = $this->con->consultaListar($query);
        while ($renglon = mysqli_fetch_array($row)) {
            $query = "UPDATE producto SET cantidad = '$renglon[stock]' WHERE idproducto='$renglon[idproducto]'";
            $this->con->consultaSimple($query);
        }
    }

    public function __destruct()
    {
        $this->con->cerrarConexion();
    }
}
