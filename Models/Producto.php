<?php namespace Models;
class Producto
{
    private $codigo_barras;
    private $nombre;
    private $imagen;
    private $color;
    private $marca;
    private $proveedor;
    private $descripcion;
    private $unidad_medida;
    private $talla_numero;
    private $tipo;
    private $precio_compra;
    private $precio_venta;
    private $pestado;
    private $cantidad;
    private $stock_minimo;
    private $con;

    public function __construct()
    {
        $this->con = new Conexion();
    }
    public function setCodigoBarras($codigo_barras)
    {
        $this->codigo_barras = $codigo_barras;
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
    public function setProveedor($proveedor)
    {
        $this->$proveedor =$proveedor;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
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
    public function setPestado($pestado)
    {
        $this->pestado = $pestado;
    }
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }
    public function setStockMinimo($stock_minimo)
    {
        $this->stock_minimo = $stock_minimo;
    }

    public function guardar($negocio, $trabajador)
    {
        $sql = "INSERT INTO producto (codigo_barras, nombre, imagen,color,marca,proveedor,descripcion, unidad_medida, talla_numero,
        tipo, precio_compra, precio_venta, pestado,stock_minimo,trabajador_idtrabajador, clientesab_id_clienteab)
        VALUES('{$this->codigo_barras}', '{$this->nombre}', '{$this->imagen}','{$this->color}','{$this->marca}','{$this->proveedor}','{$this->descripcion}',
        '{$this->unidad_medida}','{$this->talla_numero}', '{$this->tipo}','{$this->precio_compra}'
        ,'{$this->precio_venta}','{$this->pestado}','{$this->stock_minimo}','$trabajador','$negocio')";

        return $this->con->consultaSimple($sql);
    }

    public function editar($id, $trabajador)
    {
        $sql = "UPDATE producto INNER JOIN inventario ON codigo_barras = producto_codigo_barras
        SET  nombre = '{$this->nombre}', imagen = '{$this->imagen}', color = '{$this->color}', marca = '{$this->marca}',descripcion = '{$this->descripcion}', marca = '{$this->marca}', proveedor = '{$this->proveedor}'
                ,cantidad ='{$this->cantidad}', unidad_medida ='{$this->unidad_medida}', talla_numero = '{$this->talla_numero}', tipo = '{$this->tipo}',
                 precio_compra = '{$this->precio_compra}',precio_venta ='{$this->precio_venta}', pestado = '{$this->pestado}',stock_minimo ='{$this->stock_minimo}'
                 ,producto.trabajador_idtrabajador = '{$trabajador}',cantidad ='{$this->cantidad}' WHERE codigo_barras ='$id'";

        return $this->con->consultaSimple($sql);
    }
    
    public function editarSinImagen($id, $trabajador)
    {
        $sql = "UPDATE producto INNER JOIN inventario ON codigo_barras = producto_codigo_barras
        SET  codigo_barras = '{$this->codigo_barras}', nombre = '{$this->nombre}', color = '{$this->color}', marca = '{$this->marca}', proveedor = '{$this->proveedor}',descripcion = '{$this->descripcion}'
                ,cantidad ='{$this->cantidad}', unidad_medida ='{$this->unidad_medida}', talla_numero = '{$this->talla_numero}', tipo = '{$this->tipo}',
                 precio_compra = '{$this->precio_compra}',precio_venta ='{$this->precio_venta}', pestado = '{$this->pestado}',stock_minimo ='{$this->stock_minimo}'
                 ,producto.trabajador_idtrabajador = '{$trabajador}',cantidad ='{$this->cantidad}',producto_codigo_barras = '{$this->codigo_barras}' WHERE codigo_barras ='$id'";

        return $this->con->consultaSimple($sql);
    }

    public function __destruct()
    {
        $this->con->cerrarConexion();
    }
}
