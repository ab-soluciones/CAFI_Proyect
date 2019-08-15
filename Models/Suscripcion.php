<?php

namespace Models;

use mysqli;

class Suscripcion
{
    private $id;
    private $activacion;
    private $vencimiento;
    private $estado;
    private $monto;
    private $id_negocio;
    private $con;

    public function __construct()
    {
        $this->con = new Conexion();
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setActivacion($activacion)
    {
        $this->activacion = $activacion;
    }
    public function setVencimiento($vencimiento)
    {
        $this->vencimiento = $vencimiento;
    }
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function setIdNegocio($id)
    {
        $this->id_negocio = $id;
    }
    public function setMonto($monto)
    {
        $this->monto = $monto;
    }

    public function getActivacion($activacion)
    {
        return $this->activacion;
    }
    public function getVencimiento()
    {
        return $this->vencimiento;
    }
    public function getEstado()
    {
        return $this->estado;
    }
    public function getId()
    {
        return $this->id;
    }

    public function guardar($idusuario)
    {
        $sql = "INSERT INTO  suscripcion(idsuscripcion,fecha_activacion,fecha_vencimiento,estado,monto,negocio_id,usuariosab_idusuariosab)
                VALUES  ('{$this->id}', '{$this->activacion}', '{$this->vencimiento}','{$this->estado}',
                '{$this->monto}','{$this->id_negocio}','$idusuario')";

        return $this->con->consultaSimple($sql);
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM suscripcion WHERE idsuscripcion='$id'";
        $this->con->consultaSimple($sql);
    }

    public function editar($id, $idusuario)
    {
        $sql = "UPDATE negocios
        INNER JOIN suscripcion ON suscripcion.negocio_id=negocios.idnegocios
        INNER JOIN clientesab ON clientesab.id_clienteab=negocios.clientesab_idclienteab 
        INNER JOIN trabajador ON trabajador.negocios_idnegocios = negocios.idnegocios 
        SET suscripcion.fecha_activacion = '{$this->activacion}', suscripcion.fecha_vencimiento = '{$this->vencimiento}', 
        suscripcion.estado ='{$this->estado}',suscripcion.monto='{$this->monto}',suscripcion.usuariosab_idusuariosab='$idusuario',
        clientesab.estado ='{$this->estado}', trabajador.estado='{$this->estado}'
        WHERE suscripcion.idsuscripcion='$id'";

        $result = $this->con->consultaSimple($sql);

        if ($result === 0) {
            $sql = "UPDATE suscripcion SET fecha_activacion = '{$this->activacion}'
            ,fecha_vencimiento = '{$this->vencimiento}' , estado ='{$this->estado}'
            ,monto ='{$this->monto}',usuariosab_idusuariosab = '$idusuario'
            WHERE idsuscripcion = '$id'";
            $result = $this->con->consultaSimple($sql);
        }
        return $result;
    }

    public function __destruct()
    {
        $this->con->cerrarConexion();
    }
}
