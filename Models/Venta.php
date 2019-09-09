<?php

namespace Models;

date_default_timezone_set("America/Mexico_City");
class Venta
{
    private $idventas;
    private $descuento;
    private $total;
    private $pago;
    private $forma_pago;
    private $cambio;
    private $fecha;
    private $hora;
    private $estado;
    private $trabajador;
    private $negocio;
    private $con;

    public function __construct()
    {
        $this->con = new Conexion();
    }
    public function setIdVentas($idventas)
    {
        $this->idventas = $idventas;
    }

    public function setDescuento($descuento)
    {
        $this->descuento = $descuento;
    }
    public function setTotal($total)
    {
        $this->total = $total;
    }
    public function setPago($pago)
    {
        $this->pago = $pago;
    }
    public function setFormaPago($forma_pago)
    {
        $this->forma_pago = $forma_pago;
    }
    public function setCambio($cambio)
    {
        $this->cambio = $cambio;
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
    public function setTrabajador($trabajador)
    {
        $this->trabajador = $trabajador;
    }
    public function setNegocio($negocio)
    {
        $this->negocio = $negocio;
    }
    public function getIdVenta()
    {

        return $this->idventas;
    }


    public function guardar()
    {
        $sql = "INSERT INTO venta (idventas, descuento, total, pago, cambio, fecha, hora, estado_venta, idtrabajador, idnegocios) 
        VALUES (NULL, NULL, NULL,NULL,NULL, NULL, NULL, NULL, NULL, NULL);";
        $sql2 = "SELECT MAX(idventas) AS id FROM venta";
        $this->con->consultaSimple($sql);
        return $this->con->consultaRetorno($sql2);
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM venta WHERE  idventa = '$id'";
        $this->con->consultaSimple($sql);
    }

    public function editar($id)
    {
        $sql = "UPDATE venta SET descuento = '{$this->descuento}', total = '{$this->total}', pago ='{$this->pago}',
        forma_pago ='{$this->forma_pago}', cambio = '{$this->cambio}', fecha ='{$this->fecha}', hora ='{$this->hora}', 
        estado_venta = '{$this->estado}' ,idtrabajador ='{$this->trabajador}', idnegocios='{$this->negocio}' WHERE idventas ='$id'";
        return $this->con->consultaSimple($sql);
    }
    public function editarEstadoV($id, $adeudo)
    {
        $sql = "UPDATE venta INNER JOIN adeudos
        SET venta.estado_venta = '{$this->estado}', adeudos.estado_deuda='$adeudo' , 
        venta.idtrabajador = '{$this->trabajador}' WHERE adeudos.ventas_idventas ='$id' AND venta.idventas='$id'";
        $renglones = $this->con->consultaSimple($sql);

        if ($renglones === 0) {
            $sql = "UPDATE venta SET  estado_venta = '{$this->estado}', idtrabajador = '{$this->trabajador}' WHERE idventas ='$id'";
            $this->con->consultaSimple($sql);
        }
    }

    public function __destruct()
    {
        $this->con->cerrarConexion();
    }
}
