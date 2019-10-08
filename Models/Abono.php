<?php

namespace Models;

date_default_timezone_set("America/Mexico_City");
class Abono
{
    private $id;
    private $cantidad;
    private $pago;
    private $forma_pago;
    private $cambio;
    private $fecha;
    private $hora;
    private $negocio;
    private $trabajador;
    private $con;

    public function __construct()
    {
        $this->con = new Conexion();
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
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
    public function setNegocio($negocio)
    {
        $this->negocio = $negocio;
    }
    public function setTrabajador($trabajador)
    {
        $this->trabajador = $trabajador;
    }
    public function guardar($adeudo, $total)
    {
        $datos = array($this->id,"R",$this->cantidad,$this->pago,$this->forma_pago,$this->cambio,$this->fecha,$this->hora,$this->negocio,$this->trabajador,$adeudo);
        
        $sql = "INSERT INTO abono (idabono, estado, cantidad, pago,forma_pago, cambio, fecha, hora, negocios_idnegocios, trabajador_idtrabajador, adeudos_id) 
        VALUES ('$this->id', 'R','$this->cantidad', '$this->pago', '$this->forma_pago', '$this->cambio', '$this->fecha', '$this->hora', '$this->negocio', '$this->trabajador', '$adeudo')";

        $result = $this->con->consultaSimple($sql);

        $sql = "UPDATE adeudos SET total_deuda='$total' WHERE idadeudos='$adeudo'";

        $this->con->consultaSimple($sql);

        $sql = "UPDATE adeudos SET estado_deuda = 'L' WHERE total_deuda= '0.00' ";

        $this->con->consultaSimple($sql);

        return $result;
    }

    public function __destruct()
    {
        $this->con->cerrarConexion();
    }
}
