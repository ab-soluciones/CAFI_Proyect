<?php

namespace Models;

use mysqli;

class Suscripcion
{
    private $id;
    private $activacion;
    private $vencimiento;
    private $estado;
    private $paquete;
    private $usextra;
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

    public function setIdNegocio($negocio)
    {
        $query = "SELECT idnegocios FROM negocios WHERE (SELECT CONCAT(nombre_negocio,' ',domicilio,' ' ,ciudad))='$negocio'";
        $result = $this->con->consultaRetorno($query);
        $this->id_negocio = $result['idnegocios'];
    }
    public function setPaquete($paquete)
    {
        $this->paquete = $paquete;
    }

    public function setUsuarioExtra($usextra)
    {
        $this->usextra = $usextra;
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
        $sql = "SELECT idsuscripcion FROM suscripcion WHERE negocio_id ='{$this->id_negocio}'";
        $result = $this->con->consultaRetorno($sql);
        if (isset($result['idsuscripcion'])) {
            $result = 0;
        } else {
            $sql = "INSERT INTO  suscripcion(idsuscripcion,fecha_activacion,fecha_vencimiento,estado,paquete,usuario_extra,monto,negocio_id,usuariosab_idusuariosab)
            VALUES  ('{$this->id}', '{$this->activacion}', '{$this->vencimiento}','{$this->estado}',
            '{$this->paquete}','{$this->usextra}','{$this->monto}','{$this->id_negocio}','$idusuario')";
            $result = $this->con->consultaSimple($sql);
        }


        return $result;
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM suscripcion WHERE idsuscripcion='$id'";
        $this->con->consultaSimple($sql);
    }

    public function ponerSuscripcionInactiva($idusuario)
    {
        $sql = "UPDATE negocios
        INNER JOIN suscripcion ON suscripcion.negocio_id=negocios.idnegocios
        INNER JOIN clientesab ON clientesab.id_clienteab=negocios.clientesab_idclienteab 
        INNER JOIN trabajador ON trabajador.negocios_idnegocios = negocios.idnegocios 
        SET suscripcion.fecha_activacion = '{$this->activacion}', suscripcion.fecha_vencimiento = '{$this->vencimiento}', 
        suscripcion.estado ='{$this->estado}',suscripcion.paquete='{$this->paquete}',suscripcion.usuario_extra='{$this->usextra}',suscripcion.monto='{$this->monto}',suscripcion.usuariosab_idusuariosab='$idusuario',
        clientesab.estado ='{$this->estado}', trabajador.estado='{$this->estado}'
        WHERE suscripcion.idsuscripcion='{$this->id}'";

        $result = $this->con->consultaSimple($sql);

        if ($result === 0) {
            $sql = "UPDATE suscripcion INNER JOIN negocios ON negocio_id = idnegocios INNER JOIN clientesab ON clientesab_idclienteab = id_clienteab  
                SET fecha_activacion = '{$this->activacion}',fecha_vencimiento = '{$this->vencimiento}' , suscripcion.estado ='{$this->estado}'
                ,clientesab.estado='{$this->estado}',suscripcion.paquete='{$this->paquete}',suscripcion.usuario_extra='{$this->usextra}', suscripcion.monto ='{$this->monto}',suscripcion.usuariosab_idusuariosab = '$idusuario'
                WHERE idsuscripcion = '{$this->id}'";
            $result = $this->con->consultaSimple($sql);
        }
        if ($result > 1) {
            $result = 1;
        }
        return $result;
    }

    public function ponerSuscripcionActiva($idusuario)
    {
        $sql = "UPDATE suscripcion INNER JOIN negocios ON negocio_id = idnegocios INNER JOIN clientesab ON clientesab_idclienteab = id_clienteab  
        SET fecha_activacion = '{$this->activacion}',fecha_vencimiento = '{$this->vencimiento}' , suscripcion.estado ='{$this->estado}'
        ,clientesab.estado='{$this->estado}',suscripcion.paquete='{$this->paquete}',suscripcion.usuario_extra='{$this->usextra}', suscripcion.monto ='{$this->monto}',suscripcion.usuariosab_idusuariosab = '$idusuario'
        WHERE idsuscripcion = '{$this->id}'";
        $result = $this->con->consultaSimple($sql);

        if ($result > 1) {
            $result = 1;
        }
        return $result;
    }

    public function __destruct()
    {
        $this->con->cerrarConexion();
    }
}
