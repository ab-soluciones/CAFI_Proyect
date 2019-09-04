<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (
    isset($_POST['DFecha']) && isset($_POST['DFecha2'])
    && isset($_POST['REstado']) && isset($_POST['TMonto'])
) {
    $id = $_POST['id_subs'];
    $sus = new Models\Suscripcion();
    $idusuario = $_SESSION['id'];
    $sus->setActivacion($_POST['DFecha']);
    $sus->setVencimiento($_POST['DFecha2']);
    $sus->setEstado($_POST['REstado']);
    $sus->setMonto($_POST['TMonto']);
    $result = $sus->editar($id, $idusuario);
    if ($result == 1) {
        header('Location: VSuscripcion.php');
     } else {
  
      }
}
