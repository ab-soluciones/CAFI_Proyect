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
        $sql = "INSERT INTO venta (idventas, descuento, total, pago, forma_pago, cambio, fecha, hora, estado_venta, idtrabajador, idnegocios) 
        VALUES (NULL, '{$this->descuento}', '{$this->total}','{$this->pago}','{$this->forma_pago}','{$this->cambio}','{$this->fecha}'
        ,'{$this->hora}','{$this->estado}','{$this->trabajador}','{$this->negocio}');";

        return  $this->con->consultaSimple($sql);

    }
    public function editarEstadoV($id, $adeudo)
    {
        $sql = "UPDATE venta INNER JOIN adeudos
        SET venta.estado_venta = '{$this->estado}', adeudos.estado_deuda='$adeudo' , 
        venta.idtrabajador = '{$this->trabajador}' WHERE adeudos.ventas_idventas ='$id' AND venta.idventas='$id'";
        $renglones = $this->con->consultaSimple($sql);

        if ($renglones === 0) {
            $sql = "UPDATE venta SET  estado_venta = '{$this->estado}', idtrabajador = '{$this->trabajador}' WHERE idventas ='$id'";
            $renglones = $this->con->consultaSimple($sql);
        }
        return $renglones;
    }

    public function __destruct()
    {
        $this->con->cerrarConexion();
    }
}
