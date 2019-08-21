<?php

namespace Models;

use mysqli;

class Comprobar
{
    private $con;

    public function __construct()
    {
        $this->con = new Conexion();
    }
    public function comprobarFv()
    {
        date_default_timezone_set("America/Mexico_City");
        $año = date("Y");
        $mes = date("m");
        $dia = date("d");
        $fecha = $año . "-" . $mes . "-" . $dia;
        $query = "SELECT fecha_vencimiento, negocio_id FROM suscripcion WHERE estado='A'";
        $row = $this->con->consultaListar($query);
        while ($renglon = mysqli_fetch_array($row)) {
            if ($fecha == $renglon['fecha_vencimiento']) {
                $query2 = " UPDATE negocios
                             INNER JOIN suscripcion ON suscripcion.negocio_id=negocios.idnegocios
                             INNER JOIN clientesab ON clientesab.id_clienteab=negocios.clientesab_idclienteab 
                             INNER JOIN trabajador ON trabajador.negocios_idnegocios = negocios.idnegocios 
                             SET clientesab.estado='I', trabajador.estado='I', suscripcion.estado='I'
                             WHERE negocios.idnegocios='$renglon[negocio_id]'";
                $this->con->consultaSimple($query2);
            }
        }
    }
    public function eliminarVentasNull()
    {

        $query = "DELETE tventa, tdventa FROM venta tventa , detalle_venta tdventa
    WHERE tventa.total IS NULL AND tventa.idventas = tdventa.idventa";
       $result = $this->con->consultaSimple($query);

       $query = "DELETE FROM venta WHERE total IS NULL";
          $result = $this->con->consultaSimple($query);
     
    }
    public function __destruct()
    {
        $this->con->cerrarConexion();
    }
}
